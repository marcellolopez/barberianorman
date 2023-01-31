<!-- Large Modal -->
<div class="modal fade" id="evento" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Reservar hora</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="reservarHora" method="POST" action="{{ url('reservarHora') }}">
        <div class="modal-body">
            @csrf
            <input id="reserva_id" name="reserva_id" type="hidden">
            <input id="modal_celular" name="modal_celular" type="hidden">
            <p class="fs-4 text-center">¿Deseas reservar para el día <strong id="fecha"></strong> a las <strong id="hora"></strong>?</p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-outline-primary" id="btnGuardar">Reservar</button>
          <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div><!-- End Small Modal-->
<script>


$(document).ready(function() {
    $('#main').backstretch([
      '{{ url("imagenes/barbershop-1612726-min.jpg") }}',
      '{{ url("imagenes/barbershop-4762345-min.jpg") }}',
      '{{ url("imagenes/barber-5194406-min.jpg") }}'
      ], {
        fade: 750,
        duration: 4000
    });
});
</script>
<script>
  var calendar = null;
  document.addEventListener('DOMContentLoaded', function() {

    let formulario = document.querySelector("form");

    var calendarEl = document.getElementById('calendar');
    var today = moment().day();
    calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'listDay',
      locale: 'es',
      headerToolbar: {
        left: 'prev',
        center: 'title',
        right: 'next',
      },      
      validRange: {
          start: '{{date('Y-m-d')}}'
      },
      select: function(start, end) {
          if(start.isBefore(moment())) {
              $('#calendar').fullCalendar('unselect');
              return false;
          }
      },
      //events: '{{ url("cargarAgenda") }}?barber_id=' + 
      eventSources: [
        {
          url: '{{ url("cargarAgenda") }}', // use the `url` property
          extraParams: function() { // a function that returns an object
            return {
              barber_id: $('#select_barbero').val()
            };
          }
        }
      ],
      eventDidMount: function(info) {
        if(info.event.title == "Ocupado") {
          info.el.children[1].children[0]['style'].border = 'calc(var(--fc-list-event-dot-width, 10px) / 2) solid #dc3545';
        }       
      },
      dateClick:function(info){

        $("#evento").modal("show");
      },
      eventClick: function(info) {
        if(info.event.title != "Ocupado") {
          
          $("#calendario").fadeOut(500);
          $("#alerta").delay(500).fadeIn(500);
          $('.fecha').text(info.event.extendedProps.start_fecha);
          $('.hora').text(info.event.extendedProps.start_hora);
          $('#reserva_id').val(info.event.id);

        }
      }
    });
    calendar.render();
  });
  


</script>
<script>
$( "#consultar_cliente" ).submit(function(e) {
    e.preventDefault();
    $.ajax({
        type: "post",
        url:'{{ url("consultarCliente") }}',
        data: {"_token": "{{ csrf_token() }}",'celular': $("#celular").val()},
        success: function (response) {
          $('#consultar').hide(500);
          
          if(response.status == 500){
            alertify.warning('¡Usuario nuevo! Complete sus datos');
            $('.datos').show(500);
            
          }
          else{
            if (response.reserva != null) {

              $('.fecha').text(response.reserva.start_fecha);
              $('.hora').text(response.reserva.start_hora);
              $('#reservado').delay(500).fadeIn(500);
            }
            else{
              $('#nombre').val(response.cliente.nombres).prop('disabled', 'true');
              $('#apellido').val(response.cliente.apellido_paterno).prop('disabled', 'true');
              $('.row-email').hide();
              $('.row-fecha_nacimiento').hide();
              $('.row-recordatorio').hide();
              $('#registrar').hide();
              $('#modal_celular').val($("#celular").val());
              $('#nombre_agendar').text(response.cliente.nombres);
              alertify.success('¡Usuario registrado!');
              $('#formulario_registro').fadeOut(500);
              $('#calendario').delay(500).fadeIn(500);
            }
          }
          
        },
        error: function (data) {
            console.log('Error:', data);
        },
        beforeSend: function() {
          $('#consultar').prop('disabled', true);
          $('#consultar').html(spinner());
        }
    });
});    
$( "#registrar_cliente" ).submit(function(e) {
    e.preventDefault();
    var recordatorio = 0;
    if ($('#recordatorio').is(":checked"))
    {
      recordatorio = 1;
    }
    $.ajax({
      type: "post",
      url:'{{ url("registrarCliente") }}',
      data: {
        "_token": "{{ csrf_token() }}",
        'celular': $("#celular").val(),
        'email': $("#email").val(),
        'nombre': $("#nombre").val(),
        'apellido': $("#apellido").val(),
        'fecha_nacimiento': $("#fecha_nacimiento").val(),
        'recordatorio': recordatorio
      },
      success: function (response) {
        
        if(response.status == 500){
          $('#registrar').prop('disabled', false);
          if(response.validate == false){
            $.each(response.errors, function(index, value) {
              alertify.warning(value);
            })
          }
          else{
            alertify.warning(response.mensaje);
          }
          $('#registrar').html('Registrar');

        }
        else{
          $('#registrar').hide(500);
          $("#celular").prop('disabled', true);
          $("#email").prop('disabled', true);
          $("#nombre").prop('disabled', true);
          $("#apellido").prop('disabled', true);
          $("#fecha_nacimiento").prop('disabled', true);
          $("#recordatorio").prop('disabled', true);
          $('#nombre_agendar').text($("#nombre").val());
          alertify.success('¡Usuario registrado!');
          $('#modal_celular').val($("#celular").val());
          
          $('#formulario_registro').fadeOut(500);
          $('#calendario').delay(500).fadeIn(500);
        }
      },
      error: function (data) {
          console.log('Error:', data);
      },
      beforeSend: function() {
        $('#registrar').prop('disabled', true);
        $('#registrar').html(spinner());
      }
    });
    
}); 
$( "#reservarHora" ).submit(function(e) {
    e.preventDefault();
    $.ajax({
        type: "post",
        url:'{{ url("reservarHora") }}',
        data: {
          "_token": "{{ csrf_token() }}",
          'id': $("#reserva_id").val(),
          'celular': $("#modal_celular").val()
        },
        success: function (response) {
          if(response.status == 500){
            alertify.warning(response.mensaje);
          }
          else{
            alertify.success('¡Su reserva se ha registrado con éxito!');
            console.log(calendar);
            calendar.refetchEvents();
            $('#info').delay(500).fadeIn(500);
            
          }
        },
        error: function (data) {
            console.log('Error:', data);
        },
        beforeSend: function() {
          $('#alerta').fadeOut(500);
          

          $('#consultar').prop('disabled', true);
          $('#consultar').html(spinner());
        }
    });
}); 
</script>
<script>
$(document).ready(function() {
  $(".div-calendario").animate({height: "hide"},500);

  $('#select_barbero').on('change', function() {

    var $barber_id = $('#select_barbero').val();
    $(".div-calendario").animate({height: "hide"},500); 
    
    if($barber_id != 0){
      calendar.refetchEvents();
      $(".div-calendario").delay(500).animate({height: "show"},500); 
    }

  });

  $( "#btn-cancelar" ).click(function(e){
    $('#alerta').fadeOut(500);
    $('#calendario').delay(500).fadeIn(500);
  });

});
</script>

<style> 
@media screen and (max-width:767px) { .fc-toolbar.fc-header-toolbar {font-size: 55%}}

.fc-daygrid-event{
  font-size:  5x !important;
}

.fc-toolbar-title{
  font-size:  22px !important;
}

</style>
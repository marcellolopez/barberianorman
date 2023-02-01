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
@if($barber_id != null)
<script>
  var calendar = null;
  document.addEventListener('DOMContentLoaded', function() {

    let formulario = document.querySelector("form");

    var calendarEl = document.getElementById('calendar');
    var today = moment().day();
    calendar = new FullCalendar.Calendar(calendarEl, 
    {
      initialView: 'listDay',
      locale: 'es',
      headerToolbar: {
        left: 'prev',
        center: 'title',
        right: 'next'
      },
      validRange: {
          start: '{{date('Y-m-d h:i:s')}}'
      },
      select: function(start, end) {
          if(start.isBefore(moment())) {
              $('#calendar').fullCalendar('unselect');
              return false;
          }
      },
      events: {
          url: '{{ url("cargarAgendaBarbero") }}?barber_id={{$barber_id}}'
      },
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
          $('#evento').modal('show');
          console.log(info.event.extendedProps);
          $('#fecha').text(info.event.extendedProps.start_fecha);
          $('#hora').text(info.event.extendedProps.start_hora);
          $('#reserva_id').val(info.event.id);

        }
      }
    });
    calendar.render();
  });
function subtractDays(date, days) {
  date.setDate(date.getDate() - days);

  return date;
}

document.addEventListener('DOMContentLoaded', function() {
  var calendar_dias_el = document.getElementById('calendar_dias');

  var calendar_dias = new FullCalendar.Calendar(calendar_dias_el, {
    locale: 'es',
    selectable: true,
    initialView: 'dayGridWeek',
    headerToolbar: {
        left: 'prev',
        center: 'title',
        right: 'next'
    },
    dateClick: function(info) {
      
    },
    select: function(info) {
      end = subtractDays(info.end, 1);

      axios.post('{{ url("guardarProgramacionBarbero") }}', {
        _token: '{{ csrf_token() }}',
        barber_id: {{$barber_id}},
        info: info
      })
      .then(function (response) {
        alertify.success('¡Su horas se han programado con éxito!');
        calendar.refetchEvents();
        calendar_dias.refetchEvents();
      })
      .catch(function (error) {
        console.log(error);
      });

    },
    validRange: {
      start: '{{date('Y-m-d h:i:s')}}'
    },
    events: {
      url: '{{ url("cargarProgramacionBarbero") }}?barber_id={{$barber_id}}'
    },
    minTime: "11:00:00",
    maxTime: "18:00:00",
    eventDidMount: function(info) {
      if(info.event.title == "Ocupado") {

        /*info.el.children[1].children[0]['style'] = 'calc(var(--fc-list-event-dot-width, 10px) / 2) solid #dc3545';          */
      }

    }
  });
  

  $('#btnProgramacion').click(function() {
    calendar_dias.render();
    calendar_dias.refetchEvents();
  });
});

</script>
<script>
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
            alertify.warning('Error en la plataforma');
          }
          else{
            $('#registrar').hide(500);
            $("#celular").prop('disabled', true);
            $("#email").prop('disabled', true);
            $("#nombre").prop('disabled', true);
            $("#apellido").prop('disabled', true);
            $("#fecha_nacimiento").prop('disabled', true);
            $("#recordatorio").prop('disabled', true);
            alertify.success('¡Usuario registrado!');
            $('#modal_celular').val($("#celular").val());
            $('#calendario').fadeIn(500);
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
            alertify.warning('Error al registrar reserva');
          }
          else{
            alertify.success('¡Su reserva se ha registrado con éxito!');
            calendar.refetchEvents();
            calendar_dias.render();
            calendar_dias.refetchEvents();
            $('#btnProgramacion').click();
            
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
</script>
<style> 
@media screen and (max-width:767px) { 
  .fc-toolbar.fc-header-toolbar {
    font-size: 55%;

  }
}

@media screen and (min-width:768px) { 
  .fc-toolbar.fc-header-toolbar {
    font-size: 70%; 
    margin-top: 5px;
  }
}
.fc-daygrid-event{
  font-size:  5x !important;
}

.fc-toolbar-title{
  font-size:  20px !important;
}

</style>
@endif
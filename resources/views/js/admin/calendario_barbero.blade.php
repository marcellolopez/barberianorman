<script>
$(document).ready(function() {
    $('#main').backstretch([
      '{{ url("imagenes/back01.jpeg") }}',
      '{{ url("imagenes/back02.jpeg") }}',
      '{{ url("imagenes/back03.jpeg") }}'
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
      /*/
      validRange: {
          start: '{{date('Y-m-d h:i:s')}}'
      },
      /*/
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
        if(info.event.title == "Ocupado" || info.event.title == "Ocupado (C)") {
          info.el.children[1].children[0]['style'].border = 'calc(var(--fc-list-event-dot-width, 10px) / 2) solid #dc3545';          
        }
        if(info.event.title == "Asiste") {
          info.el.children[1].children[0]['style'].border = 'calc(var(--fc-list-event-dot-width, 10px) / 2) solid green';          
        }         
      },
      dateClick:function(info){

        $("#evento").modal("show");
      },
      eventClick: function(info) {
        if(info.event.title == "Ocupado" || info.event.title == "Ocupado (C)" || info.event.title == "Asiste") {
          
          $('#label-nombre').text(info.event.extendedProps.nombre_completo);
          $('#label-telefono').text(info.event.extendedProps.telefono);
          
          if(info.event.extendedProps.comentario != ''){
            $('#div-comentario').show();
            $('#label-comentario').text(info.event.extendedProps.comentario);
          }
          else{
            $('#div-comentario').hide();
          }
          
          $('#reserva_id').text(info.event.extendedProps.reserva_id);
          $('#modal-body').show();
          $('#modal-footer').show();
          $('#optionBloq').text('Bloquear');
        }
        else if(info.event.title == "Bloqueada"){
          $('#optionBloq').text('Desbloquear');
        }
        else{
          $('#modal-body').hide();
          $('#modal-footer').show();
          $('#optionBloq').text('Bloquear');
        }
        $('#evento').modal('show');
        console.log(info.event.extendedProps);
        $('#fecha').text(info.event.extendedProps.start_fecha);
        $('#hora').text(info.event.extendedProps.start_hora);
        $('#modal_reserva_id').val(info.event.extendedProps.reserva_id);
        $('#actualizarHora').trigger("reset");
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
      if(info.event.title == "Ocupado" || info.event.title == "Ocupado (C)") {

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
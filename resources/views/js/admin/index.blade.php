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
</div>
<!-- End Small Modal-->
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
$(document).ready(function() {
  $('#select_barbero').on('change', function() {
    var $barber_id = $('#select_barbero').val();
    if($barber_id != 0){
      window.location.replace("{{url('admin/index')}}?barber_id="+$barber_id);
    }
  });

  $( "#registrar_barbero" ).submit(function(e) {
      e.preventDefault();
      $.ajax({
          type: "post",
          url:'{{ url("actualizarBarbero") }}',
          data: $(this).serialize(),
          success: function (response) {  
            if(response.status == 500){
              if(response.validate == false){
                $.each(response.errors, function(index, value) {
                  alertify.warning(value);
                })
              }
              else{
                alertify.warning(response.mensaje);
              }
            }
            else{
              alertify.success('¡Barbero actualizado!');
            }
          },
          error: function (data) {
              console.log('Error:', data);
          },
          beforeSend: function() {
          }
      });
  }); 
});
</script>

<!-- Large Modal -->
<div class="modal fade" id="evento" tabindex="-1">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Hora</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body" id="modal-body">
            <form action="" class="text-center">
              <div class="row mb-3">
                <label for="inputText" class="col-4 col-form-label">Nombre</label>
                <div class="col-8 col-form-label">
                  <label id="label-nombre" for="inputText"></label>
                </div>
              </div>
              <div class="row mb-3">
                <label for="inputText" class="col-4 col-form-label">Teléfono</label>
                <div class="col-8 col-form-label">
                  <label id="label-telefono" for="inputText"></label>
                </div>
              </div>             
            </form>
            @csrf
            <input id="reserva_id" name="reserva_id" type="hidden">
            <input id="modal_celular" name="modal_celular" type="hidden">
        </div>
        <div class="modal-footer">
          <form id="actualizarHora" name="actualizarHora" class="col-12" method="post" >
            <div class="text-center ">
              <label for="inputNumber" class="col-form-label">¿Qué deseas hacer con esta hora?</label>
            </div>
            <input type="hidden" id="modal_reserva_id" >
            <div class="text-center">
              <select class="form-select" id="accion" aria-label="" required>
                <option value="0">Elige una opción</option>
                <option value="1">Liberar</option>
                <option value="2">Eliminar</option>
                <option value="3">Bloquear</option>
              </select>
            </div>
            <div class="text-center mt-3">
              <button type="submit" class="btn btn-outline-dark btn-block input-block-level">
                Actualizar
              </button>
            </div>            
          </form>
        </div>
    </div>
  </div>
</div>


<script>
$(document).ready(function() {
  $('#select_barbero').on('change', function() {
    var $barber_id = $('#select_barbero').val();
    if($barber_id != 0){
      window.location.replace("{{url('admin/index')}}?barber_id="+$barber_id);
    }
  });

  $( "#actualizarHora" ).submit(function(e) {
    
      e.preventDefault();
      $.ajax({
          type: "post",
          url:'{{ url("actualizarHora") }}',
          data: {
            "_token": "{{ csrf_token() }}",
            'id': $("#accion").val(),
            'reserva_id': $("#modal_reserva_id").val(),
          },
          success: function (response) {  
            if(response.status == 500){
              alertify.warning('Error al actualizar');
            }
            else{
              alertify.success('¡Hora actualizada!');
            }
            calendar.render();
            calendar.refetchEvents();
            $('#evento').modal('hide');

            $('#spinner-div').hide();
          },
          error: function (data) {
              console.log('Error:', data);
               $('#spinner-div').hide();
          },
          beforeSend: function() {
             $('#spinner-div').show();
          }
      });
  }); 
});
</script>

@extends('administrador.profile.layout')
@section('titulo', 'Norman Barbería - Registros')
@section('item-raiz', 'Perfil')
@section('item-titulo', 'Norman Barbería - Registros')
@section('content')
<section class="section vh-100">
  <div id="formulario" class="col-lg-12">
    <div class="row">
      <div class="col-lg-12">
        <div class="card special-card">
          <div class="card-body">
            <h5 class="card-title">Registros</h5>
            <div class="row d-flex justify-content-center mt-2">
              <div class="col-md-12">
                <div class="table-container table-responsive">
                  <table id="clientes" class="table table-sm table-striped compact">
                    <thead>
                      <tr class="table-secondary">
                        <th scope="col">Nombre Completo</th>
                        <th scope="col">Fecha de nacimiento</th>
                        <th scope="col">Email</th>
                        <th scope="col">Celular</th>
                        <th scope="col">Cantidad de reservas</th>
                        <th scope="col">Última reserva</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Modal -->
<div class="modal fade" id="historialModal" tabindex="-1" aria-labelledby="historialModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="historialModalLabel">Historial de Reservas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="historialContent">Cargando...</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('jsScripts')
@include('js.funciones')
<script>
$(document).ready(function() {
    var table = $("#clientes").DataTable({
        language: {
            search: "",
            searchPlaceholder: "Buscar...",
            paginate: {
                first:    "Primera",
                previous: "Anterior",
                next:   "Siguiente",
                last:     "Última"
            },
            sLengthMenu:  "Mostrar _MENU_ registros",
            sInfoEmpty:   "Del 0 al 0 de 0 registros",
            sInfoFiltered:  "(filtrado de _MAX_ registros)",
            sZeroRecords: "<h5><b>No se encontraron resultados</b></h5>",
            sEmptyTable:  "<h5><b></b></h5>",
            sInfo:      "Del _START_ al _END_ de _TOTAL_ registros",
            processing:   "Cargando"
        },
        serverSide: false,
        ajax: {
            url: "/{{$url}}",
            type: "GET",
            datatype: "json",
            error: function (x,y,z){
                console.log(x,y,z);
            }
        },
        columns:[
            { data: 'nombre_completo', name: 'nombre_completo'},
            { data: 'fecha_nacimiento', name: 'fecha_nacimiento'},
            { data: 'email', name: 'email'},
            { data: 'celular', name: 'celular'},
            { data: 'reservas_count', name: 'reservas_count'},
            { data: 'ultima_reserva', name: 'ultima_reserva'},
        ],
        columnDefs: [
            {
                'targets': 0,
                render: function(data, type, row) {
                    if(row.reservas_count > 0){
                        return '<a href="#" class="view-historial" data-id="' + row.id + '">' + data + '</a>';
                    } else {
                        return data;
                    }
                }
            },
            { type: 'date-uk', targets: 1 },
        ],
        drawCallback: function() {
            $("span.infoPaciente").popover({
                trigger: "hover",
                placement: "right",
                html: true
            });
        },
        order: [[ 5, "desc" ]]
    });

    $('#clientes').on('click', '.view-historial', function(e) {
        e.preventDefault();
        var clientId = $(this).data('id');
        $('#historialContent').html('Cargando...');
        $('#historialModal').modal('show');

        $.ajax({
            url: '/admin/cliente/historial/' + clientId,
            type: 'GET',
            success: function(data) {
                $('#historialContent').html(data);
            },
            error: function(xhr, status, error) {
                $('#historialContent').html('<p>Ha ocurrido un error al cargar el historial.</p>');
            }
        });
    });
});
</script>
@endsection

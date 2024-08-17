@extends('administrador.profile.layout')
@section('titulo', 'Norman Barbería - Registros de servicios')
@section('item-raiz', 'Perfil')
@section('item-titulo', 'Norman Barbería - Registros de servicios')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <section class="section vh-100">
      <div id="formulario" class="col-lg-12">
          <div class="row">
              <div class="col-lg-12">
                  <div class="card special-card">
                      <div class="card-body">
                          <div class="d-flex justify-content-between align-items-center">
                              <h5 class="card-title">Registros de servicios</h5>
                              <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                                  <i class="fas fa-plus"></i>
                              </button>
                          </div>
                          <div class="row d-flex justify-content-center mt-2">
                              <div class="col-md-12">
                                  <div class="table-container table-responsive">
                                      <table id="clientes" class="table table-sm table-striped compact">
                                          <thead>
                                              <tr class="table-secondary">
                                                  <th scope="col">Nombre</th>
                                                  <th scope="col">Precio</th>
                                                  <th scope="col">Orden</th>
                                                  <th scope="col">Acciones</th>
                                              </tr>
                                          </thead>
                                          <tbody></tbody>
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
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Servicio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        @csrf
                        <div class="form-group">
                            <label for="editNombre">Nombre</label>
                            <input type="text" class="form-control" id="editNombre" name="nombre">
                        </div>
                        <div class="form-group">
                            <label for="editPrecio">Precio</label>
                            <input type="number" class="form-control" id="editPrecio" name="precio">
                        </div>
                        <input type="hidden" id="editId" name="id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="editForm" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Agregar Servicio -->
    <div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addServiceModalLabel">Agregar Nuevo Servicio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form id="addServiceForm">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="nombre">Nombre del Servicio</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="precio">Precio del Servicio</label>
                            <input type="number" class="form-control" id="precio" name="precio" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar Servicio</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('jsScripts')
  @include('js.funciones')
  <style>
    /* Estilo de fila por defecto */
    #clientes tbody tr {
        transition: background-color 0.3s ease; /* Transición suave */
    }

    /* Estilo de fila cuando se pasa el mouse sobre ella */
    #clientes tbody tr:hover {
        background-color: #e0e0e0; /* Color de fondo sutil más fuerte */
        cursor: pointer; /* Cursor de mano */
    }
  </style>
<script>
$(document).ready(function() {
    var table = $("#clientes").DataTable({
        rowReorder: {
            dataSrc: 'orden' // Configurar para arrastrar según la columna 'orden'
        },
        
        order: [[2, 'asc']], // Ordenar por la columna 'orden'
        columnDefs: [
            { orderable: false, targets: [0,1,3] } // Desactiva el ordenamiento en la columna 3 (índice basado en 0)
        ],
        searching: false, // Desactiva la búsqueda
        paging: false, // Desactiva la paginación
        info: false, // Desactiva la información de la tabla (del _START_ al _END_ de _TOTAL_ registros)
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
            error: function (x, y, z){
                console.log(x, y, z);
            }
        },
        columns:[
            { data: 'nombre', name: 'nombre'},
            {
                data: 'precio',
                name: 'precio',
                render: function (data, type, row) {
                    return new Intl.NumberFormat('es-CL', { style: 'currency', currency: 'CLP' }).format(data);
                }
            },
            { data: 'orden', name: 'orden'},
            {
                data: null,
                render: function (data, type, row) {
                  return `
                      <button class="btn btn-sm btn-primary edit-btn" data-id="${row.id}">
                          <i class="fas fa-edit"></i>
                      </button>
                      <button class="btn btn-sm btn-danger delete-btn" data-id="${row.id}">
                          <i class="fas fa-trash"></i>
                      </button>
                  `;
                }
            }
        ],
    });

    // Capturar el evento de reordenamiento
    table.on('row-reorder', function (e, details, changes) {
        var orderedData = [];

        details.forEach(function (item) {
            orderedData.push({
                id: table.row(item.node).data().id, // Aquí obtén el ID del registro
                orden: item.newData // Nuevo orden
            });
        });

        // Hacer una petición Ajax para actualizar el orden en la base de datos
        $.ajax({
            url: '/admin/actualizar-orden', // Ruta para actualizar el orden en tu controlador
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}', // Asegúrate de incluir el token CSRF
                ordenData: orderedData
            },
            success: function(response) {
                console.log("Orden actualizado con éxito.");
            },
            error: function(xhr, status, error) {
                console.log("Error al actualizar el orden.");
            }
        });
    });
    $('#addServiceForm').on('submit', function(e) {
        e.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            url: '/admin/agregar-servicio',
            type: 'POST',
            data: formData,
            success: function(response) {
                alertify.success('Servicio agregado correctamente');
                $('#addServiceModal').modal('hide');
                $('#clientes').DataTable().ajax.reload(); // Recargar la tabla
            },
            error: function(xhr, status, error) {
                alertify.error('Error al agregar el servicio');
            }
        });
    });
    $(document).on('click', '.edit-btn', function() {
        var id = $(this).data('id');

        // Realizar una solicitud Ajax para obtener los datos actuales del servicio
        $.ajax({
            url: '/admin/obtener-servicio/' + id, // Ruta para obtener los datos del servicio
            method: 'GET',
            success: function(data) {
                // Llenar el formulario con los datos obtenidos
                $('#editId').val(data.id);
                $('#editNombre').val(data.nombre);
                $('#editPrecio').val(data.precio);
                // Mostrar el modal
                $('#editModal').modal('show');
            }
        });
    });
    $('#editForm').submit(function(e) {
        e.preventDefault();

        var formData = $(this).serialize(); // Obtener los datos del formulario

        // Realizar una solicitud Ajax para actualizar los datos
        $.ajax({
            url: '/admin/actualizar-servicio', // Ruta para actualizar el servicio
            method: 'POST',
            data: formData,
            success: function(response) {
                $('#editModal').modal('hide'); // Cerrar el modal
                $('#clientes').DataTable().ajax.reload(); // Recargar la tabla
            },
            error: function(xhr, status, error) {
                console.log("Error al actualizar el servicio.");
            }
        });
    });
    $(document).on('click', '.delete-btn', function() {
        var serviceId = $(this).data('id');
        
        alertify.confirm('Confirmar eliminación', '¿Estás seguro de que deseas eliminar este servicio?',
            function() {
                // Si se confirma, realiza la eliminación
                $.ajax({
                    //agrega csrf de laravel
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: `/admin/eliminar-servicio/${serviceId}`,
                    type: 'DELETE',
                    success: function(response) {
                        alertify.success('Servicio eliminado');
                        // Actualiza el orden o recarga la tabla
                        $('#clientes').DataTable().ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        alertify.error('Ocurrió un error al eliminar el servicio');
                    }
                });
            },
            function() {
                alertify.error('Eliminación cancelada');
            }
        );
    });
});


</script>
@endsection
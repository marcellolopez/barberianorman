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
@endsection

@section('jsScripts')
  @include('js.funciones')
<script>
        $(document).ready(function() {
            $("#clientes").DataTable({
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
                ajax: {"url":"/{{$url}}",
                    "type":"GET",
                    "datatype":"json",
                    "error": function (x,y,z){
                        console.log(x,y,z);
                    }
                },
                columns:[
                    { data: 'nombre_completo', name: 'nombre_completo'},
                    { data: 'fecha_nacimiento', name: 'fecha_nacimiento'},
                    { data: 'email', name: 'email'},
                    { data: 'celular', name: 'celular'},
                ],
                /*
                columnDefs: [
                    { type: 'date-uk', targets: 1 },
                    {
                        'targets': 8,
                        render: function(data, type, row) {
                            if(row.id_proceso_estado_bono && row.idConvenio == 3 && row.id_proceso_estado_bono == 20){
                                return '<a class="btn btn-warning btn-sm" role="button" aria-pressed="true" onclick="habilitarBono(\''+row.idRegBono+'\')" href="#"> <i class="fas fa-redo-alt"></i> Reutilizar bono </a> ';
                            }else{
                                return row.descripcion_medio_pago;
                            }
                        }
                    },
                    {
                        'targets': 11,
                        render: function(data, type, row) {
                            if(row.idRegBono != null){
                                return '<a class="btn btn-primary btn-sm" role="button" aria-pressed="true" onclick="getBonoFile(this, \''+row.idRegBono+'\')" href="#"> <i class="far fa-eye"></i> </a> ';
                            }else if( [1,4,6].includes(row.id_medio_pago) && row.idsede != 10) {
                                return '<a class="btn btn-success btn-sm" role="button" aria-pressed="true" onclick="getComprobantePago(this, \''+row.idHora+'\', \''+row.id_medio_pago+'\')" href="#"> <i class="far fa-eye"></i> </a> ';
                            } else {
                                return row.idRegBono;
                            }
                        }
                    },
                ],

                drawCallback: function() {
                    $("span.infoPaciente").popover({
                        trigger: "hover",
                        placement: "right",
                        html: true
                    });
                },
                order: [[ 10, "desc" ]]
                */
            });

        });

</script>
@endsection
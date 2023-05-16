@extends('usuario.profile.layout')
@section('titulo', 'Norman Barbería - Reservar')
@section('item-raiz', 'Perfil')
@section('item-titulo', 'Norman Barbería - Reservar')
@section('content')
    <section class="section vh-100">
      <div id="formulario" class="col-lg-10 offset-lg-1">
        <div class="row">
          <div id="formulario_registro" class="col-lg-6 offset-lg-3 ">
            <div class="card special-card">
              <div class="card-body">
                <h1 class="card-title display-2 text-center text-black d-none">Bienvenido</h1>
                <img src="imagenes/logo-grande.png" class="d-none d-sm-block rounded mx-auto d-block w-25 m-4" alt="...">
                <img src="imagenes/logo-grande.png" class="d-block d-sm-none rounded mx-auto d-block w-50 m-4" alt="...">
                <p class="text-center h5 text-black mb-3">Has la reserva ingresando tus datos</p>

                <!-- General Form Elements -->
                <form id="consultar_cliente" name="consultar_cliente" method="post" >
                  <div class="row mb-3">
                    <label for="inputNumber" class="col-sm-4 col-form-label">Móvil</label>
                    <div class="col-sm-8">
                      <div class="col-sm-8 input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">+56</span>
                        <input id="celular" name="celular" type="text" class="form-control" minlength="9" maxlength="9"   required>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-12 text-center">
                      <button id="consultar" name="consultar" type="submit" class="btn btn-outline-dark btn-block input-block-level">Continuar</button>
                    </div>
                  </div>
                </form><!-- End General Form Elements -->
                <form id="registrar_cliente" name="registrar_cliente" method="post" >
                  <div class="datos" style="display: none;">
                    <div class="row mb-3">
                      <label for="inputText" class="col-sm-4 col-form-label">Nombre</label>
                      <div class="col-sm-8">
                        <input id="nombre" name="nombre" type="text" class="form-control" required>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="inputText" class="col-sm-4 col-form-label">Apellido</label>
                      <div class="col-sm-8">
                        <input  id="apellido" name="apellido" type="text" class="form-control" required>
                      </div>
                    </div>                
                    <div class="row mb-3 row-email">
                      <label for="inputEmail" class="col-sm-4 col-form-label">Email</label>
                      <div class="col-sm-8">
                        <input  id="email" name="email" type="email" class="form-control" required>
                      </div>
                    </div>
                    <div class="row mb-3 row-fecha_nacimiento">
                      <label for="inputDate" class="col-sm-4 col-form-label">Fecha de nacimiento</label>
                      <div class="col-sm-8">
                        <input  id="fecha_nacimiento" name="fecha_nacimiento" type="date" class="form-control" required>
                      </div>
                    </div>
                    <div class="row mb-3 row-recordatorio">
                      <div class="col-sm-12">
                        <div class="form-check">
                          <input  id="recordatorio" name="recordatorio" class="form-check-input" type="checkbox" >
                          <label class="form-check-label" for="gridCheck1">
                            Deseo recibir recordatorios previos a mi atención
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-sm-12 text-center">
                        <button id="registrar" type="submit" class="btn btn-outline-dark btn-block input-block-level">Registrarse</button>
                      </div>
                    </div>
                  </div>

                </form><!-- End General Form Elements -->

              </div>
            </div>
          </div>
          <div id="calendario" class="col-lg-6 offset-lg-3" style="display: none;">
            <div class="card special-card">
              <div class="card-body mt-2">
                <h5 class="card-title d-none">Agenda</h5>
                <p class="text-center mt-2"><strong id="nombre_agendar">Marcello</strong>, selecciona un barbero y luego reserva tu hora</p>
                <!-- General Form Elements -->
                <div class="row mb-3 mt-1">
                  <div class="offset-lg-3 col-lg-6">
                    <select class="form-select" id="select_barbero" aria-label="">
                      <option value="0" >Seleccione un barbero</option>
                      @foreach($barberos as $b)
                        <option value="{{$b->id}}" {{$b->id == $barber_id ? 'selected' : ''}}>{{$b->nombres}} {{$b->apellido_paterno}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="div-calendario">
                  <div id='calendar' class="calendar mt-1" style=""></div>
                </div>
              </div>
            </div>
          </div>
          <div id="alerta" class="col-lg-6 offset-lg-3" style="display: none;">
            <div class="card special-card">
              <div class="card-body mt-2">
                <h5 class="card-title d-none">Agenda</h5>
                <!-- General Form Elements -->
                <div class="row mb-3 mt-1">
                  <form id="reservarHora" method="POST" action="{{ url('reservarHora') }}">
                    <div class="modal-body">
                        @csrf
                        <input id="reserva_id" name="reserva_id" type="hidden">
                        <input id="modal_celular" name="modal_celular" type="hidden">
                        <p class="text-center">¿Deseas reservar para el día <strong class="fecha"></strong> a las <strong class="hora"></strong>?</p>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn btn-outline-primary" id="btnGuardar">Reservar</button>
                      <button id="btn-cancelar" type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div id="info" class="col-lg-6 offset-lg-3" style="display: none;">
            <div class="card special-card">
              <div class="card-body mt-2">
                <div class="row mb-3 mt-1">
                  <div class="modal-body">
                    
                    <h3  class="text-center">¡Tu reserva ha sido realizada!</h3>
                    <p class="text-center">Te esperamos el día <strong class="fecha"></strong> a las <strong class="hora"></strong>.</p>
                    <p class="text-center">Se solicita puntualidad</p>
                    <p class="text-center text-muted">Si deseas cancelar tu reserva, llama al +56 9 8282 3855</p>
                    <br>
                    <p id="contador" class="text-center fw-bold"></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="reservado" class="col-lg-6 offset-lg-3" style="display: none;">
            <div class="card special-card">
              <div class="card-body mt-2">
                <div class="row mb-3 mt-1">
                  <div class="modal-body">
                    <p class="text-center">Tienes una reserva el día <strong class="fecha"></strong> a las <strong class="hora"></strong>.</p>
                    <p class="text-center">Se solicita puntualidad</p>
                    <p class="text-center text-muted">Si deseas cancelar tu reserva, llama al +56 9 8282 3855</p>
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
  @include('js.agenda')
@endsection
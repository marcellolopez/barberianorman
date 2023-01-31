@extends('administrador.profile.layout')
@section('titulo', 'Norman Barbería - Reservar')
@section('item-raiz', 'Perfil')
@section('item-titulo', 'Norman Barbería - Reservar')
@section('content')
    <section class="section vh-100">
      <div id="formulario" class="col-lg-10 offset-lg-1">
        <div class="row">
          <div class="col-lg-5">
            <div class="card special-card">
              <div class="card-body">
                <h5 class="card-title">Registro de usuario</h5>

                <!-- General Form Elements -->
                <form id="consultar_cliente" name="consultar_cliente" method="post" >
                  <div class="row mb-3">
                    <label for="inputNumber" class="col-sm-4 col-form-label">Teléfono</label>
                    <div class="col-sm-8">
                      <div class="col-sm-8 input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">+56</span>
                        <input id="celular" name="celular" type="text" class="form-control" minlength="9" maxlength="9"   required>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-12 text-center">
                      <button id="consultar" name="consultar" type="submit" class="btn btn-outline-dark btn-block input-block-level">Consultar</button>
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
                        <button id="registrar" type="submit" class="btn btn-outline-dark btn-block input-block-level">Registrar</button>
                      </div>
                    </div>
                  </div>

                </form><!-- End General Form Elements -->

              </div>
            </div>
          </div>
          <div id="calendario" class="col-lg-7" style="display: none;">
            <div class="card special-card">
              <div class="card-body mt-2">
                <h5 class="card-title">Agenda</h5>

                <!-- General Form Elements -->
                  <div class="row mb-3 mt-1">
                    <label for="inputNumber" class="col-sm-4 col-form-label">Barbero</label>
                    <div class="col-sm-8">
                      <select class="form-select" id="select_barbero" aria-label="">
                        <option value="0" >Seleccione un barbero</option>
                        @foreach($barberos as $b)
                          <option value="{{$b->id}}" {{$b->id == $barber_id ? 'selected' : ''}}>{{$b->nombres}} {{$b->apellido_paterno}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                <div id='calendar' class="calendar mt-1"></div>
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
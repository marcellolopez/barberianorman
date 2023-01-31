@extends('administrador.profile.layout')
@section('titulo', 'Norman Barbería - Reservar')
@section('item-raiz', 'Perfil')
@section('item-titulo', 'Norman Barbería - Reservar')
@section('content')
    <section class="section vh-100">
      <div id="formulario" class="col-lg-10 offset-lg-1">
        <div class="row">
          <div class="col-lg-5">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Seleccione barbero</h5>

                <!-- General Form Elements -->
                <form id="consultar_cliente" name="consultar_cliente" method="post" >
                  <div class="row mb-3">
                    <label for="inputNumber" class="col-sm-4 col-form-label">Teléfono</label>
                    <div class="col-sm-8">
                      <select class="form-select" id="select_barbero" aria-label="">
                        <option value="0" >Seleccione un barbero</option>
                        @foreach($barberos as $b)
                          <option value="{{$b->id}}" {{$b->id == $barber_id ? 'selected' : ''}}>{{$b->nombres}} {{$b->apellido_paterno}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </form><!-- End General Form Elements -->
                @if($barbero != null)
                  <form id="registrar_barbero" name="registrar_barbero" method="post" >
                    @csrf
                    <input type="hidden" id="barber_id" name="barber_id" value="{{$barbero->id}}">
                    <div class="row mb-3">
                      <label for="inputNumber" class="col-sm-4 col-form-label">Teléfono</label>
                      <div class="col-sm-8">
                        <div class="col-sm-8 input-group mb-3">
                          <span class="input-group-text" id="basic-addon1">+56</span>
                          <input id="celular" name="celular" type="text" class="form-control" minlength="9" maxlength="9" value="{{$barbero->celular}}"   required>
                        </div>
                      </div>
                    </div>
                    <div class="datos">
                      <div class="row mb-3">
                        <label for="inputText" class="col-sm-4 col-form-label">Nombre</label>
                        <div class="col-sm-8">
                          <input id="nombre" name="nombre" type="text" class="form-control" value="{{$barbero->nombres}}" required>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="inputText" class="col-sm-4 col-form-label">Apellido</label>
                        <div class="col-sm-8">
                          <input  id="apellido_paterno" name="apellido_paterno" type="text" class="form-control" value="{{$barbero->apellido_paterno}}" required>
                        </div>
                      </div>                
                      <div class="row mb-3 row-email">
                        <label for="inputEmail" class="col-sm-4 col-form-label">Email</label>
                        <div class="col-sm-8">
                          <input  id="email" name="email" type="email" class="form-control" value="{{$barbero->email}}" required>
                        </div>
                      </div>
                      <div class="row mb-3 row-fecha_nacimiento">
                        <label for="inputDate" class="col-sm-4 col-form-label">Fecha de nacimiento</label>
                        <div class="col-sm-8">
                          <input  id="fecha_nacimiento" name="fecha_nacimiento" type="date" class="form-control" value="{{$barbero->fecha_nacimiento}}" required>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col-sm-12 text-center">
                          <button id="registrar" type="submit" class="btn btn-outline-dark btn-block input-block-level">Actualizar</button>
                        </div>
                      </div>
                    </div>

                  </form><!-- End General Form Elements -->                    
                @endif


              </div>
            </div>
          </div>
          <div id="calendario" class="col-lg-7" style="display: block;">
            <div class="card">
              <div class="card-body mt-2">
                <div class="container" style="margin-top: 10px;">
                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs">
                    <li class="nav-item">
                      <a class="nav-link active" data-bs-toggle="tab" href="#msg">Agenda</a>
                    </li>
                    <li class="nav-item">
                      <a id="btnProgramacion" class="nav-link" data-bs-toggle="tab" href="#pro">Programación</a>
                    </li>
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div class="tab-pane container active" id="msg">
                      <div id='calendar' class="calendar"></div> 
                    </div>
                    <div class="tab-pane container fade" id="pro">
                      <div id='calendar_dias' class="calendar_dias"></div>
                    </div>
                    <div class="tab-pane container fade" id="set">This is a setting tab.</div>
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
  @include('js.admin.index')
  @include('js.admin.calendario_barbero')
@endsection
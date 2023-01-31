@extends('usuario.profile.layout')
@section('titulo', 'Norman Barbería - Reservar')
@section('item-raiz', 'Perfil')
@section('item-titulo', 'Norman Barbería - Reservar')
@section('content')
    <section class="section">
      <div class="col-lg-10 offset-lg-1">
        <div class="row">
          <div class="col-lg-5">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title"></h5>

                <!-- General Form Elements -->
                <form>
                  <div class="row mb-3">
                    <div class="row mb-3">
                      <div class="col-sm-12">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="gridCheck1">
                          <label class="form-check-label" for="gridCheck1">
                            Corte de pelo sin degradado
                          </label>
                          <label class=" text-right text-muted" for="gridCheck1">
                            30 min
                          </label>
                        </div>
                      </div>
                    </div>         
                    <div class="row mb-3">
                      <div class="col-sm-12">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="gridCheck1">
                          <label class="form-check-label" for="gridCheck1">
                            Corte de pelo con degradado
                          </label>
                          <label class=" float-right text-muted" for="gridCheck1">
                            45 min
                          </label>
                        </div>
                      </div>
                    </div>    
                    <div class="row mb-3">
                      <div class="col-sm-12">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="gridCheck1">
                          <label class="form-check-label" for="gridCheck1">
                            Afeitado normal
                          </label>
                          <label class=" float-right text-muted" for="gridCheck1">
                            25 min
                          </label>
                        </div>
                      </div>
                    </div>    
                    <div class="row mb-3">
                      <div class="col-sm-12">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="gridCheck1">
                          <label class="form-check-label" for="gridCheck1">
                            Afeitado con diseño
                          </label>
                          <label class=" float-right text-muted" for="gridCheck1">
                            45 min
                          </label>
                        </div>
                      </div>
                    </div>                                                                           
                    <div class="col-sm-12">
                      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi saepe soluta, eum officia modi! Quam temporibus odit explicabo. Rerum praesentium explicabo, natus dignissimos ea. Impedit vero nihil ab illum explicabo.</p>
                    </div>
                  </div>
                </form><!-- End General Form Elements -->

              </div>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="card">
              <div class="card-body mt-2">
                <div id='calendarEvent' class="calendar"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection

@section('jsScripts')
  @include('js.agenda')
@endsection
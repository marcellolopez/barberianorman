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
                    <div class="col-sm-12">
                      <p>Lorem ipsum dolor sit, amet, consectetur adipisicing elit. Facilis labore, odit voluptate delectus quas veritatis, commodi qui corporis modi quibusdam atque aspernatur hic quisquam repellat natus dolorem eaque, velit animi?</p>
                      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis assumenda, iure error deleniti dolorum provident dignissimos, est, ab veniam harum laboriosam voluptatibus. Consectetur debitis, expedita perspiciatis non quidem provident quos!</p>
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
                <div id='calendar' class="calendar"></div>
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
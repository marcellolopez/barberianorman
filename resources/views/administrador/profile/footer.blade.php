 <!-- ======= Footer ======= -->
  <footer id="footer" class="footer bg-white d-none">
    <!--
    <div class="copyright">
      &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    -->
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->

      <div class="d-flex justify-content-center bd-highlight mb-3">
        <div class="p-2 bd-highlight">
          <img src="https://propiedadesenvaldivia.com/wp-content/uploads/2020/11/logo-1.png" class="rounded mx-auto d-block m-4" alt="..." style="width: 60%">          
        </div>
      </div>
    </div>
  </footer>
  <!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{asset('/')}}/assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="{{asset('/')}}/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="{{asset('/')}}/assets/vendor/chart.js/chart.min.js"></script>
  <script src="{{asset('/')}}/assets/vendor/echarts/echarts.min.js"></script>
  <script src="{{asset('/')}}/assets/vendor/quill/quill.min.js"></script>
  <script src="{{asset('/')}}/assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="{{asset('/')}}/assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="{{asset('/')}}/assets/vendor/php-email-form/validate.js"></script>
  <script src="{{asset('/js/jquery.js')}}"></script>
  <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
  <script src="{{asset('js/regex.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('/')}}/assets/js/main.js"></script>
  <!-- Full Calendar -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.css">
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js" integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.1.18/jquery.backstretch.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

  <!-- Alertify -->
  @if(session()->has('alertify')) 
      <style type="text/css">
        .ajs-success { 
          color: white !important;  
          
          /*/
          background-color: #d9edf7;  
          border-color: #31708f; 
          /*/
        }
      </style>
      <script type="text/javascript">

        $(document).ready(function(){

          var delay = alertify.get('notifier','delay');
          alertify.set('notifier','delay', 5);
          alertify.set('notifier','position', 'top-center');
          alertify.success('{{ session()->get('alertify') }}');
          alertify.set('notifier','delay', delay);
        });
      </script>
  @endif  
  
  @yield('jsScripts')


  

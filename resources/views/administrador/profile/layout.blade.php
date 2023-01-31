<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>@yield('titulo')</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{asset('/')}}/assets/img/favicon.png" rel="icon">
  <link href="{{asset('/')}}/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('/')}}/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{asset('/')}}/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="{{asset('/')}}/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="{{asset('/')}}/assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="{{asset('/')}}/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="{{asset('/')}}/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="{{asset('/')}}/assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css"/>

  <!-- Template Main CSS File -->
  <link href="{{asset('/')}}/assets/css/style.css" rel="stylesheet">


  <style type="text/css">
    .ajs-success { 
      color: white !important;
    }
  </style>
  <!-- =======================================================
  * Template Name: NiceAdmin - v2.2.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="{{session('menu', '')}}">
  @include('administrador.profile.header')

  @include('administrador.profile.sidebar')




  <main id="main" class="main bg-transparent">
    @include('administrador.profile.pagetitle')




    @yield('content')

  </main>
  <!-- End #main -->
  @include('administrador.profile.footer')
 

</body>
<style>
  * { 
    box-sizing: border-box; 
  }
  html {
    margin: 0;
    background-size: cover;
    background: url('{{ url("imagenes/barbershop-1612726-min.jpg") }}') no-repeat center center fixed;
    background-blend-mode: darken;
    // blend mode optional at this stage; will be used more in the next demo.

    -webkit-transition: 2s;
    -moz-transition: 2s;
    -o-transition: 2s;
    transition: 2s;  
  }
  body { margin: 0; } 
  ::-webkit-scrollbar-track
  {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.6);
    background-color: #CCCCCC;
  }

  ::-webkit-scrollbar
  {
    width: 15px;
    background-color: #F5F5F5;
  }

  ::-webkit-scrollbar-thumb
  {
    background-color: #FFF;
    background-image: -webkit-linear-gradient(90deg,
                                              rgba(0, 0, 0, 1) 0%,
                          rgba(0, 0, 0, 1) 25%,
                          transparent 100%,
                          rgba(0, 0, 0, 1) 75%,
                          transparent)
  }
</style>
<script>
$(document).ready(function() {
  var bgImageArray = [
      '{{ url("imagenes/barbershop-1612726-min.jpg") }}',
      '{{ url("imagenes/barbershop-4762345-min.jpg") }}',
      '{{ url("imagenes/barber-5194406-min.jpg") }}'
      ];
  base = "",
  secs = 4;
  bgImageArray.forEach(function(img){
      new Image().src = img; 
      // caches images, avoiding white flash between background replacements
  });

  function backgroundSequence() {
    window.clearTimeout();
    var k = 0;
    for (i = 0; i < bgImageArray.length; i++) {
      setTimeout(function(){ 
        document.documentElement.style.background = "url(" + base + bgImageArray[k] + ") no-repeat center center fixed";
        document.documentElement.style.backgroundSize ="cover";
      if ((k + 1) === bgImageArray.length) { setTimeout(function() { backgroundSequence() }, (secs * 1000))} else { k++; }      
      }, (secs * 1000) * i) 
    }
  }
  backgroundSequence();
});
</script>
  <script>
    $( ".toggle-sidebar-btn" ).click(function() {
        $.ajax({
            type: "post",
            url:'{{ url("admin/menu") }}',
            data: {
              "_token": "{{ csrf_token() }}",
              'menu': $("body").attr('class')
            },
            success: function (response) {
              if(response.status == 500){
                console.log(response);
              }
            },
            error: function (data) {
                console.log('Error:', data);
            },
            beforeSend: function() {
            }
        });
    });
  </script>
</html>
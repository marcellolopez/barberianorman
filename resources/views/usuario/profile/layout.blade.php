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


  <link rel="stylesheet" href="{{asset('/css/main.css')}}"/>

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

<body class="toggle-sidebar bg-transparent">
  @include('usuario.profile.header')

  <?php //   @include('usuario.profile.sidebar') ?>




  <main id="main" class="main bg-transparent">
    @include('usuario.profile.pagetitle')




    @yield('content')

  </main>
  <!-- End #main -->
  @include('usuario.profile.footer')
 

</body>
<style>
  * { 
    box-sizing: border-box; 
  }
  html {
    margin: 0;
    background-size: cover;
    background: black no-repeat center center fixed;
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
      '{{ url("imagenes/back01.jpeg") }}',
      '{{ url("imagenes/back02.jpeg") }}',
      '{{ url("imagenes/back03.jpeg") }}'
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
</html>
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




  <main id="main" class="main bg-dark">
    @include('administrador.profile.pagetitle')




    @yield('content')

  </main>
  <!-- End #main -->
  @include('administrador.profile.footer')
 

</body>
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
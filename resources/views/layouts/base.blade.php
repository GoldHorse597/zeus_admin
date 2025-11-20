<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Primary Meta Tags -->
    <title>Zeus_Admin</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <meta name="title" content="Zeus_Admin">
    <!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    @yield('head')
    <!-- Sweet Alert -->
    <link type="text/css" href="{{ asset('vendor/css/sweetalert2.min.css') }}" rel="stylesheet">
    <!-- Notyf -->
    <link type="text/css" href="{{ asset('vendor/css/notyf.min.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('vendor/css/alertify.min.css') }}" rel="stylesheet">
    <!-- Volt CSS -->
    <link type="text/css" href="{{ asset('vendor/css/volt.css') }}" rel="stylesheet">
     <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
     <link type="text/css" href="{{ asset('css/animate.css') }}" rel="stylesheet">
     <link type="text/css" href="{{ asset('css/paddle.css') }}" rel="stylesheet">
     @yield('css')
    <!-- Core -->
    <script type="text/javascript" src="{{ asset('js/libs/jquery.min.js') }}"></script>
    
    <script src="{{ asset('vendor/js/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/js/bootstrap.min.js') }}"></script>
    <!-- Vendor JS -->
    <script src="{{ asset('vendor/js/on-screen.umd.min.js') }}"></script>
    <!-- Slider -->
    <script src="{{ asset('vendor/js/nouislider.min.js') }}"></script>
    <!-- Smooth scroll -->
    <script src="{{ asset('vendor/js/smooth-scroll.polyfills.min.js') }}"></script>
    <!-- Charts -->
    <script src="{{ asset('vendor/js/chartist.min.js') }}"></script>
    <script src="{{ asset('vendor/js/chartist-plugin-tooltip.min.js') }}"></script>
    <!-- Datepicker -->
    <!-- <script src="{{ asset('vendor/js/datepicker.min.js') }}"></script> -->
    <!-- Sweet Alerts 2 -->
    <script src="{{ asset('vendor/js/sweetalert2.all.min.js') }}"></script>
    <!-- Moment JS -->
    <script src="{{ asset('js/libs/moment.min.js') }}"></script>
    <!-- Vanilla JS Datepicker -->
    <script src="{{ asset('vendor/js/datepicker.min.js') }}"></script>
    <!-- Notyf -->
    <script src="{{ asset('vendor/js/notyf.min.js') }}"></script>
    <!-- Simplebar -->
    <script src="{{ asset('vendor/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('vendor/js/alertify.min.js') }}"></script>
    <!-- Github buttons -->
    <script async defer="defer" src="{{ asset('js/libs/buttons.js') }}"></script>
    <!-- Volt JS -->
    <script src="{{ asset('js/volt.js') }}"></script>
    <script src="{{ asset('vendor/js/paddle.js') }}"></script>
    <script src="{{ asset('vendor/js/beacon.min.js') }}"></script>
    <script>
document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(function (el) {
    new bootstrap.Dropdown(el);
});
</script>
  </head>
  @yield('body')
  @yield('script')
</html>
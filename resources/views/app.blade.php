    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test Task Employee List</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/fontawesome-free/css/all.css')}}">
    <!-- Jquery-ui -->
{{--    <link rel="stylesheet" href="{{asset('assets/jquery-ui/jquery-ui.css')}}">--}}
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset("dist/css/adminlte.css")}}">

    @vite(['resources/js/app.js', 'resources/css/app.css'])

    @inertiaHead
</head>
<body class="hold-transition sidebar-mini layout-fixed">
@inertia

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<!-- jQuery -->
<script src="{{asset('assets/jquery/jquery.js')}}"></script>
{{--<script src="{{asset('assets/jquery-ui/jquery-ui.js')}}"></script>--}}
<!-- Bootstrap 4 -->
<script src="{{asset('assets/bootstrap/js/bootstrap.bundle.js')}}"></script>
<!-- bs-custom-file-input -->
<script src="{{asset('assets/bs-custom-file-input/bs-custom-file-input.js')}}"></script>
{{--<!-- AdminLTE App -->--}}
<script src="{{asset("dist/js/adminlte.js")}}"></script>
</body>
</html>

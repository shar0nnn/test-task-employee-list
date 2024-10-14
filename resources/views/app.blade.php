<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test Task Employee List</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    {{--    <!-- Ionicons -->--}}
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset("dist/css/adminlte.css")}}">

    @vite(['resources/js/app.js', 'resources/css/app.css'])

    @inertiaHead
</head>
<body class="hold-transition sidebar-mini layout-fixed">
@inertia

{{--<!-- AdminLTE App -->--}}
{{--<script src="../../public/dist/js/adminlte.js"></script>--}}
</body>
</html>

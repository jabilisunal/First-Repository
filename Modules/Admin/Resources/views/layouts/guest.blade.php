<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Panel</title>

    <link rel="shortcut icon" href="{{asset('modules/admin/favicon.ico')}}" type="image/x-icon">
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{asset('modules/admin/global_assets/css/icons/icomoon/styles.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('modules/admin/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('modules/admin/assets/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('modules/admin/assets/css/layout.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('modules/admin/assets/css/components.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('modules/admin/assets/css/colors.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('modules/admin/assets/css/custom.css')}}" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="{{asset('modules/admin/global_assets/js/main/jquery.min.js')}}"></script>
    <script src="{{asset('modules/admin/global_assets/js/main/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('modules/admin/global_assets/js/plugins/loaders/blockui.min.js')}}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="{{asset('modules/admin/global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>

    <script src="{{asset('modules/admin/assets/js/app.js')}}"></script>
    <script src="{{asset('modules/admin/global_assets/js/demo_pages/login.js')}}"></script>
    <!-- /theme JS files -->

</head>

<body class="bg-slate-800">

<!-- Page content -->
<div class="page-content">

    @yield('content')

</div>
<!-- /page content -->
</body>
</html>

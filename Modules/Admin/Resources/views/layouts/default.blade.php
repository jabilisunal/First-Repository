<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Mover Outside Admin Panel</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{asset('modules/admin/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{asset('modules/admin/global_assets/js/main/jquery.min.js')}}"></script>
    <link href="{{asset('modules/admin/global_assets/css/icons/icomoon/styles.min.css')}}" rel="stylesheet" type="text/css">
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    @stack('header')
</head>
<body>
<div class="page-content">
    <div class="content-wrapper">
        <div class="content">
            @yield('content')
        </div>
    </div>
</div>
</body>
@stack('footer')
</html>

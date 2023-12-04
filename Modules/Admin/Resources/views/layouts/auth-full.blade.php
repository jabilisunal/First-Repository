<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Panel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('admin::includes.head')

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
</head>
<body>
<!-- Page content -->
<div class="page-content">
    <!-- Main content -->
    <div class="content-wrapper">
        <!-- Content area -->
        <div class="content">
            @yield('content')
        </div>
        <!-- /content area -->
    </div>
    <!-- /main content -->
</div>
<!-- /page content -->
@stack('footer')
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Panel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('admin::includes.head')
    @stack('header')
</head>
<body class="sidebar-xs">
@include('admin::includes.navbar')
<!-- Page content -->
<div class="page-content">
@include('admin::includes.sidebar')
<!-- Main content -->
    <div class="content-wrapper">
    @include('admin::includes.breadcrumb')
    <!-- Content area -->
        <div class="content">
            @yield('content')
        </div>
        <!-- /content area -->
        @include('admin::includes.footer')
    </div>
    <!-- /main content -->
</div>
<!-- /page content -->
@stack('footer')
</body>
</html>

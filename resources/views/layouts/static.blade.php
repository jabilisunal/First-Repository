<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        @include('components.head')
    </head>
    <body>
        @include('components.header')

        @yield('content')

        @include('components.footer')

        @include('components.scripts')
    </body>
</html>

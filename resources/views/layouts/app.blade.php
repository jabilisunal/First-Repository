<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        @include('components.head')
        @stack('header')
    </head>
    <body>
        @include('components.preloader')

        @include('components.header')

        @stack('common-banner')

        @yield('content')

        @include('components.footer')

        @include('components.copyright')

        @include('components.scripts')

        @stack('footer')
    </body>
</html>

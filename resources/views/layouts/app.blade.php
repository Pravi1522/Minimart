<!DOCTYPE html>
<html dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr'}}" lang="{{ str_replace('_', '-', app()->getLocale()) }}" xmlns:fb="http://ogp.me/ns/fb#">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#008276">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/css/admin_app.css') }}">
</head>
<body class="">
    <div id="app" v-cloak>
        @include('layouts.header')
        @yield('content')
    </div>

    <!-- Include JS files -->
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

    @if(Session::has('message'))
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded',function() {
            var content = {};
            content.message = "{!! Session::get('message') !!}";
            content.title = "{!! Session::get('title') !!}";
            state = "{!! Session::get('state') !!}";

            flashMessage(content,state);
        });
    </script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
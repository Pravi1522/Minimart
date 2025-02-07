<!DOCTYPE html>
<html >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ $favicon ?? '' }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="{{ $keywords ?? '' }}">
    <meta name="description" content="{{ $description ?? '' }}">
    <meta name="theme-color" content="#008276">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin_app.css') }}">
</head>
<body>
    <div id="app">
        <div class="wrapper">
            <div class="main-header">
                <div class="logo-header">
                    <h5 class="fw-bold text-white bg-primary p-3"> Mini Mart </h5>
                </div>
            </div>
            <div class="d-flex">
                @include('layouts.adminLayout.navigation')
                <div class="main-panel" style="width: 75%;">
                    @yield('content')
                    <footer class="footer">
                        <div class="container-fluid">
                            <nav class="float-left d-none">
                                <ul class="nav">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            Help
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('admin_assets/js/admin_app.js') }}"></script>

    @if(Session::has('message'))
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded',function() {
            var content = {};
            content.message = '{!! str_replace("\'","",Session::get("message")) !!}';
            content.title = "{!! Session::get('title') !!}";
            state = "{!! Session::get('state') !!}";

            flashMessage(content,state);
        });
    </script>
    @endif
    @stack('scripts')
</body>
</html>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-2Y0RQWGNMN"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-2Y0RQWGNMN');
    </script>

    <title>
        @yield('title')
    </title>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    {{--<script src="{{ asset('js/project.js') }}" defer></script>--}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

    <script>
        var csrf_token = '{{ csrf_token() }}';
    </script>

    @yield('header')
</head>
<body class="site">
{{--    @if (config('app.env') != 'prod' && config('app.env') != 'production')--}}
{{--    <div class="fixed-top alert alert-warning alert-dismissible fade show mb-0" role="alert" style="z-index: 1031;" id="test-env-warning">--}}
{{--        <span class="fad fa-exclamation-triangle"></span></strong>Warning!</strong> This is a testing environment and <strong>not</strong> the <a href="https://register.polk.health/">real website</a>.--}}
{{--        <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
{{--            <span aria-hidden="true">&times;</span>--}}
{{--        </button>--}}
{{--    </div>--}}

{{--    <script>--}}
{{--        document.addEventListener("DOMContentLoaded", function(event) {--}}
{{--            setTimeout(function () {--}}
{{--                var warning = document.getElementById('test-env-warning');--}}
{{--                if (typeof(warning) != 'undefined' && warning != null) {--}}
{{--                    warning.classList.remove('show');--}}
{{--                    setTimeout(function () {--}}
{{--                        document.getElementById('test-env-warning').remove();--}}
{{--                    }, 1000);--}}
{{--                }--}}
{{--            }, 5000);--}}
{{--        });--}}
{{--    </script>--}}
{{--    @endif--}}

    @include('layouts.partials.navbar')

    <main class="site-content">
        @yield('content')
    </main>

    @include('layouts.partials.footer')

    @include('layouts.partials.modals')

    @yield('scripts')
</body>
</html>

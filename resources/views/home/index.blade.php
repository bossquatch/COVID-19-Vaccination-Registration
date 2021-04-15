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
        {{ config('app.name', 'Laravel') }}
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

    <script src="{{ asset('js/analytics.js') }}"></script>
    <link href="{{ asset('css/analytics.css') }}" rel="stylesheet">
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
        <!-- Header -->
        <section class="bg-primary text-light p-0">
            <img src="/images/national-cancer-institute-fi3zHLxWrYw-unsplash.jpg" alt="Nurse administers a vaccine" class="bg-image blend-mode-multiply position-absolute">
            <div class="container">
                <div class="row pt-12 pb-10 min-vh-100 align-items-center">
                    <div class="col-md-8 col-xl-6 text-center text-md-left">
                        <h1 class="pb-1">
                            <span class="d-block">Looking to get your</span>
                            <span class="d-block">COVID-19 vaccine?</span>
                        </h1>
                        <p class="text-light opacity-80 pb-2 pb-md-5">
                            While we're no longer accepting registrations, we've partnered with Lakeland Regional Health to better serve you.
                        </p>
                        <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                            <a href="#" class="btn btn-primary-inverse btn-primary mr-5">Register now</a>
                            <div class="d-flex align-items-center">
                                <span class="fal fa-phone-alt fa-fw font-size-xl text-light mr-2"></span>
                                <a class="text-light text-decoration-none" href="tel:+18632987500">+ 1 863-298-7500</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer-transparent container-fluid fixed-bottom">
        <div class="d-md-flex align-items-center justify-content-between py-2 text-center text-md-left">
            <ul class="list-inline font-size-xs mb-3 mb-md-0 order-md-2">
                <li class="list-inline-item my-1"><a class="nav-link" href="/terms">Terms</a></li>
                <li class="list-inline-item my-1"><a class="nav-link" href="/privacy">Privacy</a></li>
            </ul>

            <p class="font-size-xs mb-0 mr-4 order-md-1"><span>&copy; All rights reserved. Made by&nbsp;</span><a href="https://www.polk-county.net/" target="_blank" rel="noopener">Polk County</a></p>
        </div>
    </footer>

    @include('layouts.partials.modals')

    <script type="text/javascript">
        var ctx = document.getElementById('regByDay').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($registrations['day']) !!},
                datasets: [{
                    label: 'Registrations',
                    data: {!! json_encode($registrations['counts']) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    animateScale: true,
                    animateRotate: true
                },
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        fontSize: 14,
                        fontColor: '#000',
                        padding: 16,
                        fontFamily: "'Open Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'"
                    }
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                    displayColors: false,
                    xPadding: 16,
                    yPadding: 12,
                    titleFontSize: 14,
                    titleFontFamily: "'Open Sans Condensed', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'",
                    bodyFontSize: 14,
                    bodyFontFamily: "'Open Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'",
                    footerFontSize: 10,
                    footerFontFamily: "'Open Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'"
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        stacked: true,
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Day',
                            fontSize: 14,
                            fontColor: '#000',
                            padding: 16,
                            fontFamily: "'Open Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'"
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            fontSize: 12,
                            fontColor: '#000',
                            fontFamily: "'Open Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'"
                        }
                    }],
                    yAxes: [{
                        stacked: true,
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Count',
                            fontSize: 14,
                            fontColor: '#000',
                            padding: 16,
                            fontFamily: "'Open Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'"
                        },
                        gridLines: {
                            borderDash: [1, 1]
                        },
                        ticks: {
                            fontSize: 12,
                            fontColor: '#000',
                            fontFamily: "'Open Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'"
                        }
                    }]
                }
            }
        });
    </script>
</body>
</html>

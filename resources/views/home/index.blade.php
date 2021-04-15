@extends('layouts.app')

@section('title')
    {{ config('app.name', 'Laravel') }}
@endsection

@section('header')
    <script src="{{ asset('js/analytics.js') }}"></script>
    <link href="{{ asset('css/analytics.css') }}" rel="stylesheet">
@endsection

@section('content')
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
@endsection

@section('scripts')
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
@endsection

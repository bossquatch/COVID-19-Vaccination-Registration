@extends('layouts.app')

@section('title')
    {{ config('app.name', 'Laravel') }} - Search
@endsection

@section('header')
<script src="{{ asset('js/analytics.js') }}"></script>
<link href="{{ asset('css/analytics.css') }}" rel="stylesheet">
<meta http-equiv="refresh" content="300" >
@endsection

@section('content')
<!-- Header -->
<div class="jumbotron jumbotron-fluid jumbotron-header bg-squares teal-gradient">
    <div class="container position-relative z-1">
        <div class="row">
            <div class="col-12">
                <!-- Badge -->
                <span class="badge badge-pill badge-white-teal mb-3">
                    <span class="h6 text-uppercase">
                        Analytics
                    </span>
                </span>

                <!-- Heading -->
                <h2 class="title">Analytics at a Glance</h2>

                <!-- Text -->
                <p class="font-size-lg text-gray-dark mb-0">Keep track of the metrics that are important to you.</p>
            </div>
        </div>
    </div>
</div>

<section class="main pt-8 pt-md-11 pb-8 pb-md-12">
    <div class="container">
        <div class="row justify-content-center mb-8">
            <div class="col-12 col-md-6 col-lg-5">
                <div class="card card-body mb-5">
                    <div class="row align-items-center">
                        <div class="col">
                            <!-- Title -->
                            <h2 class="h6 text-uppercase text-gray-dark mb-2">Registered Today</h2>
                            <!-- Value -->
                            <span class="h2 mb-0">{{ number_format($registrations_today,0) }}</span>


                        </div>
                        <div class="col-auto">
                            <!-- Icon -->
                            <span class="h2 fad fa-file-signature text-success mb-0"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mb-8">
            <div class="col-12 col-lg-4">
                <div class="card card-body mb-5">
                    <div class="row align-items-center">
                        <div class="col">
                            <!-- Title -->
                            <h2 class="h6 text-uppercase text-gray-dark mb-2">64 and Under</h2>
                            <!-- Value -->
                            <span class="h2 mb-0">{{ number_format($registrations_young,0) }}</span>


                        </div>
                        <div class="col-auto">
                            <!-- Icon -->
                            <span class="h2 far fa-plus text-secondary mb-0"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card card-body mb-5">
                    <div class="row align-items-center">
                        <div class="col">
                            <!-- Title -->
                            <h2 class="h6 text-uppercase text-gray-dark mb-2">65 and Over</h2>
                            <!-- Value -->
                            <span class="h2 mb-0">{{ number_format($registrations_old, 0) }}</span>


                        </div>
                        <div class="col-auto">
                            <!-- Icon -->
                            <span class="h2 far fa-equals text-secondary mb-0"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card card-body mb-5">
                    <div class="row align-items-center">
                        <div class="col">
                            <!-- Title -->
                            <h2 class="h6 text-uppercase text-gray-dark mb-2">Registered Total</h2>
                            <!-- Value -->
                            <span class="h2 mb-0">{{ number_format($registrations_total,0) }}</span>


                        </div>
                        <div class="col-auto">
                            <!-- Icon -->
                            <span class="h2 fad fa-users text-secondary mb-0"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-body mb-5">
                    <!-- Title -->
                    <h2 class="h4 text-center mb-5">
                        Registrations
                    </h2>

                    <!-- Chart -->
                    <div class="chart">
                        <canvas id="registrationsStackedBarChart" width="1200" height="600" aria-label="Registrations Stacked Bar Chart" role="img"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card card-body mb-5">
                    <!-- Title -->
                    <h2 class="h4 text-center mb-5">
                        Registrations by County
                    </h2>

                    <!-- Chart -->
                    <div class="chart">
                        <canvas id="registrationsByCountyDoughnutChart" width="300" height="300" aria-label="Registrations by County Doughnut Chart" role="img"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card card-body mb-5">
                    <!-- Title -->
                    <h2 class="h4 text-center mb-5">
                        Registrations by City
                    </h2>

                    <!-- Chart -->
                    <div class="chart">
                        <canvas id="registrationsByCityBarChart" width="300" height="300" aria-label="Registrations by City Doughnut Chart" role="img"></canvas>
                    </div>
                </div>
            </div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="card card-body mb-0">
					<!-- Title -->
					<h2 class="h4 text-center mb-0">
						Registrations by Status and Age Group
					</h2>

					<!-- Table -->
					<div class="table-responsive">
						<table class="table">
							<thead>
							<tr>
								<th scope="col" class="font-size-xs" width="7%">Group</th>
							@foreach($registrations_by_age['Total'] as $key => $val)
								<th scope="col" class="font-size-xs text-right" width="12%">{{ $key }}</th>
							@endforeach
							</tr>
							</thead>
							<tbody>

							@foreach($registrations_by_age as $key => $val)
								<tr class="text-right {{ $key == 'Today' ? 'bg-info text-white' : '' }}">
									<th scope="row">{{ $key }}</th>

									@foreach($val as $key2 => $item)

											<td>{{ number_format ($item) }}</td>

									@endforeach

								</tr>
							@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
    </div>
</section>
@endsection

@section('scripts')
<script type="text/javascript">
    var randomScalingFactor = function () {
        return Math.round(Math.random() * 100);
    };

    var regByDayStackCTX = document.getElementById('registrationsStackedBarChart');
    var regByCountyCTX = document.getElementById('registrationsByCountyDoughnutChart');
    var regByCityCTX = document.getElementById('registrationsByCityBarChart');

    var registrationsStackedBarChart = new Chart(regByDayStackCTX, {
        type: 'bar',
        data: {
            datasets: [{
                label: 'Organically Registered',
                stack: 'Stack 0',
                backgroundColor: '#0071eb',
                borderColor: '#0071eb',
                data: {!! json_encode($register_by_day['organic']) !!}
            }, {
                label: 'Call Center Registered',
                stack: 'Stack 0',
                backgroundColor: '#ffc107',
                borderColor: '#ffc107',
                data: {!! json_encode($register_by_day['call-center']) !!}
            }],
            labels: {!! json_encode($register_by_day['dates']) !!},
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
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
                        labelString: 'Registrations',
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

    var registrationsByCountyDoughnutChart = new Chart(regByCountyCTX, {
        type: 'bar',
        data: {
            datasets: [{
                data: {!! json_encode($register_by_county['counts']) !!},
                backgroundColor: [
                    '#ffc107',
                    '#0071eb',
                    '#df8c19',
                    '#dc3545',
                    '#398502',
                    '#00458b',
                    '#99ddff',
                    '#f1e821',
                    '#f07e74',
                    '#fe4a49',
                    '#555555',
                    '#7d3780',
                    '#398502',
                    '#23c0ad',
                    '#ff6600',
                    '#daa520',
                    '#00ff00'
                ],
                hoverBorderColor: [
                    '#fff',
                    '#fff',
                    '#fff',
                    '#fff',
                    '#fff',
                    '#fff',
                    '#fff',
                    '#fff',
                    '#fff',
                    '#fff',
                    '#fff',
                    '#fff',
                    '#fff',
                    '#fff',
                    '#fff',
                    '#fff',
                    '#fff'
                ],
                borderWidth: 3
            }],
            labels: {!! json_encode($register_by_county['counties']) !!}
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutoutPercentage: 85,
            legend: {
                display: false
                // position: 'right',
                // labels: {
                //     fontSize: 14,
                //     fontColor: '#000',
                //     padding: 16,
                //     fontFamily: "'Open Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'"
                // }
            },
            tooltips: {
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
            animation: {
                animateScale: true,
                animateRotate: true
            },
            scales: {
                yAxes: [{
                    ticks: {
                        max: 10000,
                        min: 0
                    }
                }]
            }
        }
    });

    var registrationsByCityBarChart = new Chart(regByCityCTX, {
        type: 'bar',
        data: {
            datasets: [{
                data: {!! json_encode($register_by_city['counts']) !!},
                label: 'Registrations',
                backgroundColor: '#0071eb',
                borderColor: '#0071eb'
            }],
            labels: {!! json_encode($register_by_city['cities']) !!},
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false,
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
                        labelString: 'City',
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
                        labelString: 'Registrations',
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

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
{{--	@include('layouts.partials.flash')--}}

    <main class="site-content">
        @yield('content')


		<div id="accordion">
			<div class="card">
				<div class="card-header" id="headingOne">
					<div class="row align-items-center justify-content-center">
						<h3>Email Replies</h3>
					</div>
				</div>
				<div class="card-body">

					<div class="table-responsive">
						<table class="table table-hover table-sm font-size-xs">
							<thead>
							<tr class="font-weight-bold">
								<td scope="col">Date</td>
								<td scope="col">Email Address</td>
								<td scope="col">Subject</td>
							</tr>
							</thead>
							<tbody>
							@php
								$i = 0;
							@endphp

							@foreach($current_emails as $item)
								@php $i++; @endphp
								<tr data-toggle="collapse" data-target="#accordion{{$i}}" class="clickable"  style="cursor: pointer">
									<td>{{$item->date}}</td>
									<td>{{$item->email ?? ''}}</td>
									<td>{{$item->topic}}</td>
								</tr>
								<tr id="accordion{{$i}}" class="collapse">
									<td colspan="3">
										<div>
											<div class="card">
												<div class="card-header" id="headingThree">
													<div class="row align-items-center justify-content-center">
														<h3>Data</h3>
													</div>
												</div>
												<div class="card-body">
													<ul class="list-group">
														<li class="list-group-item">{{$item->body}}</li>
														<li class="list-group-item">{{$item->signature}}</li>
													</ul>
												</div>
											</div>

											<div class="card">
												<div class="card-body">
													<div class="btn-group-vertical btn-group-sm" role="group" aria-label="Basic example">
														<button type="button" class="btn btn-success">
															Lookup
														</button>
														<button type="button" class="btn btn-primary">
															Reply
														</button>
														<button type="button" class="btn btn-warning">
															Show
														</button>
														<button type="submit" class="btn btn-danger">
															Delete
														</button>
														<form class="form-inline" action="/contact-center/email-replies/{{ $item->id }}" method="POST">
															@csrf
															@method('DELETE')
															<button type="submit" class="btn btn-outline-danger">
																Delete
															</button>
														</form>
													</div>
												</div>
											</div>
										</div>
									</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
    </main>

    @include('layouts.partials.footer')

    @include('layouts.partials.modals')

    @yield('scripts')
	<script>
		$(document).ready(function() {
			$("#custom_alert").fadeTo(2000, 500).slideUp(500, function() {
				$("#custom_alert").slideUp(500);
			});
		});
	</script>
</body>
</html>

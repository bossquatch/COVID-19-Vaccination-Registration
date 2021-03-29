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

    @yield('header')
</head>
<body class="site" >
    @include('layouts.partials.navbar')

    <main class="site-content">
		@include('layouts.partials.flash')
        @yield('content')

		<div id="main_content">
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
								<td scope="col">Actions</td>
							</tr>
							</thead>
							<tbody>
							@php
								$i = 0;
							@endphp

							@foreach($current_emails as $item)
								@php
									$i++;

									$reg_id = $item->registration_id ?? false;

									if($reg_id) {
										$lookup_info = 'id=' . $reg_id . ' data-id=' . $reg_id;
										$button_type = 'btn-success';
									} else {
										$lookup_info = 'disabled';
										$button_type = 'btn-outline-success';
									}

								@endphp

								<div class="accordion" id="emailAccordion">

									<tr class="clickable" data-toggle="collapse" data-target="#accordion{{$i}}" aria-expanded="true" aria-controls="accordion{{$i}}">
										<td>{{$item->date}}</td>
										<td>{{$item->email ?? ''}}</td>
										<td>{{$item->topic}}</td>
										<td>
{{--											<a href="/manage/edit/{{$reg_id}}" type="button" class="btn btn-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Lookup Registration" {{$lookup_info}}>--}}
{{--												--}}
{{--											</a>--}}
											<button type="button" class="btn {{$button_type}} btn-sm lookupRegistration" data-bs-toggle="tooltip" data-bs-placement="top" title="Lookup Registration" {{$lookup_info}}>
												<i class="fad fa-search-location"></i>
											</button>
											<button type="button" class="btn btn-outline-info btn-sm showEmail" id="show-{{$item->id}}" data-id="{{$item->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="View Email">
												<i class="fad fa-file-user"></i>
											</button>
											<button type="submit" class="btn btn-danger btn-sm deleteEmail" id="delete-{{$item->id}}" data-id="{{$item->id}}" data-csrf="{{csrf_token ()}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Email">
												<i class="fad fa-trash-alt"></i>
											</button>
										</td>
									</tr>
								</div>
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

	<!-- Modal -->
	<div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="emailModalLabel">View Email</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="emailHTML">

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

    @yield('scripts')
	<script>
		$(document).ready(function() {
			$("#custom_alert").fadeTo(2000, 500).slideUp(500, function() {
				$("#custom_alert").slideUp(500);
			});

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$('.lookupRegistration').click(function() {
				var registration_id = $(this).data("id");
				var path = "/manage/edit/";
				path = path.concat(registration_id);
				window.location.href = path;
			});

			$('.showEmail').click(function() {
				let email_id = $(this).data("id");

				$.ajax({
					url: "/contact-center/email-replies/email/" + email_id,
					method: "GET",
					success: function(data){
						$('#emailHTML').html(data);
						$('#emailModal').modal("show");
					}
				});
			});

			$('.deleteEmail').click(function() {
				let email_id 	= $(this).data('id');
				let token 		= $(this).data('token');
				$.ajax({
					url: "/contact-center/email-replies/email/" + email_id,
					method: "POST",
					data: {
						email_id: email_id,
						_token: token,
						_method: "DELETE"
					},
					success: function(response){
						// $('.flash-message').html(response);
						location.reload();
					}
				});
			});

		});
	</script>
</body>
</html>

@extends('layouts.no-nav')

@section('title')
    Verify Email
@endsection

@section('content')
<!-- Page Content -->
<section class="container d-flex justify-content-center align-items-center flex-grow-1 py-7">
    <div class="row justify-content-center">
        <div class="col-12 col-md-9">
            <div class="card border-0 shadow my-5">
                <div class="card-body py-7 px-5">
                    <div>
                        <h1 class="font-size-4xl font-weight-extrabold tracking-tight mb-5">
                            <span class="d-block">Almost there!</span>
                            <span class="d-block text-primary">Verify your email address.</span>
                        </h1>

                        <p>
                            We have sent an email to<br>
                            <span class="font-weight-bold">{{ Auth::user()->email }}</span>.
                        </p>

						<p>
							To continue your registration, you must verify your email. If you have not received the verification email, please check the email address above. If it is correct check your "Spam" or "Bulk Email" folder. Please note, some email providers can take up to 30 minutes to deliver the email to your inbox.
						</p>

						<p>
							You can close this window. Once you click the link in the verification email a new window will open.
						</p>

                        <form method="POST" action="{{ route('verification.resend') }}" id="resend-form" style="display: none">
                            @csrf
                        </form>

						<p class="text-muted font-size-sm mb-0"><small>* If you require a new verification email please use this link to request a new verification email: <a href="{{ route('verification.resend') }}" onclick="event.preventDefault(); document.getElementById('resend-form').submit();">Resend confirmation link.</a></small></p>
                        <p class="text-muted font-size-sm mb-0"><small>* Verification emails expire in {!! \Carbon\CarbonInterval::minutes(config('auth.verification.expire'))->cascade()->forHumans(); !!}.</small></p>
                    </div>
                    {{--<div class="border-top text-center mt-5 pt-5">
                        <p class="font-size-sm font-weight-medium text-gray-dark">Or sign in with</p>
                        <a class="btn-social sb-facebook sb-outline sb-lg mx-1 mb-2" href="#"><span class="sb-icon fab fa-facebook"></span></a>
                        <a class="btn-social sb-twitter sb-outline sb-lg mx-1 mb-2" href="#"><span class="sb-icon fab fa-twitter"></span></a>
                        <a class="btn-social sb-instagram sb-outline sb-lg mx-1 mb-2" href="#"><span class="sb-icon fab fa-instagram"></span></a>
                        <a class="btn-social sb-google sb-outline sb-lg mx-1 mb-2" href="#"><span class="sb-icon fab fa-google"></span></a>
                    </div>--}}
                </div>
            </div>
        </div>
    </div>
</section>

@if (\Session::has('resent') && \Session::get('resent'))
<div class="modal fade" id="resentModal" data-backdrop="static" tabindex="-1" role="dialog" aria-label="resent Modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-6">
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <span class="fad fa-check-circle fa-5x text-success"></span>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <p class="text-gray-dark mb-5">Your verification email has been resent!</p>
                        <a href="/" class="btn btn-header btn-round btn-lg">Ok</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("#resentModal").modal();
    });
</script>
@endif
@endsection

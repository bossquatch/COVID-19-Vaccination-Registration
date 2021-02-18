@extends('layouts.no-nav')

@section('title')
    Verify Email
@endsection

@section('content')
<!-- Page Content -->
<section class="container d-flex justify-content-center align-items-center flex-grow-1 pt-7 pb-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-9">
            <div class="card border-0 shadow my-5">
                <div class="card-body py-7 px-5">
                    <div>
                        <h1 class="h2 font-weight-bolder tracking-tight font-size-4xl mb-5">
                            <span class="d-block">One more step!</span>
                            <span class="d-block text-primary">Verify your email address.</span>
                        </h1>

                        <p>
                            We have sent an email to<br>
                            <span class="font-weight-bold">{{ $notification->email }}</span>.
                        </p>

                        <p>
                            You need to verify your email to continue. If you have not received the verification email, please check your "Spam" or "Bulk Email" folder. You can also click the resend button below to have another email sent to you.
                        </p>

                        <form method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-block mt-5 mb-4">Resend verification email</button>
                        </form>

                        <p class="text-muted font-size-sm mb-0"><small>* Verification emails expire in {{ \Carbon\CarbonInterval::minutes(config(auth.verification.expire))->cascade()->forHumans(); }}.</small></p>
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

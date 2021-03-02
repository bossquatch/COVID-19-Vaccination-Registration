@extends('layouts.no-nav')

@section('title')
    Create an Account
@endsection

@section('content')
<!-- Page Content -->
<section class="container d-flex justify-content-center align-items-center flex-grow-1 py-7">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">
            <div class="card border-0 shadow my-5">
                <div class="card-body py-7 px-5">
                    <div>
                        <h1 class="font-size-4xl font-weight-extrabold tracking-tight mb-5">
                            <span class="d-block">Let's get started!</span>
                            <span class="d-block text-primary">First, create an account.</span>
                        </h1>

                        <!-- Form -->
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- First name -->
                            <div class="form-group">
                                <label for="firstName">
                                    First Name
                                </label>
                                <input id="firstName" type="text" class="form-control @error('firstName') is-invalid @enderror" name="firstName" value="{{ old('firstName') }}" required autocomplete="firstName" autofocus placeholder="Enter your first name">

                                @error('firstName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Middle name -->
                            <div class="form-group">
                                <label for="middleName">
                                    Middle Name
                                </label>
                                <input id="middleName" type="text" class="form-control @error('middleName') is-invalid @enderror" name="middleName" value="{{ old('middleName') }}" autocomplete="middleName" autofocus placeholder="Enter your middle name">

                                @error('middleName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Last name -->
                            <div class="form-group">
                                <label for="lastName">
                                    Last Name
                                </label>
                                <input id="lastName" type="text" class="form-control @error('lastName') is-invalid @enderror" name="lastName" value="{{ old('lastName') }}" required autocomplete="lastName" autofocus placeholder="Enter your last name">

                                @error('lastName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Date of birth -->
                            <div class="form-row">
                                <div class="form-group col-md-6 mb-5">
                                    <label for="suffix">
                                        Suffix
                                    </label>
                                    <select id="suffix" name="suffix" class="custom-select @error("suffix") is-invalid @enderror">
                                        <option value="0" @if (old('suffix') && old('suffix') == '0') selected @endif></option>
                                        @foreach (\App\Models\Suffix::get() as $suffix)
                                            <option value="{{ $suffix->id }}" @if (old('suffix') && old('suffix') == $suffix->id) selected @endif>{{ $suffix->display_name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="form-text font-weight-light font-size-xs text-muted">If applicable.</span>
                                    @error('suffix')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('suffix') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6 mb-5">
                                    <label for="dob">
                                        Date of Birth
                                    </label>
                                    <input id="dob" name="dateOfBirth" class="form-control @error("dateOfBirth") is-invalid @enderror" type="date" value="{{ old('dateOfBirth') }}" required aria-required="true">
                                    <span class="form-text font-weight-light font-size-xs text-muted">If you are using a mobile browser, please tap the year or arrow near the year to select the year of birth.</span>
                                    @error('dateOfBirth')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('dateOfBirth') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label for="email">
                                    Email Address
                                </label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="name@address.com">
                                <span class="form-text font-weight-light font-size-xs text-muted">Each registration must have a unique email address. If you would like to register multiple individuals using the same email address, please contact the Vaccination Hotline at <a href="tel:+18632987500">(863) 298-7500</a>.</span>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="form-group mb-5">
                                <label for="phone">
                                    Primary Phone Number
                                </label>
                                <input id="phone" name="phone" class="form-control @error("phone") is-invalid @enderror" type="tel" value="{{ old('phone') }}" placeholder="(XXX) XXX-XXXX" required aria-required="true">

                                @error("phone")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first("phone") }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="form-group mb-5">
                                <label for="password">
                                    Password
                                </label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Create your password">
                                <span class="form-text font-weight-light font-size-xs text-muted">Password length is a minimum of 8 characters.</span>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-group mb-5">
                                <label for="password-confirm">
                                    Confirm Password
                                </label>
                                <input id="password-confirm" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Re-enter your password">
                            </div>

                            <!-- Submit -->
                            <button class="btn btn-primary btn-block" type="submit">
                                Create an account
                            </button>
                        </form>
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

<script>
$('#phone').keyup(function(e){
        var ph = this.value.replace(/\D/g,'').substring(0,10);
        // Backspace and Delete keys
        var deleteKey = (e.keyCode == 8 || e.keyCode == 46);
        var len = ph.length;
        if(len==0){
            ph=ph;
        }else if(len<3){
            ph='('+ph;
        }else if(len==3){
            ph = '('+ph + (deleteKey ? '' : ') ');
        }else if(len<6){
            ph='('+ph.substring(0,3)+') '+ph.substring(3,6);
        }else if(len==6){
            ph='('+ph.substring(0,3)+') '+ph.substring(3,6)+ (deleteKey ? '' : '-');
        }else{
            ph='('+ph.substring(0,3)+') '+ph.substring(3,6)+'-'+ph.substring(6,10);
        }
        this.value = ph;
    });
</script>
@endsection

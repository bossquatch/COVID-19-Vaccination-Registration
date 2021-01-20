@extends('layouts.no-nav')

@section('title')
    Register
@endsection

@section('content')
<section>
    <div class="container-fluid d-flex flex-column">
        <div class="row align-items-center justify-content-center min-vh-100">
            <div class="col-lg-6 align-self-stretch d-none d-lg-block px-0">
                <!-- Image -->
                <div class="h-100 w-cover bg-cover" style="background-image: url({{ asset('images/register-image.jpg') }});"></div>
            </div>

            <div class="col-12 col-md-10 col-lg-6 px-8 px-lg-11 py-8 py-lg-11">
                <!-- Heading -->
                <h1 class="mb-0 font-weight-bold">
                    Register
                </h1>

                <!-- Text -->
                <p class="mb-6 text-muted">
                    Create an account to start the COVID-19 vaccination registration process.
                </p>

                <!-- Form -->
                <form class="mb-6" method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
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

                    <div class="form-group">
                        <label for="middleName">
                            Middle Name
                        </label>
                        <input id="middleName" type="text" class="form-control @error('middleName') is-invalid @enderror" name="middleName" value="{{ old('middleName') }}" autocomplete="middleName" autofocus placeholder="Enter middle name">

                        @error('middleName')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

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

                    <!-- Date of Birth -->
                    <div class="form-row">
                        <div class="form-group mb-5 col-md-6">
                            <label for="suffix">
                                Suffix <span class="font-weight-light small">(If applicable)</span>
                            </label>
                            <select id="suffix" name="suffix" class="custom-select @error("suffix") is-invalid @enderror">
                                <option value="0" @if (old('suffix') && old('suffix') == '0') selected @endif></option>
                                @foreach (\App\Models\Suffix::get() as $suffix)
                                    <option value="{{ $suffix->id }}" @if (old('suffix') && old('suffix') == $suffix->id) selected @endif>{{ $suffix->display_name }}</option>
                                @endforeach
                            </select>

                            @error('suffix')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('suffix') }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-5 col-md-6">
                            <label for="dob">
                                Date of Birth <span class="font-weight-light small">(<strong>If you are using a mobile browser, please tap the year or arrow near the year to select the year of birth.)</strong></span>
                            </label>
                            <input id="dob" name="dateOfBirth" class="form-control @error("dateOfBirth") is-invalid @enderror" type="date" value="{{ old('dateOfBirth') }}" required aria-required="true">
                            <p>Age: {{ $fillable ?? ''->age }} years old</p>
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
                            Email Address <br>
                            <span class="font-weight-light small">Each registration must have a unique email address. If you would like to register multiple individuals using the same email address, please contact the Vaccination Hotline at <a href="tel:863-298-7500">(863) 298-7500</a>. </span>
                        </label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="name@address.com">

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
                            Password <span class="font-weight-light small">(Password length is a minimum of 8 characters)</span>
                        </label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Create your password">

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
                    <button class="btn btn-header btn-round btn-lg btn-block" type="submit">
                        Register
                    </button>
                </form>

                <!-- Text -->
                <p class="mb-0 font-size-sm text-muted">
                    Already have an account? <a class="ml-1" href="{{ route('login') }}">Log in</a>
                </p>
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

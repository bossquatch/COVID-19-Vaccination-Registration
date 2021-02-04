<div class="row mb-6">
    <div class="col-12 col-md-8 ml-auto mr-auto">
        <div class="form-group">
            <label for="email" aria-label="{{ __('Email') }}" title="{{ __('Email') }}">
                <span class="fad fa-user fa-fw"></span> Email
            </label>

            <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ? old('email') : ($user ? $user->email : '') }}" required placeholder="Email">

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first("email") }}</strong>
                </span>
            @enderror
        </div>

        <div class="row">
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="firstName" aria-label="firstName" title="First Name">
                        <span class="fad fa-user-tag fa-fw"></span> First Name
                    </label>
        
                    <input id="firstName" type="text" class="form-control @error('firstName') is-invalid @enderror" name="firstName" value="{{ old('firstName') ? old('firstName') : ($user ? $user->first_name : '') }}" required placeholder="First Name">
        
                    @error('firstName')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first("firstName") }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="middleName" aria-label="middleName" title="Middle Name">
                        <span class="fad fa-user-tag fa-fw"></span> Middle Name
                    </label>
        
                    <input id="middleName" type="text" class="form-control @error('middleName') is-invalid @enderror" name="middleName" value="{{ old('middleName') ? old('middleName') : ($user ? $user->middle_name : '') }}" placeholder="Middle Name">
        
                    @error('middleName')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first("middleName") }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="lastName" aria-label="lastName" title="Last Name">
                        <span class="fad fa-user-tag fa-fw"></span> Last Name
                    </label>
        
                    <input id="lastName" type="text" class="form-control @error('lastName') is-invalid @enderror" name="lastName" value="{{ old('lastName') ? old('lastName') : ($user ? $user->last_name : '') }}" required placeholder="Last Name">
        
                    @error('lastName')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first("lastName") }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="role" aria-label="role" title="role">
                <span class="fad fa-badge-check fa-fw"></span> Role
            </label>

            <select id="role" type="text" class="form-control @error('role') is-invalid @enderror" name="role" required>
                @foreach ($roles as $role)
                    @if ($role->name == 'red_leader')
                        @can('skeleton_key')
                        <option value="{{ $role->name }}" @if ($userRole && $userRole->name == $role->name) selected @endif>{{ $role->label }}</option>        
                        @endcan
                    @else
                    <option value="{{ $role->name }}" @if ($userRole && $userRole->name == $role->name) selected @endif>{{ $role->label }}</option>
                    @endif
                @endforeach
            </select>

            @error('role')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first("role") }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
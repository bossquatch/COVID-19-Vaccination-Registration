<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Rules\AtLeastThirteen;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $valid_suffixes = '0,'.implode(",",\App\Models\Suffix::pluck('id')->toArray());

        return Validator::make($data, [
            'firstName' => ['required', 'string', 'max:255'],
            'middleName' => ['nullable', 'string', 'max:30'],
            'lastName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'regex:/^(?=.*[0-9])[- +()0-9]+$/', 'max:14'],
            'dateOfBirth' => ['required', 'date', new AtLeastThirteen],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'suffix' => ['required', 'in:'.$valid_suffixes],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'first_name' => $data['firstName'],
            'middle_name' => $data['middleName'],
            'last_name' => $data['lastName'],
            'email' => $data['email'],
            'phone' => preg_replace('/\D/', '', $data['phone']),
            'birth_date' => Carbon::parse($data['dateOfBirth']),
            'password' => Hash::make($data['password']),
            'suffix' => ($data['suffix'] != '0' ? $data['suffix'] : null),
        ]);

        $this->logChanges($user, 'created', false, true);

        $user->assignRole('user');

        return $user;
    }
}

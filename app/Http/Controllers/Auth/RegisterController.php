<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Rules\Password;

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
        return Validator::make($data, [
            'username' => [
                'required',
                'string',
                'min:4',
                'max:30',
                'unique:users',
                'regex: /^(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/'
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:50',
                'unique:users'
            ],
            'password' => [
                'required',
                'string',
                'min:5',
                'max:255'
            ],
            'password_confirmation' => [
                'required',
                'same:password'
            ],
            'first_name' => [
                'required',
                'max:30'
            ],
            'last_name' => [
              'required',
              'max:30'
            ],
            'phone_number' =>[
                'required',
                'max:15',
                'regex: /^[+0-9]*$/'
            ]
        ],
        [
            'username.required' => 'Username field is required',
            'username.min' => 'Username must contain 4 characters',
            'username.max' => 'Username cannot be longer than 30 characters',
            'username.unique' => 'Username already exists',
            'username.regex' => 'This username is not allowed',

            'email.required' => 'Email field is required',
            'email.email' => 'Please enter valid email address',
            'email.max' => 'Email cannot be longer than 50 characters',
            'email.unique'=> 'Email already exists',

            'password.required' => 'Password field is required',
            'password.min' => 'Password must contain 5 characters',
            'password.max' => 'Password cannot be longer than 255 characters',

            'password_confirmation.required'=> 'Password confirmation field is required',
            'password_confirmation.same' => 'Password confirmation has to be same as password',

            'first_name.required' => ' First name field is required',
            'first_name.max' => 'First name cannot be longer than 30 characters',

            'last_name.required' => 'Last name field is required',
            'last_name.max' => 'Last name cannot be longer than 30 characters',

            'phone_number.required' => 'Phone number field is required',
            'phone_number.max' => 'Phone number cannot be longer than 15 characters',
            'phone_number.regex' => 'Number cannot have any special chars or whitespaces'
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
            'username' => $data['username'],
            'first_name' => $data['first_name'],
            'last_name'=> $data['last_name'],
            'gender' => $data['gender'] ?? null,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone_number'=> $data['phone_number'],
        ]);

        UserRole::create([
            'user_id' => $user->id,
            'role_id' => '4'
        ]);

        return $user;
    }
}

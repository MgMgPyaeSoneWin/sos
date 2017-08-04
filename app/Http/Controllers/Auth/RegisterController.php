<?php

namespace App\Http\Controllers\Auth;

use App\Address;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/home';

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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'fullname' => 'required|string|max:255',
            'nrc' => 'required|string|max:255',
            'address_no' => 'required|string|max:255',
            'address_street' => 'required|string|max:255',
            'address_township' => 'required|string|max:255',
            'address_city' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'phno' => 'required|string|max:255',
            'role' => 'required|string|max:255',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $address = Address::create([
            'no' => $data['address_no'],
            'street' => $data['address_street'],
            'township' => $data['address_township'],
            'city' => $data['address_city'],
        ]);

        if (!empty($address))
        {
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'fullname' => $data['fullname'],
                'nrc' => $data['nrc'],
                'address_id' => $address->id,
                'gender' => $data['gender'],
                'phno' => $data['phno'],
                'role' => $data['role'],
            ]);
        }
    }
}

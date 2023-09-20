<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
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
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255','unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:3', 'confirmed'],
        ],[
            'name.required' => 'Họ và tên không được bỏ trống',
            'username.required' => 'Tài khoản không được bỏ trống',
            'username.unique' => 'Tài khoản đã tồn tại',
            'email.required' => 'Email không được bỏ trống',
            'email.unique' => 'Email đã tồn tại',            
            'password.required' => 'Mật khẩu không được bỏ trống',
            'password.min' => 'Mật khẩu không được nhỏ hơn :min ký tự',
            'password.confirmed' => 'Mật khẩu không khớp',
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
        $slice = Str::beforeLast($data['email'], '@');        
        $username = $data['username'] ?? $slice;        
        return User::create([
            'name' => $data['name'],
            'username' => $username,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
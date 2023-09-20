<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }
    
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string|min:3',
        ],[
            $this->username().'.required' => 'Tên đăng nhập không được bỏ trống.',
            $this->username().'.string' => 'Tên đăng nhập kiểu dữ liệu phải là chuỗi.',
            'password.required' => 'Mật khẩu bắt buộc phải nhập',
            'password.min' => 'Mật khẩu ít nhất :min ký tự',
        ]);
    }
    public function username()
    {
        return 'username';
    }
    protected function credentials(Request $request)
    {
        $fieldb = 'username';
        if(filter_var($request->username,FILTER_VALIDATE_EMAIL)){
            $fieldb = 'email';
        }
        $dataArr = [
            $fieldb => $request->username,
            'password' => $request->password
        ];
        return $dataArr;
        //return $request->only($this->username(), 'password');
    }
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => ['Tên đăng nhập hoặc mật khẩu không hợp lệ'],
        ]);
    }
}
 
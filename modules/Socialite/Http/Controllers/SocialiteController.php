<?php

namespace Modules\Socialite\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

use Auth;
use App\Models\User;

class SocialiteController extends Controller
{  
    public function __construct()
    {
       // $this->middleware("auth");
    }
    public function index()
    {
        $title='Socialite View index.blade.php';
        return view('Socialite::index',compact('title'));
    }
    public function google()
    {
        return Socialite::driver('google')->redirect();
    }
    public function googleCallback()
    {
        $userGoogle = Socialite::driver('google')->user();    
        //dd($userGoogle);    
        $user  = User::where('email', $userGoogle->getEmail())->first();
        if(!$user){                     
            $user = new User();
            $user->name = $userGoogle->getName();
            $user->email = $userGoogle->getEmail();
            // $user->provider_id = $userGoogle->getId();
            // $user->provider = 'google';
            $user->password = Hash::make(rand());
            //$user->group_id = 1;
            $user->save();            
        }
        $userId = $user->id;        
        Auth::loginUsingId($userId);
        return redirect($this->redirectTo);
    }
    public function facebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookCallback()
    {
        $userFacebook = Socialite::driver('facebook')->user();
        $user  = User::where('email', $userFacebook->getEmail())->first();
        dd($user);            
        if (!$user) {            
            $user = new User();
            $user->name = $userFacebook->getName();
            $user->email = $userFacebook->getEmail();
            $user->provider_id = $userFacebook->getId();
            $user->provider = 'facebook';
            $user->password = Hash::make(rand());
            $user->group_id = 1;
            $user->save();
        }
        $userId = $user->id;
        Auth::loginUsingId($userId);
        return redirect($this->redirectTo);
    }
}
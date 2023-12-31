<?php
use App\Jobs\ProcessPodcast;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {      
    return view('hamada.hamada');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/test/{name}', function ($name) {
    $jobs = [
        'name' => $name,
        'status' => 200
    ];
    //ProcessPodcast::dispatch($jobs)->afterResponse();
    ProcessPodcast::dispatch($jobs)->delay(now()->addMinutes(1));
    return 'oki';
});
Route::get('/testLogin', function () {   
    echo env('DB_HOST');
    return view('auth.test-login');
});
Route::post('/testLogin', function (UserRequest $request) {   
    
})->name('test-login');

Route::get('/auth/google',[LoginController::class, 'google'])->name('auth.google');

Route::get('/auth/google/callback', [LoginController::class, 'googleCallback']);

Route::get('/auth/facebook', [LoginController::class, 'facebook'])->name('auth.facebook');

 Route::get('/auth/facebook/callback', [LoginController::class, 'facebookCallback']);
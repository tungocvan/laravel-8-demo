<?php
use App\Jobs\ProcessPodcast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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
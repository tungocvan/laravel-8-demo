<?php 
 use Illuminate\Support\Facades\Route;
 use Modules\Socialite\Http\Controllers\SocialiteController;
 Route::middleware(['web','socialite.middleware'])->prefix('/socialite')->name('socialite.')->group(function(){
     Route::get('/', [SocialiteController::class, 'index'])->name('index');
 });
 Route::middleware(['web'])->group(function(){
      Route::get('/auth/google', [SocialiteController::class, 'google'])->name('google');
      Route::get('/auth/google/callback', [SocialiteController::class, 'google'])->name('googleCallback');
      Route::get('/auth/facebook', [SocialiteController::class, 'facebook'])->name('facebook');
      Route::get('/auth/facebook/callback', [SocialiteController::class, 'google'])->name('facebookCallback');
      
 });

 
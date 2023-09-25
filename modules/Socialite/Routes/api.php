<?php 
 use Illuminate\Support\Facades\Route;
 use Modules\Socialite\Http\Controllers\api\SocialiteController;
 Route::middleware(['api'])->prefix('/api/socialite')->name('api.socialite.')->group(function(){
     Route::get('/', [SocialiteController::class, 'index'])->name('index');
});
 
  
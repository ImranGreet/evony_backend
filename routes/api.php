<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\HomeImageController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\QusetionController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(HomeImageController::class)->prefix('admin')->group(function () {
    Route::get('/home_images_store', 'homeImageStore');
    Route::post('/create_homeimage', 'createHomeImage');
    Route::get('/editHomeImage', 'editHomeImage');
    Route::put('/updateHomeImage', 'updateHomeImage');
    Route::delete('/deleteHomeImage', 'deleteHomeImage');
});


Route::controller(SliderController::class)->prefix('admin')->group(function () {
    Route::post('/create_Slider', 'createSlider');
    Route::get('/editSlider', 'editSlider');
    Route::put('/updateSlider', 'updateSlider');
    Route::delete('/deleteSlider', 'deleteSlider');
});



Route::controller(BlogController::class)->prefix('admin')->group(function () {
    Route::post('/create_Blog', 'createBlog');
    Route::get('/editBlog', 'editBlog');
    Route::put('/updateBlog', 'updateBlog');
    Route::delete('/deleteBlog', 'deleteBlog');
});

Route::apiResource('user', UserController::class);

Route:: get('questions', [QusetionController::class, 'index']);
Route:: post('questions', [QusetionController::class, 'store']);

Route::controller(StripePaymentController::class)->group(function(){
    Route::get('stripe', 'stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});

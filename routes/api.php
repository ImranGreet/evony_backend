<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\HomeImageController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\client\HomePageController;
use App\Http\Controllers\QusetionController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware(['auth:sanctum'])->controller(HomeImageController::class)->prefix('admin')->group(function () {
    Route::get('/home_images_store', 'homeImageStore');
    Route::post('/create_homeimage', 'createHomeImage');
    Route::get('/editHomeImage', 'editHomeImage');
    Route::put('/updateHomeImage', 'updateHomeImage');
    Route::delete('/deleteHomeImage', 'deleteHomeImage');
});


// Slider routes with authentication
Route::prefix('admin')->controller(SliderController::class)->group(function () {
    Route::post('/create_Slider', 'createSlider');
    Route::get('/editSlider', 'editSlider');
    Route::put('/updateSlider/{id}', 'updateSlider')->where('id', '[0-9]+');
    Route::delete('/deleteSlider/{id}', 'deleteSlider')->where('id', '[0-9]+');
});

Route::prefix('admin')->controller(BlogController::class)->group(function () {
    Route::post('/create_Blog', 'createBlog');
    Route::get('/editBlog/{id}', 'editBlog');
    Route::post('/updateBlog/{id}', 'updateBlog');
    Route::post('/deleteBlog/{id}', 'deleteBlog');
    Route::post('/is_active/{id}', 'isActive');
});




Route::apiResource('user', UserController::class);


Route:: get('questions', [QusetionController::class, 'index']);
Route:: post('questions', [QusetionController::class, 'store']);






Route::controller(StripePaymentController::class)->group(function () {
    Route::get('stripe', 'stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});


Route::controller(HomePageController::class)->group(function () {
    Route::get('/getHomeImages', 'getHomeImage');
    Route::get('/getSiders', 'getSlides');
    Route::get('/getBlogs', 'getBlogs');
});

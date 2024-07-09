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

Route::get('/HomeImages', [HomeImageController::class, 'FilterHomeImages']);
Route::prefix('admin')->controller(HomeImageController::class)->group(function () {
    Route::get('/getHomeImages', 'index');
    Route::post('/createHomeImage', 'createHomeImage');
    Route::get('/editHomeImage/{id}', 'editHomeImage');
    Route::post('/updateHomeImage/{id}', 'updateHomeImage');
    Route::post('/deleteHomeImage/{id}', 'deleteHomeImage');
    Route::post('/is_active_home_image/{id}', 'isActive');
});


// Slider routes with authentication
Route::get('/Sliders', [SliderController::class, 'FilterSliders']);
Route::prefix('admin')->controller(SliderController::class)->group(function () {
    Route::get('/getSliders', 'index');
    Route::post('/create_Slider', 'createSlider');
    Route::get('/editSlider/{id}', 'editSlider');
    Route::post('/updateSlider/{id}', 'updateSlider');
    Route::delete('/deleteSlider/{id}', 'deleteSlider');
    Route::post('/is_active_slider/{id}', 'isActive');
});

Route::get('/Blogs', [BlogController::class, 'FilterBlogs']);
Route::prefix('admin')->controller(BlogController::class)->group(function () {
    Route::get('/getBlogs', 'index');
    Route::post('/create_Blog', 'createBlog');
    Route::get('/editBlog/{id}', 'editBlog');
    Route::post('/updateBlog/{id}', 'updateBlog');
    Route::post('/deleteBlog/{id}', 'deleteBlog');
    Route::post('/is_active_blog/{id}', 'isActive');
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

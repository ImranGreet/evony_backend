<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\HomeImage;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function getBlogs(){
        $blogs = Blog::take(3)->get();;
        return response()->json([
            "blogs" => $blogs
        ]);
    }

    public function getSlides(){
        $sliders = Slider::all();
        return response()->json([
            "slides" => $sliders,
        ]);
    }

    public function getHomeImage(){
        $homeImage = HomeImage::all();
        return response()->json([
            'homeImages'=>$homeImage,
        ]);
    }
}

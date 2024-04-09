<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function createSlider(Request $request)
    {
        $request->validate([
            'slider_title' => ['required', 'string', 'max:255'],
            'slider_thumbnail'=>['required', 'string', 'max:255'],
            'slider_desc'=>['required', 'string', 'max:255'],
        ]);

        $slider = new Slider();
        $slider->slider_title = $request->slider_title;
        $slider->slider_thumbnail = $request->slider_thumbnail;
        $slider->slider_desc = $request->slider_desc;
        $slider->save();

        return response()->json([
            "message" => "Slider Created Successfully!"
        ]);

    }

    public function editSlider(Request $request, $id){
        /*Model*/
       $slider = Slider::where("id",'=',$id)->first();
       
       if($slider){
         return response()->json([
           "message" => "Slider Found Succesfully!",
           "blog" => $slider
       ]);
       }else{
           return response()->json([
           "message" => "Slider Not Found!",
       ]);
       }
   }

   public function updateSlider(Request $request,$id){

    $request->validate([
        'slider_title' => ['required', 'string', 'max:255'],
        'slider_thumbnail' => [ 'max:255'],
        'slider_description' => ['required', 'string'],
    ]);

    $slider =  Slider::find($id);

    if ($request->slider_thumbnail != null) {
        $fileName = md5(mt_rand(10000, 99999) . time()) . '.' . $request->slider_thumbnail->extension();
        $request->slider_thumbnail->move(storage_path('app/public/image'), $fileName);
        $slider->slider_thumbnail = $fileName;
    }

    $slider->slider_title = $request->slider_title;
   
    $slider->slider_description = $request->slider_description;

    $slider->save();

    
    return response()->json([
        "message" => "Slider is created Successfully!"
    ]);
}

   public function deleteSlider(Request $request, $id){
    /*delete category by Id*/
     Slider::find($id)->delete();

     return response()->json([
        "message" => "Slider Deleted Successfully!"
    ]);
}
}

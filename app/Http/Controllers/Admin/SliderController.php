<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class SliderController extends Controller
{
    public function createSlider(Request $request)
    {
        $request->validate([
            'slider_title' => ['required', 'string', 'max:255'],
            'slider_thumbnail' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'slider_desc' => ['required', 'string', 'max:255'],
        ]);

        // Handle the file upload
        if ($request->hasFile('slider_thumbnail')) {
            $file = $request->file('slider_thumbnail');
            $path = $file->store('sliders', 'public');
        } else {
            return response()->json(["message" => "Image upload failed"], 400);
        }

        $slider = new Slider();
        $slider->slider_title = $request->slider_title;
        $slider->slider_thumbnail = $path;
        $slider->slider_desc = $request->slider_desc;
        $slider->save();

        return response()->json([
            "message" => "Slider Created Successfully!",
            "slider" => $slider
        ]);
    }

    public function editSlider(Request $request, $id)
    {
        $slider = Slider::find($id);

        if ($slider) {
            return response()->json([
                "message" => "Slider Found Successfully!",
                "slider" => $slider
            ]);
        } else {
            return response()->json([
                "message" => "Slider Not Found!",
            ], 404);
        }
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
        $image = $request->file('image');
        $fileName = md5(mt_rand(10000, 99999) . time()) . '.' . $image->getClientOriginalExtension();
        $path = Storage::putFileAs('image', $image , $fileName);
        $slider->slider_thumbnail = $path;
    }

    $slider->slider_title = $request->slider_title;

    $slider->slider_description = $request->slider_description;
=======
    public function updateSlider(Request $request, $id)
    {
        $request->validate([
            'slider_title' => ['required', 'string', 'max:255'],
            'slider_thumbnail' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'slider_desc' => ['required', 'string', 'max:255'],
        ]);

        $slider = Slider::find($id);

        if (!$slider) {
            return response()->json(["message" => "Slider Not Found!"], 404);
        }

        if ($request->hasFile('slider_thumbnail')) {
            // Delete the old image from storage
            if ($slider->slider_thumbnail) {
                Storage::disk('public')->delete($slider->slider_thumbnail);
            }

            // Store the new image
            $file = $request->file('slider_thumbnail');
            $path = $file->store('sliders', 'public');
            $slider->slider_thumbnail = $path;
        }

        $slider->slider_title = $request->slider_title;
        $slider->slider_desc = $request->slider_desc;

        $slider->save();

        return response()->json([
            "message" => "Slider Updated Successfully!",
            "slider" => $slider
        ]);
    }

    public function deleteSlider(Request $request, $id)
    {
        $slider = Slider::find($id);


        if (!$slider) {
            return response()->json(["message" => "Slider Not Found!"], 404);
        }


    return response()->json([
        "message" => "Slider is created Successfully!"
    ]);
}

        // Delete the image from storage
        if ($slider->slider_thumbnail) {
            Storage::disk('public')->delete($slider->slider_thumbnail);
        }


        // Delete the database record
        $slider->delete();

        return response()->json([
            "message" => "Slider Deleted Successfully!"
        ]);
    }
}

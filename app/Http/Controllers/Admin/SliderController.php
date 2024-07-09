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
            'slider_thumbnail' => ['required'],
            'slider_desc' => ['required'],
        ]);

        $slider =  new Slider();

        $slider->slider_title = $request->slider_title;
        $slider->slider_desc = $request->slider_desc;

        if ($request->hasFile('slider_thumbnail')) {
            $image = $request->file('slider_thumbnail');
            $fileName = md5(mt_rand(10000, 99999) . time()) . '.' . $image->getClientOriginalExtension();
            $path = Storage::putFileAs('image', $image, $fileName);
            $slider->slider_thumbnail = $path;
        }

        $slider->save();

        return response()->json([
            "message" => "Slider Created Successfully!"
        ]);
    }

    public function editSlider(Request $request, $id)
    {
        $slider = Slider::find($id);

        if ($slider) {
            return response()->json([
                "slider" => $slider
            ]);
        } else {
            return response()->json([
                "message" => "Slider Not Found!",
            ]);
        }
    }

    public function updateSlider(Request $request, $id)
    {

        $request->validate([
            'slider_title' => ['required', 'string', 'max:255'],
            'slider_thumbnail' => ['max:255'],
            'slider_description' => ['required'],
        ]);

        $slider =  Slider::find($id);

        $slider->slider_title = $request->slider_title;
        $slider->slider_description = $request->slider_description;

        if ($request->hasFile('slider_thumbnail')) {
            if ($slider->slider_thumbnail) {
                Storage::delete($slider->slider_thumbnail);
            }

            $image = $request->file('slider_thumbnail');
            $fileName = md5(mt_rand(10000, 99999) . time()) . '.' . $image->getClientOriginalExtension();
            $path = Storage::putFileAs('image', $image, $fileName);
            $slider->slider_thumbnail = $path;
        }

        $slider->save();


        return response()->json([
            "message" => "Slider is update Successfully!"
        ]);
    }

    public function deleteSlider(Request $request, $id)
    {
        $slider = Slider::find($id);

        if ($slider) {
            if ($slider->slider_thumbnail) {
                Storage::delete($slider->slider_thumbnail);
            }

            $slider->delete();

            return response()->json([
                "message" => "Slider is deleted Successfully!"
            ]);
        } else {
            return response()->json([
                "message" => "Slider Not Found!",
            ]);
        }
    }

    public function isActive($id){
        $slider = Slider::find($id);

        if ($slider) {

            if(Slider::where('is_active', 1)->count() > 6){
                return response()->json([
                    "message" => "You can't activate more than 6 sliders!",
                ]);
            }

            if($slider->is_active == 0){
                $slider->is_active = 1;
            }else{
                $slider->is_active = 0;
            }

            $slider->save();

            return response()->json([
                "message" => "Slider is update Successfully!"
            ]);
        } else {
            return response()->json([
                "message" => "Slider Not Found!",
            ]);
        }
    }

    public function index(){
        $slider = Slider::all();

        return response()->json([
            "slider" => $slider
        ]);
    }

    public function FilterSliders(){
        $slider = Slider::where('is_active', 1)->get();

        return response()->json([
            "slider" => $slider
        ]);
    }
}

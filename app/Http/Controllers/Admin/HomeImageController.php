<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class HomeImageController extends Controller
{
    public function createHomeImage(Request $request)
    {

        $request->validate([
            'homeimage_title' => ['required', 'string', 'max:255'],
            'homeimage_thumbnail' => ['required'],
            'homeimage_desc' => ['required'],
        ]);

        $homeImage = new HomeImage();
        $homeImage->homeimage_title = $request->homeimage_title;
        $homeImage->homeimage_desc = $request->homeimage_desc;

        // Handle the file upload
        if ($request->hasFile('homeimage_thumbnail')) {
            $image = $request->file('homeimage_thumbnail');
            $fileName = md5(mt_rand(10000, 99999) . time()) . '.' . $image->getClientOriginalExtension();
            $path = Storage::putFileAs('image', $image, $fileName);
            $homeImage->homeImage_thumbnail = $path;
        }

        $homeImage->save();

        return response()->json([
            "message" => "HomeImage Created Successfully!"
        ]);
    }

    public function editHomeImage($id)
    {
        $homeImage = HomeImage::find($id);

        if ($homeImage) {
            return response()->json([
                "homeImage" => $homeImage
            ]);
        } else {
            return response()->json([
                "message" => "Homeimage Not Found!",
            ]);
        }
    }

    public function updateHomeImage(Request $request, $id)
    {
        $request->validate([
            'homeimage_title' => ['required', 'string', 'max:255'],
            'homeimage_desc' => ['required'],
        ]);

        $homeImage = HomeImage::find($id);

        $homeImage->homeimage_title = $request->homeimage_title;
        $homeImage->homeimage_desc = $request->homeimage_desc;

        if ($request->hasFile('homeimage_thumbnail')) {
            // Delete the old image from storage
            if ($homeImage->homeimage_thumbnail) {
                Storage::delete($homeImage->homeimage_thumbnail);
            }

            $image = $request->file('homeimage_thumbnail');
            $fileName = md5(mt_rand(10000, 99999) . time()) . '.' . $image->getClientOriginalExtension();
            $path = Storage::putFileAs('image', $image, $fileName);
            $homeImage->homeImage_thumbnail = $path;
        }

        $homeImage->save();

        return response()->json([
            "message" => "HomeImage Updated Successfully!"
        ]);
    }

    public function deleteHomeImage(Request $request, $id)
    {
        $homeImage = HomeImage::find($id);

        if ($homeImage->homeimage_thumbnail) {
            Storage::delete($homeImage->homeimage_thumbnail);
        }
        $homeImage->delete();

        return response()->json([
            "message" => "HomeImage Deleted Successfully!"
        ]);
    }

    public function isActive($id){
        $homeImage = HomeImage::find($id);

        if(HomeImage::where('is_active', 1)->count() >= 6){
            return response()->json([
                "message" => "You can't activate more than 6 HomeImages!"
            ]);
        }

        if($homeImage->is_active == 0){
            $homeImage->is_active = 1;
        }else{
            $homeImage->is_active = 0;
        }
        $homeImage->save();

        return response()->json([
            "message" => "HomeImage Updated Successfully!"
        ]);
    }

    public function index(){
        $homeImage = HomeImage::all();

        return response()->json([
            "homeImage" => $homeImage
        ]);
    }

    public function FilterHomeImages(){
        $homeImage = HomeImage::where('is_active', 1)->get();

        return response()->json([
            "homeImage" => $homeImage
        ]);
    }
}

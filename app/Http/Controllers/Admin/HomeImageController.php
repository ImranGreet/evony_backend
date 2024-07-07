<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class HomeImageController extends Controller
{

    public function homeImageStore()
    {

        $homeImages = HomeImage::all();
        if ($homeImages) {
            return response()->json([
                "message" => "Home images are found",
                "homeImages" => $homeImages
            ]);
        } else {
            return response()->json([
                "message" => "Home images are not found",

            ]);
        }
    }





    public function createHomeImage(Request $request)
    {

        $request->validate([
            'homeimage_title' => ['required', 'string', 'max:255'],
            'homeimage_thumbnail' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'homeimage_desc' => ['required', 'string', 'max:255'],
        ]);

        // Handle the file upload
        if ($request->hasFile('homeimage_thumbnail')) {
            $file = $request->file('homeimage_thumbnail');
            $path = $file->store('home_images', 'public');  // Save the image in the 'storage/app/public/home_images' directory
        } else {
            return response()->json(["message" => "Image upload failed"], 400);
        }

        $homeImage = new HomeImage();
        $homeImage->homeimage_title = $request->homeimage_title;
        $homeImage->homeimage_thumbnail = $path;
        $homeImage->homeimage_desc = $request->homeimage_desc;

        $homeImage->save();

        return response()->json([
            "message" => "HomeImage Created Successfully!",
            "data" => $homeImage
        ]);
    }

    public function editHomeImage(Request $request, $id)
    {
        /*Model*/
        $homeImage = HomeImage::where("id", '=', $id)->first();

        if ($homeImage) {
            return response()->json([
                "message" => "Homeimage Found Succesfully!",
                "blog" => $homeImage
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

            'homeimage_description' => ['required'],

            'homeimage_thumbnail' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'homeimage_description' => ['required', 'string'],

        ]);

        $homeImage = HomeImage::find($id);

        if ($request->homeImage_thumbnail != null) {
            $image = $request->file('image');
            $fileName = md5(mt_rand(10000, 99999) . time()) . '.' . $image->getClientOriginalExtension();
            $path = Storage::putFileAs('image', $image, $fileName);
            $homeImage->homeImage_thumbnail = $path;

            if (!$homeImage) {
                return response()->json([
                    "message" => "HomeImage Not Found!"
                ], 404);
            }

            if ($request->hasFile('homeimage_thumbnail')) {
                // Delete the old image from storage
                if ($homeImage->homeimage_thumbnail) {
                    Storage::disk('public')->delete('image/' . $homeImage->homeimage_thumbnail);
                }

                // Store the new image
                $file = $request->file('homeimage_thumbnail');
                $fileName = md5(mt_rand(10000, 99999) . time()) . '.' . $file->extension();
                $file->move(storage_path('app/public/image'), $fileName);
                $homeImage->homeimage_thumbnail = $fileName;
            }

            $homeImage->homeimage_title = $request->homeimage_title;
            $homeImage->homeimage_description = $request->homeimage_description;

            $homeImage->save();

            return response()->json([
                "message" => "HomeImage Updated Successfully!",
                "homeimage" => $homeImage
            ]);
        }
    }

    public function deleteHomeImage(Request $request, $id)
    {
        $homeImage = HomeImage::find($id);

        if (!$homeImage) {
            return response()->json([
                "message" => "HomeImage Not Found!"
            ], 404);
        }

        // Delete the image file from storage
        if ($homeImage->homeimage_thumbnail) {
            Storage::disk('public')->delete('image/' . $homeImage->homeimage_thumbnail);
        }

        // Delete the database record
        $homeImage->delete();

        return response()->json([
            "message" => "HomeImage Deleted Successfully!"
        ]);
    }
}

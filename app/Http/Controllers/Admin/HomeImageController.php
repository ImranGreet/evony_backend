<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeImage;
use Illuminate\Http\Request;

class HomeImageController extends Controller
{
    public function createHomeImage(Request $request)
    {
        $request->validate([
            'homeimage_title' => ['required', 'string', 'max:255'],
            'homeimage_thumbnail'=>['required', 'string', 'max:255'],
            'homeimage_desc'=>['required', 'string', 'max:255'],
        ]);

        $homeImage = new HomeImage();
        $homeImage->homeImage_title = $request->homeImage_title;
        $homeImage->homeImage_thumbnail = $request->homeImage_thumbnail;
        $homeImage->homeImage_desc = $request->homeImage_desc;
        $homeImage->save();

        return response()->json([
            "message" => "HomeImage Created Successfully!"
        ]);

    }

    public function editHomeImage(Request $request, $id){
        /*Model*/
       $homeImage = HomeImage::where("id",'=',$id)->first();
       
       if($homeImage){
         return response()->json([
           "message" => "Homeimage Found Succesfully!",
           "blog" => $homeImage
       ]);
       }else{
           return response()->json([
           "message" => "Homeimage Not Found!",
       ]);
       }
   }

   public function deleteBlog(Request $request, $id){
    /*delete category by Id*/
     HomeImage::find($id)->delete();

     return response()->json([
        "message" => "Homeimage Deleted Successfully!"
    ]);
}
}

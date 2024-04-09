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

   public function updateHomeImage(Request $request,$id){

    $request->validate([
        'homeimage_title' => ['required', 'string', 'max:255'],
        'homeimage_thumbnail' => [ 'max:255'],
        'homeimage_description' => ['required', 'string'],
    ]);

    $homeImage =  HomeImage::find($id);

    if ($request->homeImage_thumbnail != null) {
        $fileName = md5(mt_rand(10000, 99999) . time()) . '.' . $request->homeImage_thumbnail->extension();
        $request->homeImage_thumbnail->move(storage_path('app/public/image'), $fileName);
        $homeImage->homeImage_thumbnail = $fileName;
    }

    $homeImage->homeImage_title = $request->homeimage_title;
   
    $homeImage->homeImage_description = $request->homeimage_description;

    $homeImage->save();

    
    return response()->json([
        "message" => "Homeimage is updated Successfully!"
    ]);
}

   public function deleteBlog(Request $request, $id){
    /*delete category by Id*/
     HomeImage::find($id)->delete();

     return response()->json([
        "message" => "Homeimage Deleted Successfully!"
    ]);
}
}

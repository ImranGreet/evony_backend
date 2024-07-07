<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function createBlog(Request $request)
    {
        $request->validate([
            'blog_title' => ['required', 'string', 'max:255'],
            'blog_thumbnail'=>['required', 'string', 'max:255'],
            'blog_desc'=>['required', 'string', 'max:255'],
        ]);

        $blog = new Blog();
        $blog->blog_title = $request->blog_title;
        $blog->blog_thumbnail = $request->blog_thumbnail;
        $blog->blog_desc = $request->blog_desc;
        $blog->save();

        return response()->json([
            "message" => "blog Created Successfully!"
        ]);

    }

    public function editBlog(Request $request, $id){
        /*Model*/
       $blog = Blog::where("id",'=',$id)->first();

       if($blog){
         return response()->json([
           "message" => "Blog Found Succesfully!",
           "blog" => $blog
       ]);
       }else{
           return response()->json([
           "message" => "Blog Not Found!",
       ]);
       }
   }



   public function updateBlog(Request $request,$id){

    $request->validate([
        'blog_title' => ['required', 'string', 'max:255'],
        'blog_description' => ['required'],
    ]);

    $blog =  Blog::find($id);

    if ($request->blog_thumbnail != null) {
        $image = $request->file('image');
        $fileName = md5(mt_rand(10000, 99999) . time()) . '.' . $image->getClientOriginalExtension();
        $path = Storage::putFileAs('image', $image , $fileName);
        $blog->blog_thumbnail = $path;
    }

    $blog->blog_title = $request->slider_title;

    $blog->blog_description = $request->slider_description;

    $blog->save();


    return response()->json([
        "message" => "Slider is updated Successfully!"
    ]);
}

   public function deleteBlog(Request $request, $id){
    /*delete category by Id*/
     Blog::find($id)->delete();

     return response()->json([
        "message" => "Blog Deleted Successfully!"
    ]);
}


}

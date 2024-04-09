<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

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

   public function deleteBlog(Request $request, $id){
    /*delete category by Id*/
     Blog::find($id)->delete();

     return response()->json([
        "message" => "Blog Deleted Successfully!"
    ]);
}


}

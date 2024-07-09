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
            'blog_thumbnail' => ['required', 'max:10240'],
            'blog_desc' => ['required'],
        ]);

        $blog = new Blog();
        $blog->blog_title = $request->blog_title;
        $blog->blog_desc = $request->blog_desc;

        // Handle file upload
        if ($request->hasFile('blog_thumbnail')) {
            $image = $request->file('blog_thumbnail');
            $fileName = md5(mt_rand(10000, 99999) . time()) . '.' . $image->getClientOriginalExtension();
            $path = Storage::putFileAs('image', $image , $fileName);
            $blog->blog_thumbnail = $path;
        }

        $blog->save();

        return response()->json([
            "message" => "Blog Created Successfully!"
        ]);
    }

    public function editBlog($id){
        $blog = Blog::find($id);

        if($blog){
            return response()->json([
                "blog" => $blog
            ]);
        }else{
            return response()->json([
                "message" => "Blog Not Found!",
            ]);
        }

    }

    public function updateBlog(Request $request, $id){
        $request->validate([
            'blog_title' => ['required', 'string', 'max:255'],
            'blog_desc' => ['required'],
        ]);

        $blog = Blog::find($id);

        if($blog){
            $blog->blog_title = $request->blog_title;
            $blog->blog_desc = $request->blog_desc;

            if ($request->hasFile('blog_thumbnail')) {
                if ($blog->blog_thumbnail) {
                    Storage::delete($blog->blog_thumbnail);
                }
                $image = $request->file('blog_thumbnail');
                $fileName = md5(mt_rand(10000, 99999) . time()) . '.' . $image->getClientOriginalExtension();
                $path = Storage::putFileAs('image', $image , $fileName);
                $blog->blog_thumbnail = $path;
            }

            $blog->save();

            return response()->json([
                "message" => "Blog Updated Successfully!"
            ]);
        }else{
            return response()->json([
                "message" => "Blog Not Found!",
            ]);
        }

    }

    public function deleteBlog($id){
        $blog = Blog::find($id);

        if($blog){
            if ($blog->blog_thumbnail) {
                Storage::delete($blog->blog_thumbnail);
            }
            $blog->delete();

            return response()->json([
                "message" => "Blog Deleted Successfully!"
            ]);
        }else{
            return response()->json([
                "message" => "Blog Not Found!",
            ]);
        }

    }

    public function isActive($id){
        $blog = Blog::find($id);

        if($blog){
            if($blog->is_active == 1){
                $blog->is_active = 0;
            }else{
                $blog->is_active = 1;
            }

            $blog->save();

            return response()->json([
                "message" => "Blog Status Updated Successfully!"
            ]);
        }else{
            return response()->json([
                "message" => "Blog Not Found!",
            ]);
        }


    }
}

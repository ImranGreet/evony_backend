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
            'blog_thumbnail' => ['required', 'image', 'max:10240'], // Ensure it is an image and max size is 10MB
            'blog_desc' => ['required', 'string'],
        ]);

        $blog = new Blog();

        if ($request->hasFile('blog_thumbnail')) {
            $fileName = md5(mt_rand(10000, 99999) . time()) . '.' . $request->blog_thumbnail->extension();
            $request->blog_thumbnail->storeAs('public/image', $fileName);
            $blog->blog_thumbnail = $fileName;
        }

        $blog->blog_title = $request->blog_title;
        $blog->blog_desc = $request->blog_desc;
        $blog->save();

        return response()->json([
            "message" => "Blog Created Successfully!"
        ]);
    }

    public function editBlog(Request $request, $id)
    {
        $blog = Blog::find($id);

        if ($blog) {
            return response()->json([
                "message" => "Blog Found Successfully!",
                "blog" => $blog
            ]);
        } else {
            return response()->json([
                "message" => "Blog Not Found!",
            ]);
        }
    }

    public function updateBlog(Request $request, $id)
    {
        $request->validate([
            'blog_title' => ['required', 'string', 'max:255'],
            'blog_thumbnail' => ['image', 'max:10240'], // Ensure it is an image and max size is 10MB
            'blog_desc' => ['required', 'string'],
        ]);

        $blog = Blog::find($id);

        if ($blog) {
            if ($request->hasFile('blog_thumbnail')) {
                // Delete the old image if it exists
                if ($blog->blog_thumbnail) {
                    Storage::delete('public/image/' . $blog->blog_thumbnail);
                }

                $fileName = md5(mt_rand(10000, 99999) . time()) . '.' . $request->blog_thumbnail->extension();
                $request->blog_thumbnail->storeAs('public/image', $fileName);
                $blog->blog_thumbnail = $fileName;
            }

            $blog->blog_title = $request->blog_title;
            $blog->blog_desc = $request->blog_desc;
            $blog->save();

            return response()->json([
                "message" => "Blog Updated Successfully!"
            ]);
        } else {
            return response()->json([
                "message" => "Blog Not Found!",
            ]);
        }
    }

    public function deleteBlog($id)
    {
        $blog = Blog::find($id);

        if ($blog) {
            // Delete the image from storage
            if ($blog->blog_thumbnail) {
                Storage::delete('public/image/' . $blog->blog_thumbnail);
            }

            $blog->delete();

            return response()->json([
                "message" => "Blog Deleted Successfully!"
            ]);
        } else {
            return response()->json([
                "message" => "Blog Not Found!",
            ]);
        }
    }

    public function getBlogs(){
        $blogs = Blog::all();
        return response()->json([
            "blogs" => $blogs
        ]);
    }
}

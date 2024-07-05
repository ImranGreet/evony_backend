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
            'blog_desc' => ['required', 'string', 'max:255'],
        ]);

        // Handle file upload
        if ($request->hasFile('blog_thumbnail')) {
            $fileName = md5(mt_rand(10000, 99999) . time()) . '.' . $request->blog_thumbnail->extension();
            $request->blog_thumbnail->storeAs('public/image', $fileName);
        } else {
            return response()->json(["message" => "Image upload failed"], 400);
        }

        // Create blog entry
        $blog = new Blog();
        $blog->blog_title = $request->blog_title;
        $blog->blog_thumbnail = $fileName;
        $blog->blog_desc = $request->blog_desc;
        $blog->save();

        return response()->json([
            
            "message" => "Blog Created Successfully!"
        ]);
    }

    public function editBlog(Request $request, $id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json([
                "message" => "Blog Not Found!",
            ], 404);
        }

        return response()->json([
            "message" => "Blog Found Successfully!",
            "blog" => $blog
        ]);
    }

    public function updateBlog(Request $request, $id)
    {
        $request->validate([
            'blog_title' => ['required', 'string', 'max:255'],
            'blog_thumbnail' => ['image', 'max:10240'], // Ensure it is an image and max size is 10MB
            'blog_desc' => ['required', 'string', 'max:255'],
        ]);

        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json([
                "message" => "Blog Not Found!",
            ], 404);
        }

        // Handle file upload if provided
        if ($request->hasFile('blog_thumbnail')) {
            // Delete the old image if it exists
            if ($blog->blog_thumbnail) {
                Storage::delete('public/image/' . $blog->blog_thumbnail);
            }

            $fileName = md5(mt_rand(10000, 99999) . time()) . '.' . $request->blog_thumbnail->extension();
            $request->blog_thumbnail->storeAs('public/image', $fileName);
            $blog->blog_thumbnail = $fileName;
        }

        // Update blog details
        $blog->blog_title = $request->blog_title;
        $blog->blog_desc = $request->blog_desc;
        $blog->save();

        return response()->json([
            "message" => "Blog Updated Successfully!"
        ]);
    }

    public function deleteBlog($id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json([
                "message" => "Blog Not Found!",
            ], 404);
        }

        // Delete the image from storage if it exists
        if ($blog->blog_thumbnail) {
            Storage::delete('public/image/' . $blog->blog_thumbnail);
        }

        // Delete the blog entry from database
        $blog->delete();

        return response()->json([
            "message" => "Blog Deleted Successfully!"
        ]);
    }

    public function getBlogs()
    {
        $blogs = Blog::all();
        return response()->json([
            "blogs" => $blogs
        ]);
    }
}

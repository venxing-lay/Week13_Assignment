<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function index()
    {
        $categories = Post::paginate(10);

        return view("post.list",compact("categories"))->with(["success" => "category"]);
    }

    public function create()
    {
        $categories = Category::get();
        return view("post.create",compact("categories"));
    }

    public function store(Request $request)
    {
        $category = $request->validate([
            "title" => "required|min:3|max:35|unique:posts",
            "category_id" => "required|integer|gt:0"
        ]);

        $category["posted_by"] = Auth::user()->id;

        Post::create($category);

        return redirect()->route("post.index")->with(["success" => "Create Successfully"]);
    }

    public function edit(Post $post)
    {
        if (Gate::denies("check_permission", $post->id))
            abort(403);

        $categories = Category::get();
        return view("post.edit", compact(["post", "categories"]));
    }

    public function show(Post $post)
    {
        return view("post.show", compact("post"));
    }

    public function update(Request $request, Post $post)
    {

        $category = $request->validate([
            "title" => "filled|min:3|max:35" . $post->id,
            "category_id" => "filled|integer"
        ]);

        $category["posted_by"] = Auth::user()->id;

        $post->update($category);

        return redirect()->route("post.index")->with(["success" => "Update Successfully"]);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route("post.index")->with(["success" => "Delete Successfully"]);
    }
}

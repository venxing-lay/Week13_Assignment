<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(5);

        return view("category.list",compact("categories"))->with(["success" => "category"]);
    }

    public function create()
    {
        return view("category.create");
    }

    public function store(Request $request)
    {
        $category = $request->validate([
            "name" => "required|min:3|max:35"
        ]);

        Category::create($category);

        return redirect()->route("category.index")->with(["success" => "Create Successfully"]);
    }

    public function edit(Category $category)
    {
        return view("category.edit", compact("category"));
    }

    public function show(Category $category)
    {
        return view("category.show", compact("category"));
    }

    public function update(Request $request, Category $category)
    {
        $Category = $request->validate([
            "name" => "filled|required|min:3|max:35" . $category->id
        ]);

        $category->update($Category);

        return redirect()->route("category.index")->with(["success" => "Update Successfully"]);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route("category.index")->with(["success" => "Delete Successfully"]);
    }
}

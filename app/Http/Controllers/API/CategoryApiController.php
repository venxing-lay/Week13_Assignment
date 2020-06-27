<?php

namespace App\Http\Controllers\API;

use App\http\Controllers\controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryApiController extends Controller
{
    public function index(Request $request) {
        if($request->has('name')){
            $categories = Category::where('name', 'LIKE', '%' . $request->get('name') . '%')->get();
        } else {
            $categories = Category::get();
        }
        return response()->json([
            'success' => true,
            'message' => 'Category list',
            'data' => $categories->toArray()
        ]);
    }
    public function store(Request $request) {
        $input = $request->all();
        $validator = Validator::make($input, [
            "name" => "required|min:3|max:35"
        ]);
        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'fail to store category',
                'data' => $input
            ], 400);
        }
        $category = Category::create($input);
        return response()->json([
            'success' => true,
            'message' => 'category store successfully',
            'data' => $category
        ]);
    }

    public function update(Category $category, Request $request) {
        $input = $request->all();
        $validator = Validator::make($input, [
            "name" => "required|min:3|max:35"
        ]);
        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'fail to store category',
                'data' => $input
            ], 400);
        }

        $category->fill($input);
        $category->save();
        return response()->json([
            'success' => true,
            'message' => 'category updated successfully',
            'data' => $category
        ]);
    }

    public function delete(Category $category, Request $request) {

        $category->delete();
        return response()->json([
            'success' => true,
            'message' => 'category was deleted successfully',
            'data' => []
        ]);
    }

}

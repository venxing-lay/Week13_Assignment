<?php

namespace App\Http\Controllers\API;

use App\http\Controllers\controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryApiController extends Controller
{
    /**
        @SWG\Get(
            path="/categories",
            summary="Get categories list",
            tags={"Category"},
            produces={"application/json"},
            description="Get categories list",

            @SWG\Parameter(
                name="name",
                description="name",
                type="string",
                required=false,
                in="formData",
            ),

            @SWG\Response(
                response=200,
                description="successful",
                @SWG\Schema(
                    type="object",
                    @SWG\Property(
                            property="success",
                            type="boolean",
                        ),
                    @SWG\Property(
                            property="message",
                            type="string",
                        ),
                    @SWG\Property(
                        property="data",
                        type="object",
                        @SWG\Property(
                            property="category",
                            type="array",
                            @SWG\Items(ref="#/definitions/Category")
                        ),
                    ),   
                )
            ),
    
    
            @SWG\Response(
                response=500,
                description="interal server error (error inserting to database)",
            ),
        )
     */
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

    /**
        @SWG\Post(
            path="/categories",
            summary="Create category",
            tags={"Category"},
            produces={"application/json"},
            description="Create category",

            @SWG\Parameter(
                name="name",
                description="name",
                type="string",
                required=true,
                in="formData",
            ),

            @SWG\Response(
                response=200,
                description="store successful",
                @SWG\Schema(
                    type="object",
                    @SWG\Property(
                            property="success",
                            type="boolean",
                        ),
                    @SWG\Property(
                            property="message",
                            type="string",
                        ),
                    @SWG\Property(
                        property="data",
                        type="object",
                        @SWG\Property(
                            property="category",
                            type="array",
                            @SWG\Items(ref="#/definitions/Category")
                        ),
                    ),   
                )
            ),
    
            @SWG\Response(
                response=400,
                description="Missing field",
            ),
            @SWG\Response(
                response=500,
                description="interal server error (error inserting to database)",
            ),
        )
     */
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

    /**
        @SWG\PUT(
            path="/categories/{id}",
            summary="Update Category",
            tags={"Category"},
            produces={"application/json"},
            description="Update Category",
        
            @SWG\Parameter(
                name="category",
                description="category",
                type="string",
                required=true,
                in="formData",
            ),
            @SWG\Response(
                response=200,
                description="successful",
                @SWG\Schema(
                    type="object",
                    @SWG\Property(
                        property="success",
                        type="boolean",
                    ),
                    @SWG\Property(
                        property="message",
                        type="string",
                    ),
                    @SWG\Property(
                        property="data",
                        type="object",
                        @SWG\Property(
                            property="id",
                            type="integer",
                        ),
                        @SWG\Property(
                            property="category",
                            type="string"
                        ),
                    ),
                )
            ),
            @SWG\Response(
                response=500,
                description="interal server error (error inserting to database)",
            ),
            @SWG\Response(
                response=302,
                description="wrong validation",
            ),
        ),
     */
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
            ], 302);
        }

        $category->fill($input);
        $category->save();
        return response()->json([
            'success' => true,
            'message' => 'category updated successfully',
            'data' => $category
        ]);
    }
    /**
        @SWG\DELETE(
            path="/categories/{id}",
            summary="Delete one specific category",
            tags={"Category"},
            produces={"application/json"},
            description="Delete one specific category",
        
            @SWG\Response(
                response=200,
                description="successful",
                @SWG\Schema(
                    type="object",
                    @SWG\Property(
                        property="success",
                        type="boolean",
                    ),
                    @SWG\Property(
                        property="message",
                        type="string",
                    ),
                    @SWG\Property(
                        property="data",
                        type="object",
                    ),
                )
            ),
            @SWG\Response(
                response=500,
                description="interal server error (error inserting to database)",
            ),
            @SWG\Response(
                response=404,
                description="Category Not Found",
            ),
        )
     */
    public function delete(Category $category, Request $request) {

        $category->delete();
        return response()->json([
            'success' => true,
            'message' => 'category was deleted successfully',
            'data' => []
        ]);
    }

}

<?php

namespace App\Http\Controllers\API;

use App\http\Controllers\controller;
use App\Models\Category;
use App\Models\Post;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostApiController extends Controller
{
    /**
        @SWG\Get(
            path="/posts",
            summary="Posts list",
            tags={"Post"},
            produces={"application/json"},
            description="Posts list",
    
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
                        property="current_page",
                        type="integer",
                    ),
                    @SWG\Property(
                        property="data",
                        type="array",
                        @SWG\Items(
                            @SWG\Property(
                                property="id",
                                type="integer",
                            ),
                            @SWG\Property(
                                property="category",
                                type="string"
                            ),
                            @SWG\Property(
                                property="title",
                                type="string",
                            ),
                            @SWG\Property(
                                property="author",
                                type="string",
                            ),
                        ),
                    ),
                ),
                ),
            ),
            @SWG\Response(
                response=500,
                description="interal server error (error inserting to database)",
            ),
        )
     */
    public function index(Request $request) {
        if($request->has('name')){
            $posts = Post::where('name', 'LIKE', '%' . $request->get('name') . '%')->get();
        } else {
            $posts = Post::get();
        }
        return response()->json([
            'success' => true,
            'message' => 'Posts list',
            'data' => $posts->toArray()
        ]);
    }
    /** 
        @SWG\POST(
            path="/posts",
            summary="Create one post",
            description="Create one post",
            tags={"Post"},
            produces={"application/json"},
            
            @SWG\Parameter(
                name="category_id",
                description="category_id",
                type="integer",
                required=true,
                in="formData",
            ),
            
            @SWG\Parameter(
                name="title",
                description="title",
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
                        @SWG\Property(
                            property="title",
                            type="string",
                        ),
                        @SWG\Property(
                            property="author",
                            type="string",
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
    public function store(Request $request) {
        $input = $request->all();
        $validator = Validator::make($input, [
            "title" => "required|min:3|max:35|unique:posts",
            "category_id" => "required|integer|gt:0"
        ]);
        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'fail to store in Post',
                'data' => $input
            ], 400);
        }
        $user = User::where('role', '=', $request->get('role'))->first();
        $input['posted_by'] = '1';
        $post = Post::create($input);
        return response()->json([
            'success' => true,
            'message' => 'category store successfully',
            'data' => $post
        ]);
    }
    /** 
        @SWG\PUT(
            path="/posts/{id}",
            summary="Update one Post",
            description="Update one Post",
            tags={"Post"},
            produces={"application/json"},
        
        
            @SWG\Parameter(
                name="category_id",
                description="category_id",
                type="integer",
                required=false,
                in="formData",
            ),

            @SWG\Parameter(
                name="title",
                description="title",
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
                            property="id",
                            type="integer",
                        ),
                        @SWG\Property(
                            property="category",
                            type="string"
                        ),
                        @SWG\Property(
                            property="title",
                            type="string",
                        ),
                        @SWG\Property(
                            property="author",
                            type="string",
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
    public function update(Post $post, Request $request) {
        $input = $request->all();
        $validator = Validator::make($input, [
            "title" => "required|min:3|max:35|unique:posts",
            "category_id" => "required|integer|gt:0"
        ]);
        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'fail to store category',
                'data' => $input
            ], 400);
        }

        $post->fill($input);
        $post->save();
        return response()->json([
            'success' => true,
            'message' => 'Post updated successfully',
            'data' => $post
        ]);
    }
    /** 
        @SWG\DELETE(
            path="/post/{id}",
            summary="Delete one post",
            description="Delete one  post",
            tags={"Post"},
            produces={"application/json"},
            
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
                description="Post Not Found",
            ),
        ),
    */
    public function delete(Post $post, Request $request) {

        $post->delete();
        return response()->json([
            'success' => true,
            'message' => 'Post was deleted successfully',
            'data' => []
        ]);
    }
    
    
}

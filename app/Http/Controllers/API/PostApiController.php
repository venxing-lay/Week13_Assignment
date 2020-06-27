<?php

namespace App\Http\Controllers\API;

use App\http\Controllers\controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostApiController extends Controller
{
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
    
    
}

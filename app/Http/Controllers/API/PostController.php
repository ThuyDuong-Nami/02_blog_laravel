<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        $post = Post::all();
        return response()->json($post, 200);
    }

    public function store(PostRequest $request)
    {
        $this->authorize('create', Post::class);
        $validatedData = $request->validated();
        $user = auth('api')->user();
        $postArr = array_merge($validatedData, ['user_id' => $user->id]);
        $postAdd = Post::create($postArr);
        return response()->json($postAdd, 200);
    }
}

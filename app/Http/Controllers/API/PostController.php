<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $post = Post::all();
        return response()->json($post, 200);
    }

    public function store(PostRequest $request, Post $post)
    {
//        $this->authorize('create', Post::class);
        $validatedData = $request->validated();
        $user = auth('api')->user();
        $postAdd = Post::create(array_merge($validatedData,
            ['user_id' => $user->id]));
        return response()->json($postAdd, 200);
    }
}

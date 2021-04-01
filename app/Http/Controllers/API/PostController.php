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
        $postAdd = Post::create(array_merge($validatedData,
            ['user_id' => $user->id]));
        return response()->json($postAdd, 200);
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::where('id',$id)->first();
        $this->authorize('update', $post);
        $validatedData = $request->validated();
        $post->update($validatedData);
        return response()->json([
            'data' => $post,
            'message' => 'Update success!',
        ], 200);
    }
}

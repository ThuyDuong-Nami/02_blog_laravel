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
        if ($user){
            $postAdd = Post::create(array_merge($validatedData,
                ['user_id' => $user->id]));
            return response()->json($postAdd, 200);
        }else{
            return response()->json([
                'error' => 'Unauthorized!',
            ], 401);
        }
    }

    public function show($id)
    {
        $post = Post::all();
        $post = $post->find($id);
        return response()->json($post);
    }

    public function update(PostRequest $request, $id)
    {
        $user = auth('api')->user();
        $post = Post::where('id',$id)->first();
        $validatedData = $request->validated();
        if ($user->id == $post->user_id){
            $post->update($validatedData);
            return response()->json([
                'data' => $post,
                'message' => 'Update success!',
            ], 200);
        }else{
            return response()->json([
                'error' => 'Forbidden!',
            ], 403);
        }
    }
}

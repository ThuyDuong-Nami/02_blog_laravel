<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostResourceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->authorizeResource(Post::class);
    }
    /**
     * Display a listing of the resource.
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        $post = Post::all();
        $perPage = $request->input('perPage');
        $post = Post::paginate($perPage);
        return response()->json($post, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\PostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $validatedData = $request->validated();
        $user = auth('api')->user();
        $postArr = array_merge($validatedData, ['user_id' => $user->id]);
        $postAdd = Post::create($postArr);
        return response()->json($postAdd, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return response()->json([
            'data' => $post,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\PostRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request,Post $post)
    {
        $validatedData = $request->validated();
        $post->update($validatedData);
        return response()->json([
            'data' => $post,
            'message' => 'Update success!',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json([
            'message' => 'Delete success!',
        ], 200);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Repositories\PostRepositoryInterface;
use App\Transformers\PostTransformer;
use Illuminate\Http\Request;

class PostRepoController extends Controller
{
    protected $postRepo;

    public function __construct(PostRepository $postRepo)
    {
        $this->middleware('auth:api');
        $this->authorizeResource(Post::class);
        $this->postRepo = $postRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $perPage = request()->input('perPage');
        $posts = $this->postRepo->paginate($perPage);
        return responder()->success($posts, PostTransformer::class)->respond();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\PostRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PostRequest $request)
    {
        $validatedData = $request->validated();
        $user = auth('api')->user();
        $postArr = array_merge($validatedData, ['user_id' => $user->id]);
        $postAdd = $this->postRepo->store($postArr);
        return responder()->success($postAdd, PostTransformer::class)->respond();
    }

    /**
     * Display the specified resource.
     *
     * @param  Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Post $post)
    {
        return responder()->success($post, PostTransformer::class)->respond();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\PostRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PostRequest $request,Post $post)
    {
        $validatedData = $request->validated();
        $post = $this->postRepo->update($post->id, $validatedData);
        return responder()->success($post, PostTransformer::class)->respond();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Post $post)
    {
        $this->postRepo->destroy($post->id);
        return response()->json([
            'message' => 'Delete success!',
        ], 200);
    }
}

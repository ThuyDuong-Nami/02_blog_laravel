<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('api', ['except' => ['login', 'register']]);
    }

    public function index()
    {
        $user = auth('api')->user();
        $userPost = User::find($user->id)->posts;
        return response()->json([
            'data' => $user,
            'posts' => $userPost,
        ], 200);
    }

    public function login(LoginRequest $request)
    {

        $validatedData = $request->only(['username', 'password']);

        if ( ! $token = auth('api')->attempt($validatedData)) {
            return response()->json([
                'error' => 'Unauthorized',
            ], 401);
        }
        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json([
           'message' => 'User logout success!',
        ], 200);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_at'   => auth('api')->factory()->getTTL() * 60,
            'user'         => auth('api')->user(),
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated();
        $user = User::create($validatedData);
        return response()->json([
           'data'    => $user,
           'message' => 'User successfully registered!',
        ],201);
    }
}

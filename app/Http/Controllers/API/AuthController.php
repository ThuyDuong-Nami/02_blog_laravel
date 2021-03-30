<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('api', ['except' => ['login', 'register']]);
    }

    public function index()
    {
        $user = Auth::guard('api')->user();
        return response()->json($user, 200);
    }

    public function login(LoginRequest $request)
    {

        $validator = $request->only(['username', 'password']);

        if ( ! $token = Auth::guard("api")->attempt($validator)) {
            return response()->json([
                'error' => 'Unauthorized',
            ], 401);
        }
        return $this->respondWithToken($token);
    }

    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json([
           'message' => 'User logout success!',
        ], 200);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => Auth::guard('api')->factory()->getTTL() * 60,
            'user'         => Auth::guard('api')->user(),
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'username' => $request->input('username'),
            'email'    => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
        return response()->json([
           'data'    => $user,
           'message' => 'User successfully registered!',
        ],201);
    }
}

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['middleware' => 'api'], function (){
    Route::get('/', [API\AuthController::class, 'index']);
    Route::post('/login', [API\AuthController::class, 'login']);
    Route::get('/logout', [API\AuthController::class, 'logout']);
    Route::post('/register', [API\AuthController::class, 'register']);
//    Route::get('/posts', [API\PostController::class, 'index']);
//    Route::post('/posts/store', [API\PostController::class, 'store']);
//    Route::put('/posts/update/{id}', [API\PostController::class, 'update']);
//    Route::delete('/posts/delete/{id}', [API\PostController::class, 'destroy']);
});

Route::apiResource('post', API\PostResourceController::class);
Route::get('file', [API\FileController::class, 'readFile']);
Route::get('file/csv', [API\FileController::class, 'readCSV']);
Route::get('file/formcsv', [API\FileController::class, 'formCSV']);

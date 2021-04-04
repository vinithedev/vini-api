<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/**
 * 
 */

/**
 *  OBS: O código deste arquivo pode exigir mudanças, dependendo da sua versão do Laravel.
 *  Leia sobre em: https://laravel.com/docs/8.x/upgrade#routing
 *  Os dois exemplos a seguir funcionam:
 *  Route::get('/posts', 'App\Http\Controllers\PostController@index');
 *  Route::get('/posts', [App\Http\Controllers\PostController::class, 'index']);
 *  Mas o exemplo abaixo não funciona na última versão do Laravel:
 *  Route::get('/posts', 'PostController@index');
 */

Route::prefix('v1')->group(function () {
    Route::apiResource('posts', 'App\Http\Controllers\PostController');
});

/**
 *  OBS: O código deste arquivo pode exigir mudanças, dependendo da sua versão do Laravel.
 *  Leia sobre em: https://laravel.com/docs/8.x/upgrade#routing
 *  Os dois exemplos a seguir funcionam:
 *  Route::get('/posts', 'App\Http\Controllers\PostController@index');
 *  Route::get('/posts', [App\Http\Controllers\PostController::class, 'index']);
 *  Mas os exemplos abaixo não funcionam na última versão do Laravel:
 *  Route::get('/posts', 'PostController@index');
 *  Route::resource('posts', 'PostController');
 *  O código abaixo permite a mesma função da Route::resource(), porém, mais personalizado:
 *  use App\Http\Controllers;
 *  Route::post('/posts', [Controllers\PostController::class, 'store']);        // Create
 *  Route::get('/posts', [Controllers\PostController::class, 'index']);         // Read
 *  Route::put('/posts', [Controllers\PostController::class, 'update']);        // Update
 *  Route::delete('/posts', [Controllers\PostController::class, 'destroy']);    // Delete
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

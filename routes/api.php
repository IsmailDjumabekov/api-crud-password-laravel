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
//
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
//Route::prefix('/user')->group( function (){
//    Route::post('/register', [\App\Http\Controllers\ImageCrudController::class, 'register']);
//    Route::post('/login', [\App\Http\Controllers\ImageCrudController::class, 'login']);
//
//} );
Route::post('/register', [\App\Http\Controllers\ImageCrudController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\ImageCrudController::class, 'login']);

Route::post('/create', [\App\Http\Controllers\ImageCrudController::class, 'create']);
Route::get('/get', [\App\Http\Controllers\ImageCrudController::class, 'get']);
Route::patch('/edit/{id}', [\App\Http\Controllers\ImageCrudController::class, 'edit']);
Route::post('/update/{id}', [\App\Http\Controllers\ImageCrudController::class, 'update']);
Route::delete('/delete/{id}', [\App\Http\Controllers\ImageCrudController::class, 'delete']);
Route::post('/register', [\App\Http\Controllers\ImageCrudController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\ImageCrudController::class, 'login']);

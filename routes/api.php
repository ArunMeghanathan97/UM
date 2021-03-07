<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('list',[IndexController::class,'index']);

Route::get('list',[IndexController::class,'export']);

Route::post('add',[IndexController::class,'addUser']);

Route::post('edit',[IndexController::class,'editUser']);

Route::post('delete',[IndexController::class,'userDelete']);

Route::post('detail',[IndexController::class,'userDetail']);
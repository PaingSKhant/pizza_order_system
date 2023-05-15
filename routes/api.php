<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RouteController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//get api
Route::get('product/list',[RouteController::class,'productList']);
Route::get('category/list',[RouteController::class,'categoryList']);

//post api
Route::post('category/create',[RouteController::class,'categoryCreate']);
Route::post('contact/create',[RouteController::class,'contactCreate']);
Route::post('category/delete',[RouteController::class,'categoryDelete']);
Route::post('category/detail',[RouteController::class,'categoryDetail']);
Route::post('category/update',[RouteController::class,'categoryUpdate']);

<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\products\ProductController;
use App\Http\Controllers\reviews\ReviewController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\users\UserController;
use App\Http\Controllers\orders\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register',[AuthController::class,'register']);
Route::post('/logout',[AuthController::class,'logout']);;
Route::post('/login',[AuthController::class,'login'])->name('login');


Route::group([

    'middleware' => ['auth:sanctum']
],function (){
    Route::match(['put', 'patch'], '/update-user/{id}',[UserController::class,'updateRoles']);
   
    Route::post('/add-product',[ProductController::class,'store']);
    Route::match(['put', 'patch'], '/update-product/{id}',[ProductController::class,'update']);
    Route::delete( '/delete-product/{id}',[ProductController::class,'destroy']);
    Route::get('/u',[UserController::class,'getUsersByRole']);
    Route::get('/all-products',[ProductController::class,'index']);
  //There is something wrong right here....i wish you discover it
    Route::get('/product/{letter}',[ProductController::class,'filterProductsByCategory']);
    Route::get('/product/{id}',[ProductController::class,'show']);
    Route::get('/all-users',[UserController::class,'index']);

    //high rated product
    Route::get('/products/high',[ProductController::class,'highReviewed']);


    Route::get('/all-reviews',[ReviewController::class,'index']);
    //can add review if he buyed the product
    Route::post('/add-review',[ReviewController::class,'store']);
    Route::match(['put', 'patch'], '/update-review/{id}',[ReviewController::class,'update']);
});

Route::group([
    'prefix'=>'orders',
    'middleware' => ['auth:sanctum']
],function (){
    Route::post('/store',[OrderController::class,'store']);
    Route::get('/all',[OrderController::class,'index']);
    Route::match(['put', 'patch'], '/update/{id}',[OrderController::class,'update']);
    Route::get('/show/{id}',[OrderController::class,'show']);
    Route::get('/delete/{id}',[OrderController::class,'destroy']);
});



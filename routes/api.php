<?php

use Illuminate\Http\Request;

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

// upload product
Route::post("/uploadProduct","ProductController@uploadProduct");
Route::post("/editProduct/{id}","ProductController@editProduct");

// upload product with csv file
Route::get("/getProduct","ProductController@index");
Route::post("/uploadCSV","ProductController@uploadCSV");

// Category route

Route::post("/createCategory","CategoriesController@createCategory");

//create SubCategory 
Route::post("/createSubCategory/{id}","CategoriesController@createSubCategory");


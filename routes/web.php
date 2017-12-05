<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//use Route;

Route::get('/', 'HomeController@index');
Route::get('/article/{id}', 'Article\ArticleController@index');
Route::get("/test", "Article\ArticleController@test");

//Route::namespace('HomeController')->group(function ()
//{
//    Route::get('/', 'HomeController@index');
//    Route::get('/article/{id}', 'HomeController@show');
//    Route::get("/test", "HomeController@test");
//});

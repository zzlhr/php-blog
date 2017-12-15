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



Route::get('/', 'HomeController@index');
Route::get('/article/{id}', 'Article\ArticleController@index');
//Route::post('/article/comment', function (\Illuminate\Http\Request $request){
////    echo $fid.$id.$name.$content;
//    $fid = $request->input('fid');
//    $id = $request->input('id');
//    $name = $request->input('name');
//    $content = $request->input('content');
//
//    return ArticleController::comment($id,$fid, $name, $content);
//});
Route::post('/article/comment', 'Article\ArticleController@comment');

//Route::get("/admin/login.html", 'Admin\AdminController@login');
Route::get("/admin/index.html", 'Admin\AdminController@index');
Route::post("/admin/login", 'Admin\AdminController@login');
Route::get("/admin/articlelist.html", 'Admin\AdminController@articlelist');
Route::get("/admin/articleadd.html", 'Admin\AdminController@articleadd');
Route::post("/admin/articleadd.html", 'Admin\AdminController@add_article');


Route::get("/test.html", 'Admin\AdminController@test');


//Route::namespace('HomeController')->group(function ()
//{
//    Route::get('/', 'HomeController@index');
//    Route::get('/article/{id}', 'HomeController@show');
//    Route::get("/test", "HomeController@test");
//});

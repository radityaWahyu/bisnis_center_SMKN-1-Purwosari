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
//
// ─── FRONTEND ROUTE ─────────────────────────────────────────────────────────────
//
Route::post('count','FrontendController@count');
Route::get('review', 'ReviewController@index');
Route::post('review', 'ReviewController@review');

Route::get('item', 'FrontendController@getItem');
Route::get('item/{slug}', 'FrontendController@itemBySlug');
Route::get('post', 'FrontendController@getPost');
Route::get('post/{slug}', 'FrontendController@postBySlug');
Route::get('departement/list', 'DepartementController@list');
Route::get('departement/{departement}', 'DepartementController@show');

Route::get('gallery', 'GalleryController@index');
Route::get('gallery/{id}', 'GalleryController@show');

// --------ADMIN ROUTE ------------------------------------------------------------
Route::prefix('admin')->group(function () {
  Route::post('login', 'UserController@login');
  Route::get('refresh-token', 'UserController@refreshToken');

  Route::middleware(['auth:api'])->group(function(){
  
  
    Route::get('logout', 'UserController@logout');
    //
    // ─── CATEGORY ROUTE ─────────────────────────────────────────────────────────────
    //
    Route::get('category/list', 'CategoryController@listCategory');
    Route::resource('category', 'CategoryController');
    Route::post('category/delete', 'CategoryController@delete');
    
    //
    // ─── DEPARTEMENT ROUTE ──────────────────────────────────────────────────────────
    //
    Route::get('departement/list', 'DepartementController@list');
    Route::resource('departement', 'DepartementController');
    Route::post('departement/delete', 'DepartementController@delete');
    
    //
    // ─── USER ROUTE ──────────────────────────────────────────────────────────
    //
    Route::get('getUser','UserController@getUser');
    Route::resource('user', 'UserController');
    Route::post('user/delete', 'UserController@delete');

    //
    // ─── ITEM ROUTE ──────────────────────────────────────────────────────────
    //
    Route::resource('item', 'ItemController');
    Route::post('item/delete', 'ItemController@delete');
    Route::post('item/is_best/{id}', 'ItemController@setBestItem');

    //
    // ─── POST ROUTE ──────────────────────────────────────────────────────────
    //
    Route::resource('post', 'PostController');
    Route::post('post/delete', 'PostController@delete');
    Route::post('post/publish/{id}', 'PostController@setPublish');
    Route::post('post/upload', 'PostController@uploadImage');

    //
    // ─── REVIEW ROUTE ──────────────────────────────────────────────────────────
    //
    Route::get('review', 'ReviewController@index');
    Route::get('review/latest', 'ReviewController@latest');
    Route::post('review/reply/{id}', 'ReviewController@reply');
    Route::post('review/delete', 'ReviewController@delete');

    //
    // ─── ACTIVITY LOG ROUTE ──────────────────────────────────────────────────────────
    //
    Route::get('activity', 'ActivityLogController@index');
    Route::get('activity/{id}', 'ActivityLogController@show');

    //
    // ─── STATISTIC ──────────────────────────────────────────────────────────
    //
    Route::get('statistic/count', 'statisticController@count');
    Route::get('statistic/chart', 'statisticController@chart');

    //
    // ─── GALLERY  ──────────────────────────────────────────────────────────
    //
    Route::get('gallery', 'GalleryController@index');
    Route::post('gallery', 'GalleryController@store');
    Route::post('gallery/delete', 'GalleryController@delete');
    Route::get('gallery/{id}', 'GalleryController@show');
    
  // end for middleware auth  
  });

});




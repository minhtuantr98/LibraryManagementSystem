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

Auth::routes();



Route::get('/', 'Admin\HomeController@index');

Route::group(['middleware' => 'admin'], function() {

Route::get('/admin/user', 'Admin\UserController@index');

Route::get('/admin/user/{id}/edit', 'Admin\UserController@edit');

Route::put('/admin/user/{id}', 'Admin\UserController@update');

Route::get('/admin/user/create', 'Admin\UserController@create');

Route::post('/admin/user', 'Admin\UserController@store');

Route::delete('/admin/user/{id}', 'Admin\UserController@destroy');

Route::get('/admin/category', 'Admin\CategoryController@index');

Route::get('/admin/category/{id}/edit', 'Admin\CategoryController@edit');

Route::put('/admin/category/{id}', 'Admin\CategoryController@update');

Route::get('/admin/category/create', 'Admin\CategoryController@create');

Route::post('/admin/category', 'Admin\CategoryController@store');

Route::delete('/admin/category/{id}', 'Admin\CategoryController@destroy');

Route::get('/admin/location', 'Admin\LocationController@index');

Route::get('/admin/location/{id}/edit', 'Admin\LocationController@edit');

Route::put('/admin/location/{id}', 'Admin\LocationController@update');

Route::get('/admin/location/create', 'Admin\LocationController@create');

Route::post('/admin/location', 'Admin\LocationController@store');

Route::delete('/admin/location/{id}', 'Admin\LocationController@destroy');

Route::get('/admin/book', 'Admin\BookController@index');

Route::get('/search', 'Admin\BookController@index');

Route::get('/admin/booklisting', 'Admin\BookController@listing');

Route::get('/admin/book/{id}/edit', 'Admin\BookController@edit');

Route::put('/admin/book/{id}', 'Admin\BookController@update');

Route::get('/admin/book/create', 'Admin\BookController@create');

Route::post('/admin/book', 'Admin\BookController@store');

Route::delete('/admin/book/{id}', 'Admin\BookController@destroy');

Route::get('/admin/borrow', 'Admin\BorrowController@index');

Route::get('/admin/borrow/{id}/pay', 'Admin\BorrowController@edit');

Route::get('/admin/borrow/{id}/detail', 'Admin\BorrowController@payDetail');

Route::put('/admin/borrow/{id}', 'Admin\BorrowController@update');

Route::get('/admin/borrow/create', 'Admin\BorrowController@create');

Route::post('/admin/borrow', 'Admin\BorrowController@store');

Route::put('/admin/borrow/{idNote}/{idBook}/pay', 'Admin\BorrowController@payBook');

Route::delete('/admin/borrow/{id}', 'Admin\BorrowController@destroy');

Route::get('/admin/librarycardlisting', 'Admin\BorrowController@cardlisting');

});
// API 
Route::group([
    'prefix' => 'api'
], function () {

    Route::get('book/create', 'ApiController@create');

    Route::get('listbook', 'ApiController@index');

    Route::get('book/{id}', 'ApiController@detail');

    Route::get('book/{id}/edit', 'ApiController@edit');

    Route::put('book/{id}', 'ApiController@update');

    Route::post('book', 'ApiController@store');

    Route::delete('book/{id}', 'ApiController@destroy');

    Route::get('image/{slug}', 'ApiController@getImage');

    Route::post('login', 'ApiController@login');

    Route::post('register', 'ApiController@signup');

    Route::post('logout', 'ApiController@logout');
      
});
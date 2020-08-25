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


Route::post('register', 'Auth\AuthApiController@register');
Route::post('login', 'Auth\AuthApiController@login')->name('login');

Route::get('/authors', 'AuthorsController@index');
Route::get('/authors/{id}', 'AuthorsController@show');

Route:: get('/books', 'BookController@index');
Route::post('/book', 'BookController@store');
Route::get('/user_books', 'BookController@showByUser');
Route::post('/update/{book_id}', 'BookController@update');
Route::delete('/book/{id}', 'BookController@destroy');



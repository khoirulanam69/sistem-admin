<?php

use Illuminate\Support\Facades\Route;

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


Auth::routes(['verify' => true]);

Route::get('/', 'AuthController@login');
Route::post('/', 'AuthController@loginStore');
Route::get('/registration', 'AuthController@registration');
Route::post('/registration', 'AuthController@registrationStore');
Route::get('/forgotpassword', 'AuthController@forgotpassword');
Route::get('/admin', 'AdminController@index')->middleware(['auth', 'verified']);
Route::get('/user', 'UserController@index')->middleware(['auth', 'verified']);
Route::get('/user/edit', 'UserController@edit');
Route::post('/user/edit', 'UserController@update');
Route::get('/menu', 'MenuController@index');
Route::post('/menu', 'MenuController@createmenu');
Route::delete('/menu/{id}', 'MenuController@deletemenu');
Route::get('/menu/submenu', 'MenuController@submenu');
Route::post('/menu/submenu', 'MenuController@createsubmenu');
Route::delete('/menu/submenu/{id}', 'MenuController@deletesubmenu');
Route::get('/blocked', 'AuthController@blocked');
Route::get('/logout', 'AuthController@logout');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

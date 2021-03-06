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
Route::get('/admin/listuser', 'AdminController@listuser');
Route::get('/admin/listuser/download', 'AdminController@downloadpdf');
Route::post('/admin/listuser/download', 'AdminController@exportexcel');
Route::get('/admin/listuser/search', 'AdminController@search');
Route::get('/user', 'UserController@index')->middleware(['auth', 'verified']);
Route::get('/user/edit', 'UserController@edit');
Route::post('/user/edit', 'UserController@update');
Route::get('/menu', 'MenuController@index');
Route::get('/menu/submenu', 'MenuController@submenu');
Route::post('/menu', 'MenuController@createmenu');
Route::get('/menu/{id}', 'MenuController@editmenu');
Route::patch('/menu/{id}', 'MenuController@updatemenu');
Route::delete('/menu/{id}', 'MenuController@deletemenu');
Route::post('/menu/submenu', 'MenuController@createsubmenu');
Route::get('/menu/submenu/{id}', 'MenuController@editsubmenu');
Route::patch('/menu/submenu/{id}', 'MenuController@updatesubmenu');
Route::delete('/menu/submenu/{id}', 'MenuController@deletesubmenu');
Route::get('/settings', 'SettingsController@language');
Route::get('/blocked', 'AuthController@blocked');
Route::get('/logout', 'AuthController@logout');

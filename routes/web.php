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

Route::get('/', function () {
	return view('auth.login');
});

Route::get('/register', function(){
	return view('auth.register');
});
Route::get('/login', function(){
	return view('auth.login');
});

Route::resource('/campus', 'CampusController');
Route::resource('/programas', 'ProgramController');
Route::resource('/facultades', 'FacultyController');
Route::middleware(['auth'])->group(function () {
	Route::resource('/usuarios', 'UserController');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

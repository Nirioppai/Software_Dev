<?php
use App\User;

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
        return redirect('/login');    
});

Route::get('/logout', 'Auth\LoginController@logout')->name('logout' );
Auth::routes();

Route::get('/login', 'CustomRegisterController@login')->name('login' );
Route::get('/register', 'CustomRegisterController@register')->name('register' );
Route::post('/register/submit', 'CustomRegisterController@submit');


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/students', 'HomeController@students')->name('students');
Route::get('/csv', 'HomeController@csv')->name('csv');
Route::get('/monitoring', 'HomeController@monitoring')->name('monitoring');

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
  //check for users
  $users = User::all();

  //if there are users
  if(count ($users) > 0) {
      Auth::logout();
      return redirect('/login');
    }

  //if there are no users
  if(count ($users) == 0) {
      Auth::logout();
      return redirect('/register');
    }

});

Auth::routes();
Route::get('/register', 'CustomRegisterController@index')->name('CustomRegister');
Route::post('/register/submit', 'CustomRegisterController@submit')->name('CustomRegisterSubmit');

Route::get('/home', 'HomeController@index')->name('home');

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Auth;

class CustomRegisterController extends Controller
{
  public function index()
  {
      return view('auth.register');
  }

  public function submit(Request $request){
    //validates input from registration
    $this->validate($request, [
      'name' => ['required', 'string', 'max:30'],
      'username' => ['required', 'string', 'max:25', 'unique:users'],
      'password' => ['required', 'string', 'confirmed', 'max:25', 'min:8'],
    ]);

    //check to prevent additional entries
    $users = User::all();
    if(count ($users) > 0) {
        Auth::logout();
        return redirect('/login');
      }

    //Registers the User
    $UserDB = new User;
    $UserDB->name = $request->input('name');
    $UserDB->username = $request->input('username');
    $UserDB->password =  Hash::make($request->input('password'));
    $UserDB->save();

    //Redirect to Login
    return redirect('/');
    }
}

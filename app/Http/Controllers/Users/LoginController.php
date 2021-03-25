<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\AuthenticatesUsers;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use App\NewUserModel;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
  function showlogin()
  {
   return view('users/login');
  }

  function login(Request $request)
  {
   $this->validate($request, [
    'login_name' => 'required',
    'password'   => 'required'
   ]);
   $password = $request->input('password'); // password is form field
   $hashed   = Hash::make($password);
   
   $user_data = array(
    'login_name'  => $request->get('login_name'),
    'password'    => $request->input('password'),
   );



// dd(Auth::attempt($user_data));
   if(Auth::attempt($user_data))
   {
    return redirect('home')->with('status', 'Done');
    // dd(Auth::attempt($user_data));
   }
   else
   {
    return back()->with('error', 'Wrong Login Details');
   }

  }

  function successlogin()
  {
   return view('successlogin');
  }

  function logout()
  {
   Auth::logout();
   return redirect('/');
  }
}
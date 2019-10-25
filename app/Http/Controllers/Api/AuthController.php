<?php

namespace App\Http\Controllers\Api;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
  public function register(Request $request){
     $ValidatedData = $request->validate([
          'name'=>'required|max:55',
          'email'=>'required|email',
          'password'=>'required|confirmed'
      ]);
      $ValidatedData['password'] = bcrypt($ValidatedData['password']);
      $user = User::create($ValidatedData);
      $accessToken = $user->createToken('authToken')->accessToken;
      return response(['user'=>$user,'access_token'=>$accessToken]);
    }
  
  public function login(Request $request){
    $loginData = $request->validate([
        
        'email'=>'required|email',
        'password'=>'required'
    ]);
    if(!auth()->attempt($loginData)){
return response()->json(['message'=>'Invalid data']);
    }
    $accessToken = auth()->user()->createToken('authToken')->accessToken;
    return response(['user'=>auth()->user(),'access_token'=>$accessToken]);
}
}
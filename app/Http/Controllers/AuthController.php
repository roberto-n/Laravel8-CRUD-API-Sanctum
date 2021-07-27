<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
    $validatedData = $request->validate([
    'name' => 'required|string|max:255',
                       'email' => 'required|string|email|max:255|unique:users',
                       'password' => 'required|string|min:8',
    ]);
    
          $user = User::create([
                  'nome' => $validatedData['nome'],
                       'email' => $validatedData['email'],
                       'senha' => Hash::make($validatedData['senha']),
           ]);
    
    $token = $user->createToken('auth_token')->plainTextToken;
    
    return response()->json([
                  'access_token' => $token,
                       'token_type' => 'Bearer',
    ]);
    }





public function loguin(Request $request)

{

if(!Auth::attempt($request->only('email','passowrd'))){

   return response()->json([
      'message' => 'Invalid logn details'],401);
   }


   $user= User::were('email',$request['email'])->firstORFail();

   $token= $user->Createtoken('auth_token')->plainTextToken;

   return response()->json([
    'acess_token'=> $token,
    'token_type'=> 'Bearer',

   ]);
}


public function me (Request $request)
{
  return $request ->user();
}



}












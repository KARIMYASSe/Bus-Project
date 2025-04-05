<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
class UserController extends Controller
{
    public function signup(Request $request) {
        $request->validate([
            'name'=>'required|string|max:15',
            'email'=>'required|string|email|max:255|unique:users,email',
            'password'=>'required|string|min:8|confirmed',
            'phone'=>'required|string',
            'gender'=>'required|string'
        ]);
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'phone'=>$request->phone,
            'gender'=>$request->gender
        ]);
        return response()->json([
            'message'=>'registered succussfully',
            'user'=>$user,
        ],201);
    }
    public function signin(Request $request){
        $request->validate([
            'email'=>'required|string|email',
            'password'=>'required|string'
        ]);
        if(!Auth::attempt($request->only('email','password')))
        return response()->json([
            'message'=>'invalid email or password',
        ],401);
        $user=user::where('email',$request->email)->first();
        $token=$user->createToken('auth_Token')->plainTextToken;
        return response()->json([
            'message'=>'login succussfully',
            'user'=>$user,
            'token'=>$token,
        ],201);
    }
    
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message'=>'logout succussfully']);
    }
}

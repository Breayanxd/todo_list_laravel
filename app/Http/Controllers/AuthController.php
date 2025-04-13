<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validated = $request->validate([
            "name"=> "required",
            "email"=> "required|email|unique:users",            
            "password"=> "required",
        ]);

        $user = User::create([
            "name"=> $validated["name"],
            "email"=> $validated["email"],
            "password"=> bcrypt($validated["password"]),
        ]);

        return response()->json(['message' => 'User registered successfully', 'data' => $user],201);
    }

    public function login(Request $request) {
        $credential = $request->only('email', 'password');
        if(!Auth::attempt($credential)) {
            return response()->json(['message'=> 'Invalid credential'],201);
        }

        $user = Auth::user();
        $token = $user->createToken('api_token')->plainTextToken;
        return response()->json(['token'=> $token, 'user'=>$user],200);
    }
    
    public function profile(Request $request) {
        return response()->json(auth()->user(),200);
    }

    public function logout(Request $request) {
        $request->user()->tokens('')->delete();
        return response()->json(['message'=> 'Logged out successfully'],200);
    }

}

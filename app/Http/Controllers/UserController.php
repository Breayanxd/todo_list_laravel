<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name"=> "required|string|max:255",
            "password"=> "required|string|max:255",
            "email"=> "required|string|max:255",
        ]);
        $user = User::create([
            "name"=> $validated['name'],
            'email'=> $validated['email'],
            'password'=> bcrypt($validated['password']),

        ]);
        return response()->json($user,200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
            
    }

    public function showUser(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if(!$user){
            return response()->json(['message'=> 'User not found'],404);
        }

        $user->delete();
        return response()->json(['message'=> 'User deleted successfully'],200);
    }
}

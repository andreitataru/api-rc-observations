<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // User registration
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'tipoConta' => 'required|string'
        ]);

        $user = Auth::user();
        if ($user->tipoConta != "Admin")
            return response()->json(['message' => 'Only Admin can create accounts!'], 409);
        try {

            $user = new User([
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'tipoConta' => $request->tipoConta
            ]);

            if ($user->tipoConta == "Professor" || $user->tipoConta == "Tecnico"){
                $user->save();
    
                // Generating a token for the registered user
                $token = $user->createToken('authToken')->plainTextToken;
        
                return response()->json([
                    'user' => $user,
                    'token' => $token,
                ], 201);
            }
            else{
                return response()->json(['message' => 'Account type invalid'], 409);
            }
    
        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'User Registration Failed!'], 409);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate the user
        if (!Auth::attempt($request->only('username', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        // Generate a new token for the user
        $token = $request->user()->createToken('authToken')->plainTextToken;

        return response()->json([
            'token' => $token
        ], 200);
    }
}

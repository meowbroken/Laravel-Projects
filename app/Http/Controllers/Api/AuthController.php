<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{
  
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();

        if (!$user->token_expiry || Carbon::now()->greaterThan($user->token_expiry)) {
            $user->tokens()->delete(); 
            $token = $user->createToken('libretto-token')->plainTextToken;
            $user->update(['token_expiry' => Carbon::now()->addDay()]);
        } else {
            $token = $user->tokens->first()->plainTextToken;
        }

        return response()->json([
            'token' => $token,
            'token_expiry' => $user->token_expiry,
        ]);
    }

    // Registration method
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('libretto-token')->plainTextToken;

        $user->update(['token_expiry' => Carbon::now()->addDay()]);

        return response()->json([
            'message' => 'User registered successfully',
            'token' => $token,
            'token_expiry' => $user->token_expiry,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }
}
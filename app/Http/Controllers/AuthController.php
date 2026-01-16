<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:3|confirmed',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required',
            'remember' => 'nullable|boolean',
        ]);

        $remember = $request->boolean('remember') ?? false;

        if (Auth::attempt($request->only('name', 'password'), $remember)) {
            $request->session()->regenerate();
            return response()->json([
                'message' => 'Logged in successfully'
            ]);
        }

        return response()->json([
            'message' => 'Wrong password.',
        ], 401);
    }
}

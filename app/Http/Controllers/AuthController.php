<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __invoke(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (auth()->attempt($credentials) && auth()->user()->role === 'admin') {
            return response()->json(['token' => auth()->user()->createToken('token')->plainTextToken]);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}

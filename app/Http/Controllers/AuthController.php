<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (auth()->attempt($credentials) && auth()->user()->role === 'admin') {
            return response()->json(['token' => auth()->user()->createToken('token')->plainTextToken]);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        if(!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid Password'
            ], 401);
        }

        $api_token = $user->createToken("app_mobile")->plainTextToken;

        return response()->json([
            'api_token' => $api_token
        ]);

    }


    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

    }
}

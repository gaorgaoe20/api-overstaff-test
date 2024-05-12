<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            "email"=> ["required", "unique:users,email"],
            "name" => ["required"],
            "password" => ["required"]
        ]);

        $data = $request->only("email","name");

        $data['password'] = bcrypt($request->password);

        $user = User::create($data);

        $api_token = $user->createToken("app_mobile")->plainTextToken;

        return response()->json([
            'api_token' => $api_token
        ]);

    }
}

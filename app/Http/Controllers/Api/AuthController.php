<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(Request $request)
    {

        $user = User::query()
            ->where('email', $request->input("email"))
            ->first();

        if($user == null) {
            return response()->json([
                "status" => false,
                "message" => "Credentials is incorrect",
            ]);
        }

        if(!Hash::check($request->input("password"), $user->password)) {
            return response()->json([
                "status" => false,
                "message" => "Password is incorrect",
                "data" => null
            ]);
        }

        $token = $user->createToken("auth_token");

        return response()->json([
            "status" => true,
            "message" => "Successfully login",
            "data" => [
                "auth" => [
                    "token" => $token->plainTextToken,
                    "token_type" => "Bearer"
                ],
                "user" => $user
            ]
        ]);

    }

    public function getUser(Request $request)
    {

        $user = $request->user();
        return response()->json([
            "status" => true,
            "message" => "Successfully retrieved user",
            "data" => $user
        ]);

    }

}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function auth(Request $request)
    {
        // return 'hello world';
        $email = $request->email;
        $password = $request->password;
        //validate email and password
        $validator = validator($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'statusCode' => 400,
                'statusMessage' => 'BAD_REQUEST',
                'message' => $validator->errors(),
                'success' => false,
            ], 400);
        }

        //check user
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json([
                'statusCode' => 404,
                'statusMessage' => 'NOT_FOUND',
                'message' => 'User not found',
                'success' => false,
            ], 404);
        }
        // check password
        if (!Hash::check($password, $user->password)) {
            return response()->json([
                'statusCode' => 400,
                'statusMessage' => 'BAD_REQUEST',
                'message' => 'Password is wrong',
                'success' => false,
            ], 400);
        }
        // generate jwt token
        $customClaims = [
            'email' => $user->email,
            'exp' => now()->addDay()->timestamp, // Expires in 1 day
        ];
        $token = JWTAuth::claims($customClaims)->fromUser($user);
        if (!$token) {
            return response()->json([
                'statusCode' => 401,
                'statusMessage' => 'UNAUTHORIZED',
                'message' => 'Unauthorized',
                'success' => false,
            ], 401);
        }
        return response()->json([
            'statusCode' => 200,
            'statusMessage' => 'OK',
            'message' => 'Login success',
            'success' => true,
            'data' => [
                'user' => $user,
                'token' => $token,
            ]
        ], 200);
    }
}

<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use function PHPUnit\Framework\isEmpty;

class AuthController extends Controller
{
    function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        try {
            $users = User::all();
            $image = 'defaultProfile.png';

            if (count($users) === 0){
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'is_admin' => true,
                    'image' => $image
                ]);
            } else {
                return response()->json(['error' => 'Unauthorized'], 409);
            }

            return response()->json(['message' => 'User registered successfully', 'data' => $user], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        try {
            $user = Auth::user();
            $token = JWTAuth::attempt($validator->validated());

            return response()->json([
                'message' => 'User logged in successfully',
                'data' => $user,
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60 . ' minutes'
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    function logout(){
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'User logged out successfully'], 200);
    }

    function refresh(){
        $user = Auth::user();

        if ($user->is_admin === true) {
            return response()->json([
                'message' => 'User logged in successfully',
                'data' => $user,
                'access_token' => JWTAuth::refresh(),
                'token_type' => 'bearer',
                'expires_in' =>JWTAuth::factory()->getTTL() * 60 . ' minutes'
            ], 200);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    function userProfile(){
        $user = Auth::user();

        if (!$user){
            return response()->json(['error' => 'User not found'], 401);
        }

        return response()->json(['data' => $user], 200);
    }

}

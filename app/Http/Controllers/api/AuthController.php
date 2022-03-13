<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\LoginRequest;
use App\Http\Requests\api\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(LoginRequest $request)
    {
        try {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                $token = $user->createToken('passport-token');

                return response()->json([
                    'message' => 'Successfully logged in',
                    'token' => $token->accessToken,
                    'user' => $user
                ]);
            } 

            return response()->json(['error' => 'Invalid email or password, Please check your credentials']);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ]);
        }
       
    }


    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'type' => $request->type
            ]);

            $token = $user->createToken('passport-token');
            return response()->json([
                'message' => 'Successfully registered',
                'token' => $token->accessToken,
                'user' => $user
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ]);
        }
    }
}

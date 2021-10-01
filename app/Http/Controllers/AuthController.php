<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $user = User::query()->create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'role_id' => 2
            ]);

            $token = $user->createToken("Sherifs'SecretKey")->plainTextToken;

            return response()->json([
                'user_id' => $user->id,
                'success' => true,
                'token' => $token
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'success' => false,
                'token' => null,
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $user = User::query()->where([
                'email' => $request->input('email')
            ])->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'data'=> null,
                    'message' => 'User doesnt found'
                ]);
            }

            $hashedPw = Hash::check($request->input('password'), $user->password);

            if (!$hashedPw) {
                return response()->json([
                    'success' => false,
                    'data' => null,
                    'message' => 'Passwords doesnt match'
                ]);
            }

            $token = $user->createToken("Sherif'sSecretKey")->plainTextToken;

            return response()->json([
                'data' => $user,
                'success' => true,
                'token' => $token
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'data' => null,
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function logout(): JsonResponse
    {
        try {
            Auth::user()->tokens()->delete();
            return response()->json([
                'success' => true,
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }
}

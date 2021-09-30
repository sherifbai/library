<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
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
}

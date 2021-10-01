<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $role_user = Role::query()->where([
                'name' => 'user'
            ])->first();

            $user = User::query()->create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'role_id' => $role_user->id
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


    /**
     * Display a listing of the resource.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
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

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
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

    /**
     * Display a listing of the resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function makeLibrarian(int $id): JsonResponse
    {
        try {
            $role = Role::query()->where([
                'name' => 'librarian'
            ])->first();
            $user = User::findOrFail($id);

            $user->role_id = $role->id;
            $user->save();

            return response()->json([
                'data' => $user,
                'success' => true,
                'librarian' => $user->name
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'data' => null,
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }
}

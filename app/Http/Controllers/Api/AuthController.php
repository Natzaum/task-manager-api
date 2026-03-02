<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;

class AuthController extends Controller
{
    public function register(UserRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $data = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'User successfully registered',
                'user' => $data,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to register user'
            ], 400);
        }
    }

    public function login(Request $request): JsonResponse
    {
        if(Auth::attempt([
            'email' => $request->email, 'password' => $request->password
        ])) {
            $user = Auth::user();

            $token = $request->user()->createToken('api-token')->plainTextToken;

            return response()->json([
                'status' => true,
                'token' => $token,
                'message' => 'Login successfully',
                'user' => $user,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Incorrect credentials'
            ], 401);
        }
    }

    public function logout(Request $request): JsonResponse
    {   
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'status' => true,
                'message' => 'Logout successfully'
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Cannot logout'
            ], 400);
        }
    }
    
    public function authUser(): JsonResponse 
    {
        $user = Auth::user();

        return response()->json([
            'status' => true,
            'user' => $user,
        ]);
    }
}

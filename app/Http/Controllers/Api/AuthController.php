<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;

class AuthController extends Controller
{
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
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Incorrect credentials'
            ], 404);
        }
    }

    public function logout(User $user): JsonResponse
    {   
        try {
            $user->tokens()->delete();

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
}

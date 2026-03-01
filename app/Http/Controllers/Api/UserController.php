<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::orderBy('id', 'DESC')->paginate(10);

        return response()->json([
            'status' => true,
            'user' => $users,
        ], 200);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json([
            'status' => true,
            'user' => $user,
        ], 200);
    }

    public function store(UserRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'role' => 'user',
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'User successfully registered',
                'user' => $user,
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Failed to register user',
            ], 400);
        }
    }

    public function update(UserRequest $request, User $user): JsonResponse
    {
        DB::beginTransaction();

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);
        
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'User edited successfully',
                'user' => $user,
            ], 200);

        } catch(Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Failed to edit user',
            ], 400);
        }
    }

    public function destroy(User $user): JsonResponse
    {
        try {
            $user->delete();

            return response()->json([
                'status' => true,
                'message' => 'User deleted successfully',
                'user' => $user,
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete user',
            ], 400);
        }
    }
}

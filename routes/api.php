<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

# Public routes
Route::post('/users', [UserController::class, 'store']); # http://127.0.0.1:8000/api/users
Route::post('/login', [AuthController::class, 'login']); # http://127.0.0.1:8000/api/login

# Restricted routes
Route::group(['middleware' => ['auth:sanctum']], function(){
    # Users
    Route::get('/user', [AuthController::class, 'authUser']);
    Route::get('/users', [UserController::class, 'index']); # http://127.0.0.1:8000/api/users?page={page}
    Route::get('/users/{user}', [UserController::class, 'show']); # http://127.0.0.1:8000/api/users/{id}
    Route::put('/users/{user}', [UserController::class, 'update']); # http://127.0.0.1:8000/api/users/{id}
    Route::delete('/users/{user}', [UserController::class, 'destroy']); # http://127.0.0.1:8000/api/users/{id}

    Route::post('/logout', [AuthController::class, 'logout']); # http://127.0.0.1:8000/api/logout/{id}
});
<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{

    function register(RegisterUserRequest $request): JsonResponse
    {
        try {
            $user = User::query()->create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'phone_number' => $request->input('phone_number'),
                'active' => false,
            ]);
            return $this->success('User created successfully', $user);

        } catch (Exception $e) {
            return $this->error($e->getMessage(), $request->all());
        }
    }

    function login(LoginRequest $request): JsonResponse
    {
        try {
            $user = User::query()->where('email', $request->input('email'))->first();

            if (!$user || !Hash::check($request->input('password'), $user->password)) {
                return $this->error('invalid credentials');
            }

            $user->activeUser();
            $user->addToken();

            return $this->success('User logged in successfully', $user);

        } catch (Exception $e) {
            return $this->error('', $e->getMessage());
        }
    }

    function logout(Request $request): JsonResponse
    {
        try {
            $request->user()->tokens()->delete();
            return $this->success('User logged out successfully');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

}

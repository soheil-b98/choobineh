<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserController extends Controller
{

    function register(RegisterUserRequest $request): JsonResponse
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone_number' => $request->phone_number,
                'active' => false,
            ]);
            return $this->success('User created successfully', $user, 200);

        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $request->all(), 400);
        }
    }

    function login(LoginRequest $request): JsonResponse
    {
        try {
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return $this->error('invalid credentials', [], 400);
            }

            $user->activeUser();
            $user->addToken();

            return $this->success('User logged in successfully', $user, 200);

        } catch (\Exception $e) {
            return $this->error('', $e->getMessage(), 400);
        }
    }

}

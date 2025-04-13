<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    function register(RegisterUserRequest $request): JsonResponse
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->pasword),
                'phone_number' => $request->phone_number,
                'active' => false,
                'role' => 'marketer',
            ]);
            return $this->success('User created successfully', $user, 200);

        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $request->all(), 400);
        }
    }

}

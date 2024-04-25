<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Roles;
use Throwable;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        try {
            $user = User::create($request->validated());
            $user->assignRole(Roles::Viewer);

            return response()->json([
                'message' => __('The registration is successful.'),
                'data' => [
                    'access_token' => $user->createToken('authToken')->plainTextToken,
                    'token_type' => 'Bearer Token',
                ]
            ], 201);
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'message' => __('Failed to register the user! Please try again.'),
            ], 400);
        }
    }
}

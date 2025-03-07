<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $payload = $request->validated();
            $user = $this->authService->register($payload);

            return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $payload = $request->validated();
            $data = $this->authService->login($payload);

            return response()->json($data, 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function user(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            return response()->json($user);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $this->authService->logout($user);

            return response()->json(['message' => 'Logged out successfully']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}

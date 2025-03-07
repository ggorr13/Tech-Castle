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
            // As you always return JSON I could suggest to use Adaptor design pattern so your responses always have same structure
            // Also I could suggest to use Resources for Models to sent as a response
            // Would be better to use translations for messages
            return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
        } catch (Exception $e) {
            // Customized exceptions could be used as we don't want customers to see for example
            // {
            //    "error": "Database file at path [/home/dev/projects/test-task/gor_tamazyan/database/database.sqlite] does not exist. Ensure this is an absolute path to the database. (Connection: sqlite, SQL: select * from \"users\" where \"email\" = admin@gmail.com limit 1)"
            // }
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

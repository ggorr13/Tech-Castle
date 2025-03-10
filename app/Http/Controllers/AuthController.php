<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use App\Adapters\ResponseAdapter;
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

            return ResponseAdapter::success($user, __('messages.user_registered'), 201);
        } catch (Exception $e) {
            return ResponseAdapter::error($e->getMessage());
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $payload = $request->validated();
            $data = $this->authService->login($payload);

            return ResponseAdapter::success($data);
        } catch (Exception $e) {
            return ResponseAdapter::error($e->getMessage());
        }
    }

    public function user(Request $request): JsonResponse
    {
        try {
            return ResponseAdapter::success($request->user());
        } catch (Exception $e) {
            return ResponseAdapter::error($e->getMessage());
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            if (!$request->user()) {
                return ResponseAdapter::error(__('messages.unauthorized'), 401);
            }

            $this->authService->logout($request->user());

            return ResponseAdapter::success(null, __('messages.logged_out'));
        } catch (Exception $e) {
            return ResponseAdapter::error($e->getMessage());
        }
    }
}

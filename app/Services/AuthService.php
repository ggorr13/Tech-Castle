<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function __construct(
        private AuthRepositoryInterface $authRepository,
        private UserService $userService
    )
    {
    }

    public function register(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        $user = $this->userService->create($data);
        $user->assignRole('user');

        return $user;
    }

    /**
     * @throws ValidationException
     */
    public function login(array $credentials): array
    {
        $user = $this->userService->findByEmail($credentials['email']);

        if (empty($user) || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $this->authRepository->createToken($user);

        return ['token' => $token, 'user' => $user];
    }

    public function logout(): bool
    {
        $user = Auth::user();
        return $this->authRepository->logout($user);
    }
}

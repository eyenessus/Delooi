<?php

namespace App\Services;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct(
        private readonly UserRepositoryInterface $users,
    ) {}

    public function authenticate(array $credentials): bool
    {
        return Auth::attempt($credentials);
    }

    public function register(array $attributes): User
    {
        $attributes['password'] = Hash::make($attributes['password']);

        $user = $this->users->create($attributes);

        Auth::login($user);

        return $user;
    }
}

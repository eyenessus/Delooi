<?php

namespace App\Services;

use App\Contracts\UserRepositoryInterface;
use App\DTO\LoginData;
use App\DTO\RegisterUserData;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService{
    public function __construct(private readonly UserRepositoryInterface $users) {}

    public function authenticate(LoginData $data): bool
    {
        return Auth::attempt([
            'email' => $data->email,
            'password' => $data->password,
        ]);
    }

    public function register(RegisterUserData $data): User
    {
        $data = new RegisterUserData(
            name: $data->name,
            email: $data->email,
            password: Hash::make($data->password)
        );
        $user = $this->users->create($data);
        Auth::login($user);

        return $user;
    }
}

<?php

namespace App\Repositories;

use App\Contracts\UserRepositoryInterface;
use App\DTO\RegisterUserData;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(private readonly User $model) {}

    public function create(RegisterUserData $data): User
    {
        return $this->model->create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => $data->password,
        ]);
    }
}

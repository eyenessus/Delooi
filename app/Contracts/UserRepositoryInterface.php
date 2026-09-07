<?php

namespace App\Contracts;

use App\DTO\RegisterUserData;
use App\Models\User;

interface UserRepositoryInterface
{
    public function create(RegisterUserData $data): User;
}

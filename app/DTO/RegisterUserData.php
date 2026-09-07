<?php

namespace App\DTO;

class RegisterUserData
{
    public function __construct(public string $name, public string $email, public string $password) {}
}

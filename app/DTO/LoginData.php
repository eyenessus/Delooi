<?php

namespace App\DTO;

class LoginData
{
    public function __construct(public string $email, public string $password) {}
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService) {}

    public function login(LoginRequest $request)
    {
        if ($this->authService->authenticate($request->validated())) {
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'E-mail ou senha inválidos.',
        ]);
    }

    public function signup(RegisterRequest $request)
    {
        $this->authService->register($request->validated());

        return redirect()->intended('/dashboard');
    }
}

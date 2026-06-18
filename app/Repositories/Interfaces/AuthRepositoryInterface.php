<?php

namespace App\Repositories\Interfaces;

interface AuthRepositoryInterface
{
    public function register(array $data);

    public function login(array $credentials);

    public function logout();

    public function me();

    public function forgotPassword(string $email);

    public function resetPassword(array $data);
}
<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Repositories\Interfaces\AuthRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface
{
    public function register(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'] ?? 'candidate'
        ]);

        $token = auth()->login($user);

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function login(array $credentials)
    {
        if (!$token = auth()->attempt($credentials)) {
            return null;
        }

        return [
            'user' => auth()->user(),
            'token' => $token
        ];
    }

    public function logout()
    {
        auth()->logout();

        return true;
    }

    public function me()
    {
        return auth()->user();
    }

    public function forgotPassword(string $email)
    {
        return Password::sendResetLink([
            'email' => $email
        ]);
    }

    public function resetPassword(array $data)
    {
        return Password::reset(
            $data,
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );
    }
}
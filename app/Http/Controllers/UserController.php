<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    private $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $data['password'] = bcrypt($data['password']);

        $user = $this->userRepo->createUser($data);

        return response()->json([
            'status' => true,
            'message' => 'User created successfully',
            'data' => $user
        ]);
    }
}
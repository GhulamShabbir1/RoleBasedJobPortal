<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function getAllUsers()
    {
        return $this->model->all();
    }

    public function getCandidates()
    {
        return $this->model->where('role', 'candidate')->get();
    }

    public function getEmployers()
    {
        return $this->model->where('role', 'employer')->get();
    }

    public function getAdmins()
    {
        return $this->model->where('role', 'admin')->get();
    }

    public function getUserById($id)
    {
        return $this->model->find($id);
    }

    public function getUserByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function createUser(array $data)
    {
        return $this->model->create($data);
    }

    public function updateUser($id, array $data)
    {
        $user = $this->model->find($id);

        if (!$user) {
            return null;
        }

        $user->update($data);
        return $user;
    }

    public function deleteUser($id)
    {
        $user = $this->model->find($id);

        if (!$user) {
            return false;
        }

        return $user->delete();
    }

    public function updatePassword($id, $password)
    {
        $user = $this->model->find($id);

        if (!$user) {
            return null;
        }

        $user->update([
            'password' => bcrypt($password)
        ]);

        return $user;
    }


    public function updateRole($id, $role)
    {
        $user = $this->model->find($id);

        if (!$user) {
            return null;
        }

        $user->update([
            'role' => $role
        ]);

        return $user;
    }

    public function updateStatus($id, $status)
    {
        $user = $this->model->find($id);

        if (!$user) {
            return null;
        }

        $user->update([
            'status' => $status
        ]);

        return $user;
    }
}
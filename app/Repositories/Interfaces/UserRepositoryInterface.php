<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function getAllUsers();

    public function getCandidates();

    public function getEmployers();

    public function getAdmins();

    public function getUserById($id);

    public function getUserByEmail($email);

    public function createUser(array $data);

    public function updateUser($id, array $data);

    public function deleteUser($id);

    public function updatePassword($id, $password);

    public function updateRole($id, $role);

    public function updateStatus($id, $status);
}
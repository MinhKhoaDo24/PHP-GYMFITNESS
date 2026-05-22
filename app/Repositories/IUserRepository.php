<?php

namespace App\Repositories;

interface IUserRepository
{
    public function all();

    public function find($id);

    public function create($data);

    public function updateUser($id, $data);

    public function delete($id);

    public function restore($id);
}

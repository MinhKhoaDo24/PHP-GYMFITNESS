<?php

namespace App\Repositories;

interface IKhuyenmaiRepository
{
    public function all($status = null);
    public function find($id);
    public function store($data);
    public function update($id, $data);
    public function softDelete($id);
    public function restore($id);
}

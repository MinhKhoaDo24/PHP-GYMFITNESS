<?php

namespace App\Repositories;

use App\Models\NguoiDung;
use App\Models\PhanQuyen;

class UserRepository implements IUserRepository
{
    public function all()
    {
        return NguoiDung::with('phanquyen')->get();
    }

    public function find($id)
    {
        return NguoiDung::findOrFail($id);
    }

    public function create($data)
    {
        $data['password'] = bcrypt($data['password']);
        return NguoiDung::create($data);
    }

    public function updateUser($id, $data)
    {
        $user = NguoiDung::findOrFail($id);

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        return $user->update($data);
    }

    public function delete($id)
    {

        return NguoiDung::where('id_nd', $id)->update([
            'trang_thai' => 0
        ]);
    }

    public function restore($id)
    {
        return NguoiDung::where('id_nd', $id)->update([
            'trang_thai' => 1
        ]);
    }

}

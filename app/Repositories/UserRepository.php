<?php

namespace App\Repositories;

use App\Models\Nguoidung;
use App\Models\Phanquyen;

class UserRepository implements IUserRepository
{
    public function all()
    {
        return Nguoidung::with('phanquyen')->get();
    }

    public function find($id)
    {
        return Nguoidung::findOrFail($id);
    }

    public function create($data)
    {
        $data['password'] = bcrypt($data['password']);
        return Nguoidung::create($data);
    }

    public function updateUser($id, $data)
    {
        $user = Nguoidung::findOrFail($id);

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        return $user->update($data);
    }

    public function delete($id)
    {

        return Nguoidung::where('id_nd', $id)->update([
            'trang_thai' => 0
        ]);
    }

    public function restore($id)
    {
        return Nguoidung::where('id_nd', $id)->update([
            'trang_thai' => 1
        ]);
    }

}

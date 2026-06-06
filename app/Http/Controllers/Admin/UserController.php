<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Danhmuc;
use App\Models\PhanQuyen;
use App\Models\NguoiDung;
use App\Http\Controllers\Controller;
use App\Repositories\IUserRepository;
use App\Mail\TaiKhoanNhanVienMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    private $repo;
    public function __construct(IUserRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
{
    // Khởi tạo query
    $query = NguoiDung::with('phanquyen');

    // Tìm kiếm
    if ($request->q) {
        $query->where(function ($q) use ($request) {
            $q->where('hoten', 'like', '%' . $request->q . '%')
              ->orWhere('email', 'like', '%' . $request->q . '%')
              ->orWhere('sdt', 'like', '%' . $request->q . '%');
        });
    }

    // Lọc theo quyền
    if ($request->role) {
        $query->where('id_phanquyen', $request->role);
    }

    // Lọc theo trạng thái
    if ($request->status !== null && $request->status !== '') {
        $query->where('trang_thai', $request->status);
    }

    // Lấy danh sách users sau khi lọc
    $users = $query->get();

    // Tính thống kê (dựa trên tất cả user, không theo lọc)
    $allUsers = NguoiDung::all();

    $stats = [
        'total'    => $allUsers->count(),
        'active'   => $allUsers->where('trang_thai', 1)->count(),
        'inactive' => $allUsers->where('trang_thai', 0)->count(),
    ];

    return view('admin.users.index', compact('users', 'stats'));
}



    public function create()
    {
        $roles = PhanQuyen::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hoten'        => 'required|string|max:255',
            'email'        => 'required|email|unique:nguoidung,email',
            'sdt'          => 'nullable|numeric',
            'id_phanquyen' => 'required',
        ]);

        // Tự động tạo mật khẩu ngẫu nhiên 12 ký tự
        $matKhauGoc = Str::password(12, true, true, false); // chữ hoa + chữ thường + số

        $data = $request->all();
        $data['password'] = $matKhauGoc; // Repository sẽ bcrypt trước khi lưu

        $user = $this->repo->create($data);

        // Gửi email thông tin đăng nhập cho nhân viên/PT mới
        try {
            Mail::to($user->email)->send(
                new TaiKhoanNhanVienMail($user->hoten, $user->email, $matKhauGoc)
            );
        } catch (\Exception $e) {
            // Ghi log nếu email thất bại nhưng vẫn tiếp tục
        }

        return redirect()->route('users.index')
            ->with('success', 'Tạo tài khoản thành công! Mật khẩu đã được gửi đến email ' . $user->email . '.');
    }

    public function edit($id)
    {
        $user = $this->repo->find($id);
        $roles = PhanQuyen::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'hoten' => 'required',
            'email' => 'required|email|unique:nguoidung,email,' . $id . ',id_nd',
            'sdt'   => 'nullable|numeric',
        ]);

        $this->repo->updateUser($id, $request->all());

        return redirect()->route('users.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        $this->repo->delete($id);
        return redirect()->route('users.index')->with('success', 'Vô hiệu hóa người dùng thành công!');
    }

    public function restore($id)
    {
        $this->repo->restore($id);
        return redirect()->route('users.index')->with('success', 'Khôi phục người dùng thành công!');
    }


    
}

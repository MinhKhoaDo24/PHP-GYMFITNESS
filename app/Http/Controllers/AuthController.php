<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NguoiDung;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('pages.login');
    }
    public function register()
    {
        return view('pages.register');
    }
    public function registerPost(Request $request)
    {
        $kh = new NguoiDung();
        $kh->hoten = $request->name;
        $kh->email = $request->email;
        $kh->password = Hash::make($request->password);
        $kh->diachi = $request->address;
        $kh->sdt = $request->phone;
        $kh->id_phanquyen = 2;
        $kh->save();
        //Tự động đăng nhập
        Auth::login($kh);
        
        return redirect('/')->with('thongbao', 'Chào mừng! Bạn đã đăng nhập.');
    }

    public function loginPost(Request $request)
    {
        // Lấy user theo email
        $user = NguoiDung::where('email', $request->email)->first();

        // Nếu không có user hoặc trạng thái = 0 -> báo lỗi
        if ($user->trang_thai == 0) {
            return back()->with('error', 'Tài khoản đang bị khóa!');
        }

        // Kiểm tra đăng nhập
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            return redirect('/')->with('thongbao', 'Đăng nhập thành công');
        }

        return back()->with('error', 'Sai tên đăng nhập hoặc mật khẩu!');
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
    public function kiemTraEmail(Request $request)
    {
        $exists = NguoiDung::where('email', $request->email)->exists();
        return response()->json(['exists' => $exists]);
    }
}

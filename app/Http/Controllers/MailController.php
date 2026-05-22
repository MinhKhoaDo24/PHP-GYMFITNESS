<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        Mail::raw("Cảm ơn bạn đã đăng ký nhận thông tin từ Gym Fitness!", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject("Xác nhận đăng ký Gym Fitness");
        });

        return back()->with('thongbao', 'Đăng ký nhận tin thành công!');
    }
}

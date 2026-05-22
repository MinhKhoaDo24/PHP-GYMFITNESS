<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Repositories\IOrderRepository;
use Illuminate\Http\Request;
use App\Models\Dathang;
use App\Models\ChitietDonhang;

class OrderController extends Controller
{
    protected $orders;

    public function __construct(IOrderRepository $orders)
    {
        $this->orders = $orders;
    }

    // ================= 3 TRANG QUẢN LÝ =================

    // 1. Đơn chờ xác nhận
    public function pending(Request $request)
    {
        $query = Dathang::query();

        // Chỉ lấy 2 trạng thái chính cho màn pending
        $query->whereIn('trangthai', ['Chờ xác nhận', 'Hủy']);

        // ===================== SEARCH =====================
        if ($request->search) {
            $keyword = $request->search;

            $query->where(function ($q) use ($keyword) {
                $q->where('hoten', 'like', "%$keyword%")
                ->orWhere('sdt', 'like', "%$keyword%")
                ->orWhere('id_dathang', 'like', "%$keyword%");
            });
        }

        // ===================== FILTER STATUS =====================
        if ($request->status) {
            $query->where('trangthai', $request->status);
        }

        // ===================== PAGINATION =====================
        $orders = $query->orderBy('ngaydathang', 'DESC')
                        ->paginate(10)
                        ->appends($request->query());  // GIỮ SEARCH + FILTER


        // ===================== THỐNG KÊ =====================
        $stats = [
            'pending'  => Dathang::where('trangthai', 'Chờ xác nhận')->count(),
            'canceled' => Dathang::where('trangthai', 'Hủy')->count(),
            'total'    => Dathang::whereIn('trangthai', ['Chờ xác nhận', 'Hủy'])->count(),
        ];

        return view('admin.orders.pending', compact('orders', 'stats'));
    }


    // 2. Đơn đang giao (chờ giao + đang giao)
    // 2. Đơn đang giao
    public function shipping(Request $request)
    {
        $query = Dathang::query();

        // Mặc định: chỉ lấy 2 trạng thái này
        $query->whereIn('trangthai', ['Chờ giao hàng', 'Đang giao hàng']);

        // SEARCH
        if ($request->search) {
            $keyword = $request->search;

            $query->where(function ($q) use ($keyword) {
                $q->where('hoten', 'like', "%$keyword%")
                ->orWhere('sodienthoai', 'like', "%$keyword%")
                ->orWhere('id_dathang', 'like', "%$keyword%");
            });
        }

        // FILTER STATUS
        if ($request->status) {
            $query->where('trangthai', $request->status);
        }

        // Lấy danh sách đơn
        $orders = $query->orderBy('ngaydathang', 'DESC')
                        ->paginate(10)
                        ->appends($request->query());

        // Thống kê
        $stats = [
            'waiting'  => Dathang::where('trangthai', 'Chờ giao hàng')->count(),
            'shipping' => Dathang::where('trangthai', 'Đang giao hàng')->count(),
            'total'    => Dathang::whereIn('trangthai', ['Chờ giao hàng', 'Đang giao hàng'])->count(),
        ];

        return view('admin.orders.shipping', compact('orders', 'stats'));
    }


    // 3. Đơn đã hoàn thành hoặc thất bại
    public function done(Request $request)
    {
        $query = Dathang::query();

        // Lấy 2 trạng thái: Hoàn thành – Thất bại
        $query->whereIn('trangthai', ['Hoàn thành', 'Thất bại']);

        // SEARCH
        if ($request->search) {
            $keyword = $request->search;

            $query->where(function ($q) use ($keyword) {
                $q->where('hoten', 'like', "%$keyword%")
                ->orWhere('sodienthoai', 'like', "%$keyword%")
                ->orWhere('id_dathang', 'like', "%$keyword%");
            });
        }

        // FILTER STATUS
        if ($request->status) {
            $query->where('trangthai', $request->status);
        }

        // Pagination
        $orders = $query->orderBy('ngaydathang', 'DESC')
                        ->paginate(10)
                        ->appends($request->query());

        // Stats
        $stats = [
            'done'     => Dathang::where('trangthai', 'Hoàn thành')->count(),
            'failed'   => Dathang::where('trangthai', 'Thất bại')->count(),
            'total'    => Dathang::whereIn('trangthai', ['Hoàn thành', 'Thất bại'])->count(),
        ];

        return view('admin.orders.done', compact('orders', 'stats'));
    }


    // ================= SỬA / CẬP NHẬT =================

    public function edit($id)
{
    $order = Dathang::findOrFail($id);
    $items = ChitietDonhang::where('id_dathang', $id)->get();

    return view('admin.orders.edit', compact('order', 'items'));
}

public function update(Request $request, $id)
{
    $order = Dathang::findOrFail($id);

    // 1. VALIDATE – bắt buộc phải có PTTT
    $data = $request->validate([
        'sdt'                 => 'required|string|max:20',
        'diachigiaohang'      => 'required|string',
        'phuongthucthanhtoan' => 'required|string', 
        'trangthai'           => 'required|string',
        'ngaygiaohang'        => 'nullable|date',
    ]);

    // 2. GÁN DỮ LIỆU
    $order->sdt            = $data['sdt'];
    $order->diachigiaohang = $data['diachigiaohang'];

    // nếu vì lý do gì đó key không có thì giữ giá trị cũ, không cho null
    if (isset($data['phuongthucthanhtoan'])) {
        $order->phuongthucthanhtoan = $data['phuongthucthanhtoan'];
    }

    $order->trangthai    = $data['trangthai'];
    $order->ngaygiaohang = $data['ngaygiaohang'] ?? null;

    $order->save();
    if ($request->has('redirect')) {
        return redirect($request->redirect)
               ->with('success', 'Cập nhật đơn hàng thành công!');
    }

    // fallback nếu thiếu
    return redirect()->route('orders.pending')
           ->with('success', 'Cập nhật đơn hàng thành công!');
}

public function show($id)
{
    $order = Dathang::findOrFail($id);
    $items = ChitietDonhang::where('id_dathang', $id)->get();

    return view('admin.orders.show', compact('order', 'items'));
}




}

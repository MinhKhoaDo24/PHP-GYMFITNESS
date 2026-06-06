<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Repositories\IAdminRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB; 

use Carbon\Carbon;

class AdminController extends Controller
{

    private $AdminRepository;

    public function __construct(IAdminRepository $AdminRepository) {
        $this->AdminRepository = $AdminRepository;
    }

    public function index(){
        return view('admin_login');
    }
    

    public function dashboard(Request $request)
{
    $range = $request->input('range', 'month');
    $stats = $this->AdminRepository->getDashboardData($range);



    return view('admin.dashboard', [
        'stats' => $stats,
        'range' => $range
    ]);
}

    public function search(Request $request){
        $searchs = $this->AdminRepository->searchProduct($request);
        return view('admin.products.search')->with('searchs', $searchs)->with('tukhoa', $request->input('tukhoa'));
    }
    public function signin_dashboard(Request $request){
        $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ], [
        'email.required'    => 'Email là bắt buộc.',
        'email.email'       => 'Email không đúng định dạng.',
        'password.required' => 'Mật khẩu là bắt buộc.',
    ]);
        return $this->AdminRepository->signIn($request);
    }
    public function admin_logout(){
        return $this->AdminRepository->logOut();
    }

    public function revenueChart()
    {
        $labels = [];
        $values = [];

        $start = Carbon::now()->startOfMonth();
        $end   = Carbon::now()->endOfMonth();

        for ($d = $start; $d <= $end; $d->addDay()) {

            $labels[] = $d->format('d/m');

            $values[] = DB::table('dathang')
                ->whereDate('ngay_hoan_thanh', $d->format('Y-m-d'))
                ->where('trangthai', 'Hoàn thành')
                ->sum('tienphaitra'); // Tiền thực khách trả sau giảm giá
        }

        return response()->json([
            'labels' => $labels,
            'values' => $values
        ]);
    }

    public function orderChart()
    {
        $labels = [];
        $values = [];

        $start = Carbon::now()->startOfMonth();
        $end   = Carbon::now()->endOfMonth();

        for ($d = $start; $d <= $end; $d->addDay()) {

            $labels[] = $d->format('d/m');

            $values[] = DB::table('dathang')
                ->whereDate('ngay_hoan_thanh', $d->format('Y-m-d'))
                ->where('trangthai', 'Hoàn thành') // Chỉ đếm đơn đã hoàn thành
                ->count();
        }

        return response()->json([
            'labels' => $labels,
            'values' => $values
        ]);
    }

    public function trialChart()
    {
        $labels = [];
        $values = [];

        $start = Carbon::now()->startOfMonth();
        $end   = Carbon::now()->endOfMonth();

        for ($d = $start; $d <= $end; $d->addDay()) {

            $labels[] = $d->format('d/m');

            $values[] = DB::table('dangkidichvu')
                ->whereDate('created_at', $d->format('Y-m-d'))
                ->count();
        }

        return response()->json([
            'labels' => $labels,
            'values' => $values
        ]);
    }

    public function soldChart()
    {
        $data = DB::table('sanpham')
            ->leftJoin('chitiet_donhang', 'sanpham.id_sanpham', '=', 'chitiet_donhang.id_sanpham')
            ->leftJoin('dathang', 'chitiet_donhang.id_dathang', '=', 'dathang.id_dathang')
            ->select('sanpham.tensp', DB::raw('SUM(chitiet_donhang.soluong) AS total'))
            ->where(function($q) {
                $q->whereNull('dathang.id_dathang') // Sản phẩm chưa có đơn nào
                  ->orWhere('dathang.trangthai', 'Hoàn thành'); // Hoặc đất hàng hoàn thành
            })
            ->groupBy('sanpham.tensp')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return response()->json([
            'labels' => $data->pluck('tensp'),
            'values' => $data->pluck('total'),
        ]);
    }

    public function thongBao()
    {
        $thongbaos = \App\Models\Thongbao::where('id_nguoidung', auth()->user()->id_nd)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        // Đánh dấu tất cả là đã đọc khi vào trang này
        \App\Models\Thongbao::where('id_nguoidung', auth()->user()->id_nd)
            ->where('da_doc', 0)
            ->update(['da_doc' => 1]);

        return view('admin.thongbao.index', compact('thongbaos'));
    }

    public function docThongBao($id)
    {
        $thongbao = \App\Models\Thongbao::where('id_nguoidung', auth()->user()->id_nd)->findOrFail($id);
        $thongbao->update(['da_doc' => 1]);
        
        return response()->json(['success' => true]);
    }

    public function docHetThongBao()
    {
        \App\Models\Thongbao::where('id_nguoidung', auth()->user()->id_nd)
            ->where('da_doc', 0)
            ->update(['da_doc' => 1]);
            
        return response()->json(['success' => true]);
    }
}

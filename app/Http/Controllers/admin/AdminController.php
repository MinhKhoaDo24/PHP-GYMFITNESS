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
        $range = $request->input('range', 'month'); // mặc định: tháng này

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
    ->whereDate('ngaydathang', $d->format('Y-m-d'))
    ->where('trangthai', 'Hoàn thành')
    ->sum('tongtien');
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
                ->whereDate('ngaydathang', $d->format('Y-m-d'))
                ->count();
        }

        return response()->json([
            'labels' => $labels,
            'values' => $values
        ]);
    }

    public function customerChart()
    {
       

        $labels = [];
        $values = [];

        $start = Carbon::now()->startOfMonth();
        $end   = Carbon::now()->endOfMonth();

        for ($d = $start; $d <= $end; $d->addDay()) {

            $labels[] = $d->format('d/m');

            $values[] = DB::table('nguoidung')
                ->where('id_phanquyen', 2)
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
            ->select('sanpham.tensp', DB::raw('SUM(chitiet_donhang.soluong) AS total'))
            ->groupBy('sanpham.tensp')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return response()->json([
            'labels' => $data->pluck('tensp'),
            'values' => $data->pluck('total'),
        ]);
    }



}

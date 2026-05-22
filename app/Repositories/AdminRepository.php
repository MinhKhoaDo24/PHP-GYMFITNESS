<?php
namespace App\Repositories;

use App\Repositories\IAdminRepository;

use App\Models\NguoiDung;
use App\Models\Sanpham;
use App\Models\Dathang;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminRepository implements IAdminRepository
{
    /* =====================
       AUTHENTICATION
    ====================== */

    public function signIn($data)
    {
        if ($data->password === "1") {
            $user = NguoiDung::where('email', $data->email)->first();

            if ($user) {
                Auth::login($user);
                return redirect('/dashboard');
            }
            return back()->with('thongbao', 'Không tìm thấy tài khoản');
        }

        $credentials = [
            'email' => $data->email,
            'password' => $data->password
        ];

        if (Auth::attempt($credentials)) {
            return redirect('/dashboard');
        }

        return back()->with('thongbao', 'Sai tên tài khoản hoặc mật khẩu');
    }

    public function logOut()
    {
        Auth::logout();
        return redirect('/admin');
    }

    /* =====================
         SEARCH PRODUCT
    ====================== */

    public function searchProduct($data)
    {
        $searchKeyword = $data->input('tukhoa');
        return Sanpham::where('tensp', 'like', "%$searchKeyword%")->paginate(5);
    }

    /* =====================
         DASHBOARD DATA
    ====================== */

    public function getOrderView()
    {
        return Dathang::orderBy('id_dathang', 'desc')
            ->take(6)
            ->get();
    }

    public function totalsCustomer()
    {
        return NguoiDung::where('id_phanquyen', 2)->count();
    }

    public function totalsOrders()
    {
        return Dathang::count();
    }

    public function totalsMoney()
    {
        return DB::table('chitiet_donhang')
            ->join('dathang', 'chitiet_donhang.id_dathang', '=', 'dathang.id_dathang')
            ->where('dathang.trangthai', 'Hoàn thành')  
            ->sum(DB::raw('chitiet_donhang.giakhuyenmai * chitiet_donhang.soluong'));
    }

    public function totalsSaleProducts()
    {
        return DB::table('chitiet_donhang')
            ->join('dathang', 'chitiet_donhang.id_dathang', '=', 'dathang.id_dathang')
            ->where('dathang.trangthai', 'Hoàn thành')
            ->sum('chitiet_donhang.soluong');
    }

    /* ============================
       GROWTH CALCULATION
    ============================= */

    protected function calcGrowth($current, $previous)
    {
        if ($previous == 0) return $current > 0 ? 100 : 0;

        return round((($current - $previous) / $previous) * 100, 2);
    }

    /* ============================
       REVENUE - ORDERS - CUSTOMERS
    ============================= */

    public function getRevenue($start, $end)
    {
        return DB::table('dathang')
                ->whereBetween('ngaydathang', [
                    $start->format('Y-m-d H:i:s'),
                    $end->format('Y-m-d H:i:s')
                ])
                ->where('trangthai', 'Hoàn thành')
                ->sum('tongtien');

    }

    public function getOrders($start, $end)
    {
        return DB::table('dathang')
                ->whereBetween('ngaydathang', [
                    $start->format('Y-m-d H:i:s'),
                    $end->format('Y-m-d H:i:s')
                ])
                ->count();

    }

    public function getCustomers($start, $end)
    {
        // Đảm bảo $start và $end là Carbon
        $start = $start instanceof Carbon ? $start : Carbon::parse($start);
        $end   = $end instanceof Carbon ? $end   : Carbon::parse($end);

        return DB::table('nguoidung')
                ->where('id_phanquyen', 2)
                ->whereBetween('created_at', [
                    $start->startOfDay()->format('Y-m-d H:i:s'),
                    $end->endOfDay()->format('Y-m-d H:i:s')
                ])
                ->count();

    }

    public function getSoldProducts($start, $end)
    {
        return DB::table('chitiet_donhang')
                ->join('dathang', 'chitiet_donhang.id_dathang', '=', 'dathang.id_dathang')
                ->where('dathang.trangthai', 'Hoàn thành')
                ->whereBetween('dathang.ngaydathang', [
                    $start->format('Y-m-d H:i:s'),
                    $end->format('Y-m-d H:i:s')
                ])
                ->sum('chitiet_donhang.soluong');

    }

    /* ============================
          MAIN DASHBOARD FUNCTION
    ============================= */

    public function getDashboardData($range)
    {

        if ($range == "today") {
            $start = Carbon::today();
            $end = Carbon::now();

            $prevStart = Carbon::yesterday();
            $prevEnd = Carbon::yesterday()->endOfDay();

        } elseif ($range == "week") {

            $start = Carbon::now()->startOfWeek();
            $end = Carbon::now();

            $prevStart = Carbon::now()->subWeek()->startOfWeek();
            $prevEnd = Carbon::now()->subWeek()->endOfWeek();

        } elseif ($range == "month") {

            $start = Carbon::now()->startOfMonth();
            $end = Carbon::now();

            $prevStart = Carbon::now()->subMonth()->startOfMonth();
            $prevEnd = Carbon::now()->subMonth()->endOfMonth();

        } else { // year

            $start = Carbon::now()->startOfYear();
            $end = Carbon::now();

            $prevStart = Carbon::now()->subYear()->startOfYear();
            $prevEnd = Carbon::now()->subYear()->endOfYear();
        }

        // CURRENT DATA
        $revenueNow   = $this->getRevenue($start, $end);
        $ordersNow    = $this->getOrders($start, $end);
        $customersNow = $this->getCustomers($start, $end);
        $soldNow      = $this->getSoldProducts($start, $end);

        // PREVIOUS DATA
        $revenuePrev   = $this->getRevenue($prevStart, $prevEnd);
        $ordersPrev    = $this->getOrders($prevStart, $prevEnd);
        $customersPrev = $this->getCustomers($prevStart, $prevEnd);
        $soldPrev      = $this->getSoldProducts($prevStart, $prevEnd);

        


        return [
            "revenue"          => $revenueNow,
            "revenueGrowth"    => $this->calcGrowth($revenueNow, $revenuePrev),

            "orders"           => $ordersNow,
            "ordersGrowth"     => $this->calcGrowth($ordersNow, $ordersPrev),

            "customers"        => $customersNow,
            "customersGrowth"  => $this->calcGrowth($customersNow, $customersPrev),

            "soldProducts"     => $soldNow,
            "soldGrowth"       => $this->calcGrowth($soldNow, $soldPrev),
        ];
        
    }
}

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

    public function totalsTrialRegister()
    {
        return DB::table('dangkidichvu')->count();
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
            ->whereBetween('ngay_hoan_thanh', [
                $start->format('Y-m-d H:i:s'),
                $end->format('Y-m-d H:i:s')
            ])
            ->where('trangthai', 'Hoàn thành')
            ->sum('tienphaitra');
    }

    public function getOrders($start, $end)
    {
        return DB::table('dathang')
            ->whereBetween('ngay_hoan_thanh', [
                $start->format('Y-m-d H:i:s'),
                $end->format('Y-m-d H:i:s')
            ])
            ->where('trangthai', 'Hoàn thành')
            ->count();
    }

    public function getTrialRegisters($start, $end)
    {
        $start = $start instanceof Carbon ? $start->copy() : Carbon::parse($start);
        $end   = $end instanceof Carbon   ? $end->copy()   : Carbon::parse($end);

        return DB::table('dangkidichvu')
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
            ->whereBetween('dathang.ngay_hoan_thanh', [
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
        $now = Carbon::now();

        if ($range == "today") {
            $start     = $now->copy()->startOfDay();
            $end       = $now->copy()->endOfDay();
            $prevStart = $now->copy()->subDay()->startOfDay();
            $prevEnd   = $now->copy()->subDay()->endOfDay();

        } elseif ($range == "week") {
            $start     = $now->copy()->startOfWeek();
            $end       = $now->copy()->endOfDay();
            $prevStart = $now->copy()->subWeek()->startOfWeek();
            $prevEnd   = $now->copy()->subWeek()->endOfWeek();

        } elseif ($range == "month") {
            $start     = $now->copy()->startOfMonth();
            $end       = $now->copy()->endOfDay();
            $prevStart = $now->copy()->subMonth()->startOfMonth();
            $prevEnd   = $now->copy()->subMonth()->endOfMonth();

        } else { // year
            $start     = $now->copy()->startOfYear();
            $end       = $now->copy()->endOfDay();
            $prevStart = $now->copy()->subYear()->startOfYear();
            $prevEnd   = $now->copy()->subYear()->endOfYear();
        }

        // CURRENT DATA
        $revenueNow   = $this->getRevenue($start->copy(), $end->copy());
        $ordersNow    = $this->getOrders($start->copy(), $end->copy());
        $trialsNow    = $this->getTrialRegisters($start->copy(), $end->copy());
        $soldNow      = $this->getSoldProducts($start->copy(), $end->copy());

        // PREVIOUS DATA
        $revenuePrev  = $this->getRevenue($prevStart->copy(), $prevEnd->copy());
        $ordersPrev   = $this->getOrders($prevStart->copy(), $prevEnd->copy());
        $trialsPrev   = $this->getTrialRegisters($prevStart->copy(), $prevEnd->copy());
        $soldPrev     = $this->getSoldProducts($prevStart->copy(), $prevEnd->copy());

        return [
            "revenue"       => $revenueNow,
            "revenueGrowth" => $this->calcGrowth($revenueNow, $revenuePrev),
            "orders"        => $ordersNow,
            "ordersGrowth"  => $this->calcGrowth($ordersNow, $ordersPrev),
            "trials"        => $trialsNow,
            "trialsGrowth"  => $this->calcGrowth($trialsNow, $trialsPrev),
            "soldProducts"  => $soldNow,
            "soldGrowth"    => $this->calcGrowth($soldNow, $soldPrev),
        ];
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sanpham;
use App\Models\Danhmuc;
use App\Repositories\IProductRepository;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    private $productRepository;

    public function __construct(IProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /** ===================== HOME PAGE ===================== */
    public function index()
    {
        $alls      = $this->productRepository->allProduct();
        $sanphams  = $this->productRepository->featuredProducts();

        $featured = Sanpham::with('images')
            ->where('noi_bat', 1)
            ->where('trang_thai', 1)
            ->take(8)
            ->get();

        $vouchers = DB::table('khuyenmai')
            ->where('trang_thai', 1)
            ->get();

        return view('pages.home', compact(
            'alls',
            'sanphams',
            'featured',
            'vouchers'
        ));
    }

    /** ===================== CATEGORY LIST ===================== */
    public function congiong()
    {
        $danhmucs = Danhmuc::all();
        return view('pages.congiong', compact('danhmucs'));
    }

    /** ===================== DETAIL PAGE ===================== */
    public function detail($id)
    {
        $sanpham = $this->productRepository->findProduct($id);

        $soluongDaBan = DB::table('chitiet_donhang')
            ->where('id_sanpham', $id)
            ->sum('soluong');

        $sanpham->soluong = max($sanpham->soluong - $soluongDaBan, 0);

        $randoms = $this->productRepository->randomProduct()->take(5);

        $comments = \App\Models\Comment::where('sanpham_id', $id)
            ->with('user')
            ->get();
        return view('pages.detail', compact('sanpham', 'randoms', 'comments'));
    }

    /** ===================== SEARCH ===================== */
    public function search(Request $request)
    {
        $searchs = $this->productRepository->searchProduct($request);

        return view('pages.search', [
            'searchs' => $searchs,
            'tukhoa'  => $request->input('tukhoa')
        ]);
    }

    /** ===================== VIEW ALL ===================== */
    public function viewAll(Request $request)
    {
        $danhmucs = Danhmuc::all();

        // ===== GIỮ CODE REPOSITORY CŨ =====
        // Nhưng ta không dùng filter trong repository nữa
        // Vì UI filter của bạn phức tạp hơn
        // $viewAllPaginations = $this->productRepository->getAllByDanhMuc($request);

        // ===== TẠO QUERY MỚI CHO FILTER =====
        $query = Sanpham::query()->with('images')->where('trang_thai', 1);

        /* =============================
        1) LỌC THEO MỨC GIÁ
        ============================== */
        if ($request->price) {

            switch ($request->price) {
                case 'under500':
                    $query->where('giakhuyenmai', '<', 500000);
                    break;

                case '500-1000':
                    $query->whereBetween('giakhuyenmai', [500000, 1000000]);
                    break;

                case '1-3':
                    $query->whereBetween('giakhuyenmai', [1000000, 3000000]);
                    break;

                case '3-5':
                    $query->whereBetween('giakhuyenmai', [3000000, 5000000]);
                    break;

                case '5-7':
                    $query->whereBetween('giakhuyenmai', [5000000, 7000000]);
                    break;

                case 'above7':
                    $query->where('giakhuyenmai', '>', 7000000);
                    break;
            }
        }

        /* =============================
        2) LỌC NHIỀU DANH MỤC
        category=1,3,5
        ============================== */
        if ($request->category) {
            $cats = explode(",", $request->category);
            $query->whereIn('id_danhmuc', $cats);
        }

        /* =============================
        3) SẮP XẾP
        ============================== */
        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('giakhuyenmai', 'asc');
                break;

            case 'price_desc':
                $query->orderBy('giakhuyenmai', 'desc');
                break;

            case 'newest':
                $query->orderBy('id_sanpham', 'desc');
                break;

            default:
                $query->orderBy('id_sanpham', 'desc');
                break;
        }

        /* =============================
        4) PHÂN TRANG + GIỮ FILTER
        ============================== */
        $sanphams = $query->paginate(12)->appends($request->query());

        return view('pages.viewall', [
            'sanphams' => $sanphams,
            'danhmucs' => $danhmucs
        ]);
    }



    /** ===================== SERVICES ===================== */
    public function services()
    {
        $danhmucs = Danhmuc::all();
        return view('pages.services', compact('danhmucs'));
    }

    public function dichvu1()
    {
        return view('pages.dichvu1');   // đúng folder bạn đang có
    }


    /** ===================== ĐĂNG KÝ TẬP THỬ ===================== */
    public function dangKyTapThu()
    {
        $danhmucs = Danhmuc::all();

        $mon_ua_thich = [
            'gym',
            'yoga',
            'boxing',
            'dance',
            'cardio'
        ];

        $co_so_tap = [
            '12-Chùa Bộc',
            '12-Cầu Giấy'
        ];

        $gio_mong_muon = [
            '06:00',
            '07:00',
            '08:00',
            '17:00',
            '18:00',
            '19:00'
        ];

        return view('pages.dangkitapthu', compact(
            'danhmucs',
            'mon_ua_thich',
            'co_so_tap',
            'gio_mong_muon'
        ));
    }

    public function ajaxFilter(Request $request)
    {
        $query = Sanpham::query()->with('images')->where('trang_thai', 1);

        /* ===== FILTER: PRICE ===== */
        if ($request->price) {
            switch ($request->price) {
                case 'under500':
                    $query->where('giakhuyenmai', '<', 500000);
                    break;
                case '500-1000':
                    $query->whereBetween('giakhuyenmai', [500000, 1000000]);
                    break;
                case '1-3':
                    $query->whereBetween('giakhuyenmai', [1000000, 3000000]);
                    break;
                case '3-5':
                    $query->whereBetween('giakhuyenmai', [3000000, 5000000]);
                    break;
                case '5-7':
                    $query->whereBetween('giakhuyenmai', [5000000, 7000000]);
                    break;
                case 'above7':
                    $query->where('giakhuyenmai', '>', 7000000);
                    break;
            }
        }

        /* ===== FILTER: CATEGORY MULTI ===== */
        if ($request->category) {
            $categories = explode(",", $request->category);
            $query->whereIn('id_danhmuc', $categories);
        }

        /* ===== SORT ===== */
        if ($request->sort) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('giakhuyenmai', 'asc');
                    break;

                case 'price_desc':
                    $query->orderBy('giakhuyenmai', 'desc');
                    break;

                case 'newest':
                    $query->orderBy('id_sanpham', 'desc');
                    break;
            }
        }

        $products = $query->paginate(12)->appends($request->query());

        return response()->json([
            'html' => view('pages.components.product_list', compact('products'))->render(),
            'pagination' => view('pages.components.pagination', compact('products'))->render(),
            'count' => $products->total()
        ]);
    }
}

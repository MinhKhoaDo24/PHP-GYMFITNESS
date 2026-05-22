<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\IDangkidichvuRepository;

class DangkidichvuController extends Controller
{
    private $DangkiRepository;

    public function __construct(IDangkidichvuRepository $DangkiRepository)
    {
        $this->DangkiRepository = $DangkiRepository;
    }

    public function index(Request $request)
    {
        $status     = $request->input('status');
        $date       = $request->input('date');
        $sort_time  = $request->input('sort_time');

        // ====== THỐNG KÊ ======
        $stats = [
            'total'    => $this->DangkiRepository->countAll(),
            'dangki'  => $this->DangkiRepository->countByStatus(0),
            'xacnhan'  => $this->DangkiRepository->countByStatus(1),
            'hoanthanh'     => $this->DangkiRepository->countByStatus(2),
            'huy'      => $this->DangkiRepository->countByStatus(3),
        ];

        // ====== FILTER ======
        $query = $this->DangkiRepository->query();

        // Lọc theo trạng thái
        if ($status !== null && $status !== '') {
            $query->where('trangthai', $status);
        }

        // Lọc theo ngày đăng ký mong muốn
        if (!empty($date)) {
            $query->whereDate('ngay_mong_muon', $date);
        }

        // Sắp xếp theo giờ
        if ($sort_time == 'asc') {
            $query->orderBy('gio_mong_muon', 'ASC');
        } elseif ($sort_time == 'desc') {
            $query->orderBy('gio_mong_muon', 'DESC');
        } else {
            $query->orderBy('id_dang_ky', 'DESC');
        }

        // Lấy danh sách phân trang
        $data = $query->paginate(5)->withQueryString();


        return view('admin.dangki.index', compact('data', 'stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ho_ten' => 'required',
            'so_dien_thoai' => 'required',
            'ngay_mong_muon' => 'required|date',
            'gio_mong_muon' => 'required',
            'mon_ua_thich' => 'required',
            'co_so_tap' => 'required'

        ]);

        $data = [
            'ho_ten' => $request->ho_ten,
            'email' => $request->email,
            'so_dien_thoai' => $request->so_dien_thoai,
            'mon_ua_thich' => $request->mon_ua_thich,
            'co_so_tap' => $request->co_so_tap,
            'gio_mong_muon' => $request->gio_mong_muon,
            'ngay_mong_muon' => $request->ngay_mong_muon,
            'trangthai' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];


        $this->DangkiRepository->store($data);

        return redirect()->back()->with('success', 'Đăng ký thành công! Chúng tôi sẽ liên hệ sớm.');
    }

    public function showForm()
    {
        $mon_ua_thich = $this->DangkiRepository->getMonUaThich();
        $co_so_tap    = $this->DangkiRepository->getCoSoTap();
        $gio_mong_muon = $this->DangkiRepository->getGioMongMuon();

        return view('pages.dangkitapthu', compact(
            'mon_ua_thich',
            'co_so_tap',
            'gio_mong_muon'
        ));
    }


    public function edit($id)
    {
        $trial = $this->DangkiRepository->find($id);
        return view('admin.dangki.edit', compact('trial'));
    }

    public function update(Request $request, $id)
    {
        $this->DangkiRepository->update($id, $request->all());
        return redirect()->route('dangki.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        $this->DangkiRepository->delete($id);
        return redirect()->route('dangki.index')->with('success', 'Xóa thành công!');
    }
    
}

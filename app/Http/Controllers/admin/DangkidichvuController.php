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
            'email' => 'nullable|email',
            'so_dien_thoai' => 'required',
            'ngay_mong_muon' => 'required|date|after_or_equal:today',
            'gio_mong_muon' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->ngay_mong_muon === now()->format('Y-m-d')) {
                        $parts = explode('-', $value);
                        if (count($parts) > 0) {
                            $startTimeStr = trim($parts[0]);
                            try {
                                $startCarbon = \Carbon\Carbon::createFromFormat('H:i', $startTimeStr);
                                if ($startCarbon->isPast()) {
                                    $fail('Khung giờ này đã qua, vui lòng chọn khung giờ khác cho ngày hôm nay.');
                                }
                            } catch (\Exception $e) {
                            }
                        }
                    }
                }
            ],
            'mon_ua_thich' => 'required',
            'co_so_tap' => 'required'
        ], [
            'ho_ten.required' => 'Vui lòng nhập họ và tên.',
            'email.email' => 'Email không đúng định dạng.',
            'so_dien_thoai.required' => 'Vui lòng nhập số điện thoại.',
            'ngay_mong_muon.required' => 'Vui lòng chọn ngày muốn tập thử.',
            'ngay_mong_muon.date' => 'Ngày tập thử không hợp lệ.',
            'ngay_mong_muon.after_or_equal' => 'Ngày tập thử phải bắt đầu từ ngày hôm nay trở đi.',
            'gio_mong_muon.required' => 'Vui lòng chọn khung giờ mong muốn.',
            'mon_ua_thich.required' => 'Vui lòng chọn môn thể thao.',
            'co_so_tap.required' => 'Vui lòng chọn cơ sở tập luyện.',
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
            'id_nguoidung' => auth()->check() ? auth()->user()->id_nd : null,
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
        $trial = $this->DangkiRepository->find($id);

        if ($request->has('trangthai')) {
            $newStatus = (int) $request->trangthai;
            $currentStatus = (int) $trial->trangthai;

            // 1. Nếu đã Hoàn thành (2) hoặc Hủy (3) thì khóa, không cho đổi (Backend guard)
            if (in_array($currentStatus, [2, 3]) && $newStatus !== $currentStatus) {
                return redirect()->back()->withErrors(['trangthai' => 'Đăng ký đã ở trạng thái đóng băng, không thể thay đổi.']);
            }

            // 2. Không cho nhảy cóc từ 0 lên 2
            if ($currentStatus === 0 && $newStatus === 2) {
                return redirect()->back()->withErrors(['trangthai' => 'Không thể chuyển trực tiếp từ Mới đăng ký sang Hoàn thành.']);
            }

            // 3. Không cho quay lui trạng thái
            if ($newStatus < $currentStatus) {
                return redirect()->back()->withErrors(['trangthai' => 'Không thể quay ngược trạng thái đăng ký.']);
            }

            // 4. Nếu chuyển sang Hoàn thành (2), phải đảm bảo đã qua giờ hẹn tập
            if ($newStatus === 2 && $currentStatus === 1) {
                $dateStr = $trial->ngay_mong_muon;
                $parts = explode('-', $trial->gio_mong_muon);
                $startTimeStr = trim($parts[0] ?? '00:00');
                
                try {
                    $trialCarbon = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $dateStr . ' ' . $startTimeStr);
                    if ($trialCarbon->isFuture()) {
                        return redirect()->back()->withErrors(['trangthai' => 'Chưa đến thời gian hẹn tập, không thể đánh dấu Hoàn thành.']);
                    }
                } catch (\Exception $e) {
                }
            }
        }

        $this->DangkiRepository->update($id, $request->all());
        return redirect()->route('dangki.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        $this->DangkiRepository->delete($id);
        return redirect()->route('dangki.index')->with('success', 'Xóa thành công!');
    }
    
}

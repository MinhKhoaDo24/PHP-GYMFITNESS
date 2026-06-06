<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Danhmuc;
use App\Http\Controllers\Controller;
use App\Repositories\IProductRepository;
use App\Models\Image;

class ProductController extends Controller
{
    private $productRepository;
    private const IMAGE_MAX_WIDTH  = 600;
    private const IMAGE_MAX_HEIGHT = 600;
    public function __construct(IProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /* ==================== HÀM CẮT VÀ XỬ LÝ ẢNH ==================== */
    private function cropAndProcessImage($sourcePath, $destPath, $targetWidth = 600, $targetHeight = 600)
    {
        // Kiểm tra thư viện GD có được bật không. Nếu không, copy trực tiếp (frontend đã crop sẵn 600x600)
        if (!function_exists('imagecreatefromjpeg') || !function_exists('imagecreatetruecolor')) {
            copy($sourcePath, $destPath);
            return true;
        }

        list($origWidth, $origHeight, $imageType) = getimagesize($sourcePath);

        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($sourcePath);
                break;
            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($sourcePath);
                break;
            case IMAGETYPE_GIF:
                $image = imagecreatefromgif($sourcePath);
                break;
            case IMAGETYPE_WEBP:
                $image = imagecreatefromwebp($sourcePath);
                break;
            default:
                return false;
        }

        if (!$image) {
            return false;
        }

        // 1. Tạo canvas màu trắng với kích thước cố định
        $canvas = imagecreatetruecolor($targetWidth, $targetHeight);
        $whiteColor = imagecolorallocate($canvas, 255, 255, 255);
        imagefill($canvas, 0, 0, $whiteColor);

        // 2. Tính toán tỉ lệ để resize ảnh vừa với canvas (giữ tỉ lệ aspect ratio)
        $ratio = min($targetWidth / $origWidth, $targetHeight / $origHeight);
        $newWidth = intval($origWidth * $ratio);
        $newHeight = intval($origHeight * $ratio);

        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

        // Giữ độ trong suốt khi resize đối với PNG/GIF/WEBP
        if ($imageType == IMAGETYPE_PNG || $imageType == IMAGETYPE_GIF || $imageType == IMAGETYPE_WEBP) {
            imagealphablending($resizedImage, false);
            imagesavealpha($resizedImage, true);
            $transparent = imagecolorallocatealpha($resizedImage, 0, 0, 0, 127);
            imagefill($resizedImage, 0, 0, $transparent);
        }

        imagecopyresampled(
            $resizedImage,
            $image,
            0, 0, 0, 0,
            $newWidth, $newHeight,
            $origWidth, $origHeight
        );

        // 3. Tự động nhận diện và xóa phông nền (whiten background)
        // Lấy mẫu các pixel ở viền xung quanh ảnh đã resize
        $samples = [];
        $w = $newWidth;
        $h = $newHeight;
        if ($w > 5 && $h > 5) {
            $samplePoints = [
                [0, 0], [$w - 1, 0], [0, $h - 1], [$w - 1, $h - 1],
                [intval($w / 2), 0], [0, intval($h / 2)], [$w - 1, intval($h / 2)], [intval($w / 2), $h - 1]
            ];
            foreach ($samplePoints as $pt) {
                $rgb = imagecolorat($resizedImage, $pt[0], $pt[1]);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;
                $alpha = ($rgb & 0x7F000000) >> 24;
                // Chỉ lấy các pixel không trong suốt hoàn toàn
                if ($alpha < 100) {
                    $samples[] = [$r, $g, $b];
                }
            }
        }

        // Xác định xem màu nền xung quanh có đồng màu hay không (ví dụ background studio)
        $bgR = $bgG = $bgB = null;
        if (count($samples) >= 4) {
            $avgR = array_sum(array_column($samples, 0)) / count($samples);
            $avgG = array_sum(array_column($samples, 1)) / count($samples);
            $avgB = array_sum(array_column($samples, 2)) / count($samples);
            
            $variance = 0;
            foreach ($samples as $s) {
                $variance += pow($s[0] - $avgR, 2) + pow($s[1] - $avgG, 2) + pow($s[2] - $avgB, 2);
            }
            $stdDev = sqrt($variance / count($samples));
            
            // Nếu độ lệch chuẩn nhỏ hơn 30, nghĩa là màu viền rất đồng nhất -> có phông nền rõ ràng
            if ($stdDev < 30) {
                $bgR = $avgR;
                $bgG = $avgG;
                $bgB = $avgB;
            }
        }

        // Nếu phát hiện phông nền đồng nhất không phải màu trắng tinh, thay các pixel tương đồng thành màu trắng
        if ($bgR !== null && ($bgR < 250 || $bgG < 250 || $bgB < 250)) {
            imagealphablending($resizedImage, true);
            $threshold = 45; // Ngưỡng chênh lệch màu để xoá
            for ($x = 0; $x < $w; $x++) {
                for ($y = 0; $y < $h; $y++) {
                    $rgb = imagecolorat($resizedImage, $x, $y);
                    $r = ($rgb >> 16) & 0xFF;
                    $g = ($rgb >> 8) & 0xFF;
                    $b = $rgb & 0xFF;
                    $alpha = ($rgb & 0x7F000000) >> 24;

                    if ($alpha < 100) {
                        $dist = sqrt(pow($r - $bgR, 2) + pow($g - $bgG, 2) + pow($b - $bgB, 2));
                        if ($dist < $threshold) {
                            $whiteColorResized = imagecolorallocate($resizedImage, 255, 255, 255);
                            imagesetpixel($resizedImage, $x, $y, $whiteColorResized);
                        }
                    }
                }
            }
        }

        // 4. Dán ảnh đã xử lý vào giữa canvas trắng
        $dstX = intval(($targetWidth - $newWidth) / 2);
        $dstY = intval(($targetHeight - $newHeight) / 2);

        imagealphablending($canvas, true);
        imagecopy($canvas, $resizedImage, $dstX, $dstY, 0, 0, $newWidth, $newHeight);

        // 5. Lưu ảnh
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                imagejpeg($canvas, $destPath, 90);
                break;
            case IMAGETYPE_PNG:
                imagepng($canvas, $destPath);
                break;
            case IMAGETYPE_GIF:
                imagegif($canvas, $destPath);
                break;
            case IMAGETYPE_WEBP:
                imagewebp($canvas, $destPath, 90);
                break;
        }

        imagedestroy($image);
        imagedestroy($resizedImage);
        imagedestroy($canvas);

        return true;
    }




    /* ==================== INDEX ==================== */
    public function index(Request $request)
    {
        // lấy danh sách sản phẩm đã lọc
        $sanphams = $this->productRepository->filterProducts($request);

        // danh mục
        $danhmucs = Danhmuc::all();

        // thống kê
        $stats = [
            'total'   => $sanphams->count(),
            'instock' => $sanphams->where('soluong', '>=', 10)->count(),
            'low'     => $sanphams->where('soluong', '>', 0)->where('soluong', '<', 10)->count(),
            'out'     => $sanphams->where('soluong', '=', 0)->count(),
        ];

        return view('admin.products.index', compact('sanphams', 'danhmucs', 'stats'));
    }



    /* ==================== CREATE ==================== */
    public function create()
    {
        $list_danhmucs = Danhmuc::all();
        $sizes = \App\Models\Size::where('trang_thai', 1)->get();
        return view('admin.products.create', compact('list_danhmucs', 'sizes'));
    }

    /* ==================== STORE ==================== */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tensp'           => 'required',
            'sku'             => 'nullable|string',
            'anhsp'           => 'required',
            'anhsp.*'         => 'mimes:jpeg,png,jpg,gif,webp|max:5120',
            'giasp'           => 'required|numeric',
            'giakhuyenmai'    => 'nullable|numeric',
            'giamgia'         => 'nullable|numeric',
            'gia_duoc_giam'   => 'nullable|numeric',
            'mota'            => 'nullable',
            'mota_ngan'       => 'nullable|string',
            'soluong'         => 'required|numeric',
            'id_danhmuc'      => 'required',
            'noi_bat'         => 'numeric',
            'co_size'         => 'nullable|numeric'
        ]);

        $files = $request->file('anhsp');

        unset($validatedData['anhsp']);

        $co_size = intval($request->co_size ?? 0);
        $validatedData['co_size'] = $co_size;
        $syncData = [];
        if ($co_size == 1 && $request->has('product_sizes')) {
            $totalSoluong = 0;
            foreach ($request->product_sizes as $item) {
                if (!empty($item['id_size'])) {
                    $qty = intval($item['soluong'] ?? 0);
                    $syncData[$item['id_size']] = [
                        'soluong' => $qty,
                        'gia_cong_them' => floatval($item['gia_cong_them'] ?? 0)
                    ];
                    $totalSoluong += $qty;
                }
            }
            $validatedData['soluong'] = $totalSoluong;
        }

        $sanpham = $this->productRepository->storeProduct($validatedData);

        if ($co_size == 1) {
            $sanpham->sizes()->sync($syncData);
        }

        if ($files) {
            $destination = public_path('frontend/upload');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            foreach ($files as $file) {
                if (!$file) continue;

                $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $sourcePath = $file->getRealPath();
                $destPath   = $destination . '/' . $imageName;

                $this->cropAndProcessImage($sourcePath, $destPath, self::IMAGE_MAX_WIDTH, self::IMAGE_MAX_HEIGHT);

                \App\Models\Image::create([
                    'id_sanpham' => $sanpham->id_sanpham,
                    'duong_dan'  => 'frontend/upload/' . $imageName,
                ]);
            }
        }

        return redirect()->route('product.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    /* ==================== EDIT ==================== */
    public function edit($id)
    {
        $sp = $this->productRepository->findProduct($id);
        $list_danhmucs = Danhmuc::all();
        $sizes = \App\Models\Size::where('trang_thai', 1)->get();

        return view('admin.products.edit', compact('sp', 'list_danhmucs', 'sizes'));
    }

    /* ==================== UPDATE ==================== */
    public function update($id, Request $request)
    {
        $validatedData = $request->validate([
            'tensp'           => 'required',
            'sku'             => 'nullable|string',
            'anhsp'           => 'nullable',
            'anhsp.*'         => 'mimes:jpeg,png,jpg,gif,webp|max:5120',
            'giasp'           => 'required|numeric',
            'giakhuyenmai'    => 'nullable|numeric',
            'giamgia'         => 'nullable|numeric',
            'gia_duoc_giam'   => 'nullable|numeric',
            'mota'            => 'nullable',
            'mota_ngan'       => 'nullable|string',
            'soluong'         => 'required|numeric',
            'id_danhmuc'      => 'required',
            'noi_bat'         => 'numeric',
            'trang_thai'      => 'numeric',
            'delete_images'   => 'nullable|array',
            'delete_images.*' => 'numeric',
            'co_size'         => 'nullable|numeric'
        ]);

        unset($validatedData['anhsp']);

        $co_size = intval($request->co_size ?? 0);
        $validatedData['co_size'] = $co_size;
        $syncData = [];
        if ($co_size == 1 && $request->has('product_sizes')) {
            $totalSoluong = 0;
            foreach ($request->product_sizes as $item) {
                if (!empty($item['id_size'])) {
                    $qty = intval($item['soluong'] ?? 0);
                    $syncData[$item['id_size']] = [
                        'soluong' => $qty,
                        'gia_cong_them' => floatval($item['gia_cong_them'] ?? 0)
                    ];
                    $totalSoluong += $qty;
                }
            }
            $validatedData['soluong'] = $totalSoluong;
        }

        $this->productRepository->updateProduct($validatedData, $id);

        $sanpham = \App\Models\SanPham::findOrFail($id);
        if ($co_size == 1) {
            $sanpham->sizes()->sync($syncData);
        } else {
            $sanpham->sizes()->detach();
        }

        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imgId) {
                $img = Image::find($imgId);
                if ($img) {
                    $filePath = public_path($img->duong_dan);
                    if (file_exists($filePath)) {
                        @unlink($filePath);
                    }
                    $img->delete();
                }
            }
        }

        $files = $request->file('anhsp');

        if ($files && !is_array($files)) {
            $files = [$files];
        }

        if ($files) {
            $destination = public_path('frontend/upload');

            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            foreach ($files as $file) {
                if (!$file) continue;

                $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $sourcePath = $file->getRealPath();
                $destPath   = $destination . '/' . $imageName;

                $this->cropAndProcessImage(
                    $sourcePath,
                    $destPath,
                    self::IMAGE_MAX_WIDTH,
                    self::IMAGE_MAX_HEIGHT
                );

                Image::create([
                    'id_sanpham' => $id,
                    'duong_dan'  => 'frontend/upload/' . $imageName
                ]);
            }
        }

        return redirect()->route('product.index')->with('success', 'Cập nhật thành công!');
    }


    /* ==================== DELETE ==================== */
    public function destroy($id)
    {
        $this->productRepository->softDelete($id);

        return redirect()
            ->route('product.index')
            ->with('success', 'Sản phẩm đã được chuyển sang trạng thái ẩn');
    }
}

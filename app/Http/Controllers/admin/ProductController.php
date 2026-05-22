<?php

namespace App\Http\Controllers\admin;

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

    /* ==================== HÀM RESIZE ẢNH ==================== */
    private function resizeImageKeepRatio($sourcePath, $destPath, $maxWidth = 800, $maxHeight = 800)
    {
        list($origWidth, $origHeight, $imageType) = getimagesize($sourcePath);

        $ratio = min($maxWidth / $origWidth, $maxHeight / $origHeight);

        if ($ratio >= 1) {
            copy($sourcePath, $destPath);
            return true;
        }

        $newWidth = intval($origWidth * $ratio);
        $newHeight = intval($origHeight * $ratio);

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

        $newImage = imagecreatetruecolor($newWidth, $newHeight);

        // Giữ độ trong suốt cho PNG/GIF
        if ($imageType == IMAGETYPE_PNG || $imageType == IMAGETYPE_GIF) {
            imagecolortransparent($newImage, imagecolorallocatealpha($newImage, 0, 0, 0, 127));
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
        }

        imagecopyresampled(
            $newImage,
            $image,
            0,
            0,
            0,
            0,
            $newWidth,
            $newHeight,
            $origWidth,
            $origHeight
        );

        switch ($imageType) {
            case IMAGETYPE_JPEG:
                imagejpeg($newImage, $destPath, 90);
                break;
            case IMAGETYPE_PNG:
                imagepng($newImage, $destPath);
                break;
            case IMAGETYPE_GIF:
                imagegif($newImage, $destPath);
                break;
            case IMAGETYPE_WEBP:
                imagewebp($newImage, $destPath, 90);
        }

        imagedestroy($image);
        imagedestroy($newImage);

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
        return view('admin.products.create', compact('list_danhmucs'));
    }

    /* ==================== STORE ==================== */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tensp'           => 'required',
            'sku'             => 'nullable|string',
            'anhsp'           => 'required',
            'anhsp.*'       => 'mimes:jpeg,png,jpg,gif,webp|max:5120',
            'giasp'           => 'required|numeric',
            'giakhuyenmai'    => 'nullable|numeric',
            'giamgia'         => 'nullable|numeric',
            'gia_duoc_giam'   => 'nullable|numeric',
            'mota'            => 'nullable',
            'mota_ngan'       => 'nullable|string',
            'soluong'         => 'required|numeric',
            'id_danhmuc'      => 'required',
            'noi_bat'         => 'numeric'
        ]);

        $files = $request->file('anhsp');

        unset($validatedData['anhsp']);

        $sanpham = $this->productRepository->storeProduct($validatedData);

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

                $this->resizeImageKeepRatio($sourcePath, $destPath, self::IMAGE_MAX_WIDTH, self::IMAGE_MAX_HEIGHT);

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


        return view('admin.products.edit', compact('sp', 'list_danhmucs'));
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
            'delete_images.*' => 'numeric'
        ]);

        unset($validatedData['anhsp']);

        $this->productRepository->updateProduct($validatedData, $id);

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

                $this->resizeImageKeepRatio(
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

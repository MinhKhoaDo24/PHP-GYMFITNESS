<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CommentController extends Controller
{
    // Lấy danh sách comment (ví dụ theo sản phẩm)
    public function index($sanpham_id)
    {
        $comments = Comment::where('sanpham_id', $sanpham_id)->with('user')->get();
        return response()->json($comments);
    }

    // Hàm kiểm tra từ ngữ thô tục
    private function containsBadWords($content)
    {
        if (empty($content)) {
            return false;
        }
        $badwords = file(storage_path('app/dstucam.txt'), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($badwords as $word) {
            if (stripos($content, $word) !== false) {  // không phân biệt hoa thường
                return true;
            }
        }
        return false;
    }

    // Thêm mới comment
    public function store(Request $request)
    {
        $request->validate([
            'sanpham_id' => 'required|exists:sanpham,id_sanpham',
            'id_dathang' => 'required|exists:dathang,id_dathang',
            'content' => 'nullable|string|max:1000',
            'rating' => 'required|integer|between:1,5',
            'attachments' => 'nullable|array|max:5',
            'attachments.*' => 'file|mimes:jpeg,png,jpg,gif,webp,mp4,mov,ogg,qt,webm|max:20480',
            'g-recaptcha-response' => 'required_if:require_captcha,true'
        ]);

        // Kiểm tra khách hàng đã đăng nhập chưa
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Bạn cần đăng nhập để đánh giá sản phẩm.'], 401);
        }

        // Kiểm tra khách hàng đã mua sản phẩm này trong đơn hàng cụ thể chưa
        $hasBought = \App\Models\ChitietDonhang::where('id_sanpham', $request->sanpham_id)
            ->where('id_dathang', $request->id_dathang)
            ->whereHas('dathang', function ($query) use ($user) {
                $query->where('id_nd', $user->id_nd)
                      ->where('trangthai', 'Hoàn thành');
            })
            ->exists();

        if (!$hasBought) {
            return response()->json(['success' => false, 'message' => 'Bạn chỉ được đánh giá sản phẩm này sau khi đã mua hàng thành công.'], 403);
        }

        // Kiểm tra xem người dùng đã đánh giá sản phẩm này cho đơn hàng này chưa
        $alreadyReviewed = Comment::where('user_id', $user->id_nd)
            ->where('sanpham_id', $request->sanpham_id)
            ->where('id_dathang', $request->id_dathang)
            ->exists();

        if ($alreadyReviewed) {
            return response()->json(['success' => false, 'message' => 'Bạn đã đánh giá sản phẩm này cho đơn hàng này rồi.'], 400);
        }

        // Kiểm tra nếu cần reCAPTCHA
        if ($request->has('g-recaptcha-response')) {
            $recaptchaResponse = $request->input('g-recaptcha-response');
            $googleResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => env('RECAPTCHA_SECRET_KEY'),
                'response' => $recaptchaResponse,
                'remoteip' => $request->ip(),
            ]);

            $result = $googleResponse->json();
            if (!($result['success'] ?? false)) {
                return response()->json(['success' => false, 'message' => 'Xác minh CAPTCHA không hợp lệ'], 422);
            }
        }
        
        // Kiểm tra từ ngữ thô tục
        if ($this->containsBadWords($request->content)) {
            return response()->json(['success' => false, 'message' => 'Vi phạm ngôn ngữ cộng đồng'], 422);
        }

        // Xử lý tệp đính kèm
        $attachments = [];
        if ($request->hasFile('attachments')) {
            $destination = public_path('frontend/upload');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            foreach ($request->file('attachments') as $file) {
                if ($file->isValid()) {
                    $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move($destination, $imageName);
                    $attachments[] = 'frontend/upload/' . $imageName;
                }
            }
        }

        $comment = Comment::create([
            'user_id' => Auth::user()->id_nd,
            'sanpham_id' => $request->sanpham_id,
            'id_dathang' => $request->id_dathang,
            'content' => $request->content ?? '',
            'rating' => (int)$request->rating,
            'images' => !empty($attachments) ? $attachments : null,
        ]);

        $comment->load('user');

        return response()->json(['success' => true, 'comment' => $comment]);
    }

    // Sửa comment
    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'nullable|string|max:1000',
        ]);

        $comment = Comment::findOrFail($id);

        if ($comment->user_id != Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Không có quyền sửa bình luận này.'], 403);
        }

        // Kiểm tra từ ngữ thô tục
        if ($this->containsBadWords($request->content)) {
            return response()->json(['success' => false, 'message' => 'Vi phạm ngôn ngữ cộng đồng'], 422);
        }

        $comment->content = $request->content ?? '';
        $comment->save();

        return response()->json(['success' => true, 'comment' => $comment]);
    }

    // Xóa comment
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id != Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Không có quyền xóa bình luận này.'], 403);
        }

        $comment->delete();

        return response()->json(['success' => true]);
    }

    // [ADMIN] Lấy toàn bộ danh sách comment phục vụ kiểm duyệt
    public function adminIndex(Request $request)
    {
        $comments = Comment::with(['user', 'sanpham'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.comments.index', compact('comments'));
    }

    // [ADMIN] Xóa comment của khách hàng
    public function adminDestroy($id)
    {
        $comment = Comment::findOrFail($id);

        // Xóa các file ảnh/video đính kèm vật lý
        if (!empty($comment->images)) {
            foreach ($comment->images as $path) {
                $filePath = public_path($path);
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
            }
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Xóa đánh giá của khách hàng thành công!');
    }
}
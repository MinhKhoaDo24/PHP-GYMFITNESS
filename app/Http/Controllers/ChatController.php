<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    protected $telegramService;

    public function __construct(TelegramService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    /**
     * Lấy danh sách cuộc chat
     */
    public function getConversations()
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            if ($user->id_phanquyen == 2) { // Khách hàng
                $conversations = Conversation::where('customer_id', $user->id_nd)
                    ->with(['staff', 'lastMessage'])
                    ->orderByDesc('updated_at')
                    ->get();
            } else { // Nhân viên/Admin
                $conversations = Conversation::where('staff_id', $user->id_nd)
                    ->orWhereNull('staff_id')
                    ->with(['customer', 'lastMessage'])
                    ->orderByDesc('updated_at')
                    ->get();
            }

            return response()->json($conversations);
        } catch (\Exception $e) {
            \Log::error('Chat Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Tạo cuộc chat hoặc lấy cuộc chat hiện tại
     */
    public function startConversation(Request $request)
    {
        $user = Auth::user();

        if ($user->id_phanquyen != 2) {
            return response()->json(['error' => 'Chỉ khách hàng mới có thể tạo cuộc chat'], 403);
        }

        // Kiểm tra đã có cuộc chat active nào chưa
        $conversation = Conversation::where('customer_id', $user->id_nd)
            ->where('status', '!=', 'closed')
            ->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'customer_id' => $user->id_nd,
                'status' => 'waiting'
            ]);
        }

        return response()->json($conversation);
    }

    /**
     * Lấy tin nhắn của cuộc chat
     */
    public function getMessages($conversationId)
    {
        $conversation = Conversation::findOrFail($conversationId);
        $user = Auth::user();

        // Kiểm tra quyền: khách hàng, staff được assign, hoặc admin
        $isAdmin    = $user->id_phanquyen == 1;
        $isCustomer = (int)$conversation->customer_id === (int)$user->id_nd;
        $isStaff    = $conversation->staff_id !== null && (int)$conversation->staff_id === (int)$user->id_nd;

        if (!$isCustomer && !$isStaff && !$isAdmin) {
            return response()->json(['error' => 'Không có quyền'], 403);
        }

        $messages = Message::where('conversation_id', $conversationId)
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        // Đánh dấu đã đọc
        Message::where('conversation_id', $conversationId)
            ->where('sender_id', '!=', $user->id_nd)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json($messages);
    }

    /**
     * Gửi tin nhắn
     */
    public function sendMessage(Request $request, $conversationId)
    {
        $request->validate([
            'content' => 'required|string|max:2000'
        ]);

        $conversation = Conversation::findOrFail($conversationId);
        $sender = Auth::user();

        // Kiểm tra quyền:
        // - Khách hàng chỉ được gửi trong conversation của mình
        // - Nhân viên/Admin được gửi trong bất kỳ conversation nào chưa có staff (waiting) hoặc đã được assign cho họ
        $isAdmin   = $sender->id_phanquyen == 1;
        $isCustomer = (int)$conversation->customer_id === (int)$sender->id_nd;
        $isStaff   = $conversation->staff_id !== null && (int)$conversation->staff_id === (int)$sender->id_nd;

        if (!$isCustomer && !$isStaff && !$isAdmin) {
            return response()->json(['error' => 'Không có quyền'], 403);
        }

        // Lưu tin nhắn
        $message = Message::create([
            'conversation_id' => $conversationId,
            'sender_id' => $sender->id_nd,
            'content' => $request->content,
            'attachment_url' => $request->attachment_url ?? null
        ]);

        // Nếu là khách hàng gửi → gửi thông báo Telegram cho staff
        if ($sender->id_phanquyen == 2) {
            try {
                $this->telegramService->notifyAdminNewMessage(
                    $conversationId,
                    $sender->hoten,
                    $sender->sdt,
                    $request->content,
                    $sender->email
                );
            } catch (\Exception $e) {
                \Log::warning('Failed to send Telegram: ' . $e->getMessage());
            }
        }
        // Nếu là nhân viên gửi → gửi thông báo Telegram
        else {
            try {
                $this->telegramService->notifyAdminReply(
                    $conversationId,
                    $sender->hoten,
                    $request->content
                );
            } catch (\Exception $e) {
                \Log::warning('Failed to send Telegram: ' . $e->getMessage());
            }
        }

        $message->load('sender');
        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    /**
     * Admin nhận cuộc chat (gán staff cho conversation)
     */
    public function acceptConversation($conversationId)
    {
        $conversation = Conversation::findOrFail($conversationId);
        $user = Auth::user();

        if (!($user->id_phanquyen == 1)) {
            return response()->json(['error' => 'Không có quyền'], 403);
        }

        $conversation->update([
            'staff_id' => $user->id_nd,
            'status' => 'active'
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Đóng cuộc chat
     */
    public function closeConversation($conversationId)
    {
        $conversation = Conversation::findOrFail($conversationId);
        $user = Auth::user();

        if ($conversation->customer_id != $user->id_nd && $conversation->staff_id != $user->id_nd) {
            return response()->json(['error' => 'Không có quyền'], 403);
        }

        $conversation->update(['status' => 'closed']);

        return response()->json(['success' => true]);
    }
}

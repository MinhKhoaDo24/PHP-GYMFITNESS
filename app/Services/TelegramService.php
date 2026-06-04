<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class TelegramService
{
    protected $botToken;
    protected $chatId;
    protected $apiEndpoint = 'https://api.telegram.org/bot';

    public function __construct()
    {
        $this->botToken = env('TELEGRAM_BOT_TOKEN');
        $this->chatId   = env('TELEGRAM_CHAT_ID');
    }

    /**
     * Escape ký tự đặc biệt HTML để tránh vỡ parse_mode HTML của Telegram
     */
    private function escapeHtml(string $text): string
    {
        return htmlspecialchars($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * Gửi tin nhắn text đến Telegram (có inline keyboard nếu truyền vào)
     */
    public function sendMessage($message, $parseMode = 'HTML', $replyMarkup = null)
    {
        try {
            $url = $this->apiEndpoint . $this->botToken . '/sendMessage';

            $payload = [
                'chat_id'    => $this->chatId,
                'text'       => $message,
                'parse_mode' => $parseMode,
            ];

            if ($replyMarkup) {
                $payload['reply_markup'] = json_encode($replyMarkup);
            }

            $response = Http::post($url, $payload);

            if (!$response->successful()) {
                throw new Exception('Telegram API Error: ' . $response->body());
            }

            return $response->json();
        } catch (Exception $e) {
            \Log::error('Telegram Error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Gửi thông báo tin nhắn mới từ khách hàng tới admin
     */
    public function notifyAdminNewMessage($conversationId, $customerName, $customerPhone, $message, $customerEmail)
    {
        // Escape nội dung người dùng để tránh vỡ HTML
        $safeName    = $this->escapeHtml($customerName);
        $safeEmail   = $this->escapeHtml($customerEmail);
        $safePhone   = $this->escapeHtml((string) $customerPhone);
        $safeMessage = $this->escapeHtml($message);

        $text  = "📨 <b>TIN NHẮN MỚI TỪ KHÁCH HÀNG</b>\n\n";
        $text .= "👤 <b>Tên:</b> {$safeName}\n";
        $text .= "📧 <b>Email:</b> {$safeEmail}\n";
        $text .= "📞 <b>SĐT:</b> {$safePhone}\n";
        $text .= "💬 <b>Nội dung:</b>\n";
        $text .= "<pre>{$safeMessage}</pre>\n\n";
        $text .= "✍️ <b>Trả lời:</b> gõ lệnh vào bot:\n";
        $text .= "<code>/reply_{$conversationId} Nội dung trả lời...</code>";

        return $this->sendMessage($text);
    }

    /**
     * Gửi thông báo nhân viên vừa trả lời
     */
    public function notifyAdminReply($conversationId, $staffName, $message)
    {
        $safeName    = $this->escapeHtml($staffName);
        $safeMessage = $this->escapeHtml($message);

        $text  = "✉️ <b>NHÂN VIÊN</b> <code>{$safeName}</code> <b>VỪA TRẢ LỜI</b>\n\n";
        $text .= "<pre>{$safeMessage}</pre>";

        return $this->sendMessage($text, 'HTML');
    }

    /**
     * Gửi tin nhắn trả lời từ Telegram về lại cho khách hàng
     * Được gọi khi admin dùng lệnh /reply_{conversationId} [nội dung]
     */
    public function sendReplyToConversation(int $conversationId, string $content, int $staffId): bool
    {
        try {
            $conversation = \App\Models\Conversation::find($conversationId);
            if (!$conversation) return false;

            \App\Models\Message::create([
                'conversation_id' => $conversationId,
                'sender_id'       => $staffId,
                'content'         => $content,
            ]);

            // Cập nhật trạng thái conversation nếu cần
            if ($conversation->status === 'waiting') {
                $conversation->update([
                    'staff_id' => $staffId,
                    'status'   => 'active',
                ]);
            }

            return true;
        } catch (Exception $e) {
            \Log::error('Telegram Reply Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Xử lý webhook update từ Telegram (lệnh /reply từ admin)
     */
    public function handleWebhook(array $update): void
    {
        $text = $update['message']['text'] ?? '';

        // Nhận diện lệnh /reply_{id} nội_dung
        if (preg_match('/^\/reply_(\d+)\s+(.+)$/su', $text, $matches)) {
            $conversationId = (int) $matches[1];
            $replyContent   = trim($matches[2]);

            // Lấy admin đầu tiên làm staff mặc định
            $admin = \App\Models\NguoiDung::where('id_phanquyen', 1)->first();
            if (!$admin) {
                $this->sendMessage("❌ Không tìm thấy tài khoản admin để gửi.");
                return;
            }

            $ok = $this->sendReplyToConversation($conversationId, $replyContent, $admin->id_nd);

            if ($ok) {
                $safeName    = $this->escapeHtml($admin->hoten);
                $safeContent = $this->escapeHtml($replyContent);
                $this->sendMessage("✅ <b>{$safeName}</b> đã trả lời cuộc chat #{$conversationId}:\n<pre>{$safeContent}</pre>");
            } else {
                $this->sendMessage("❌ Gửi thất bại. Cuộc chat #{$conversationId} không tồn tại.");
            }
        }
    }
}

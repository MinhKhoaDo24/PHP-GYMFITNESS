@auth
<!-- Chat Bubble -->
<div id="chatBubble" class="chat-bubble" onclick="toggleChatWindow()">
    <i class="fas fa-comments"></i>
    <span id="unreadCount" class="unread-badge" style="display: none;">0</span>
</div>

<!-- Chat Window Modal -->
<div id="chatWindow" class="chat-window">
    <div class="chat-window-header">
        <h5 class="mb-0"><i class="fas fa-headset" style="margin-right:8px;"></i>Hỗ trợ khách hàng</h5>
        <button class="btn-close" onclick="toggleChatWindow()"></button>
    </div>

    <div class="chat-window-body">
        <!-- Loading state -->
        <div id="chatLoading" style="display:flex; align-items:center; justify-content:center; flex:1;">
            <div class="text-center" style="color:#999;">
                <div class="spinner-border spinner-border-sm text-primary mb-2" role="status"></div>
                <p style="font-size:13px; margin:0;">Đang kết nối...</p>
            </div>
        </div>

        <!-- Chat container -->
        <div id="chatContainer" class="chat-container" style="display: none;">
            <div class="chat-messages" id="messagesContainer"></div>
            <form id="sendForm" class="chat-form">
                <textarea id="messageInput" placeholder="Nhập tin nhắn... (Enter để gửi)" rows="1" required></textarea>
                <button type="submit" class="btn-send">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<style>
/* ─── Chat Bubble ─────────────────────────────────────── */
.chat-bubble {
    position: fixed;
    bottom: 20px;
    left: 20px;
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
    z-index: 999;
}

.chat-bubble:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
}

.chat-bubble i {
    color: white;
    font-size: 24px;
}

.unread-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #ff4757;
    color: white;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: bold;
    border: 2px solid white;
}

/* ─── Chat Window ─────────────────────────────────────── */
.chat-window {
    position: fixed;
    bottom: 90px;
    left: 20px;
    width: 380px;
    height: 600px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 5px 40px rgba(0, 0, 0, 0.16);
    display: none;
    flex-direction: column;
    z-index: 999;
    animation: slideUp 0.3s ease;
}

.chat-window.active {
    display: flex;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Header */
.chat-window-header {
    padding: 15px 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px 12px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.chat-window-header .btn-close {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    border-radius: 4px;
    transition: background 0.2s;
}

.chat-window-header .btn-close:hover {
    background: rgba(255, 255, 255, 0.3);
}

/* Body */
.chat-window-body {
    flex: 1;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

/* Conversations List */
.conversations-list {
    flex: 1;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
}

.conversation-item {
    padding: 12px 15px;
    border-bottom: 1px solid #e9ecef;
    cursor: pointer;
    transition: background 0.2s;
}

.conversation-item:hover {
    background: #f8f9fa;
}

.conversation-item.active {
    background: #e7f3ff;
    border-left: 4px solid #667eea;
}

.conversation-item-name {
    font-weight: 600;
    color: #333;
    font-size: 14px;
}

.conversation-item-message {
    font-size: 12px;
    color: #999;
    margin-top: 4px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.conversation-item-time {
    font-size: 11px;
    color: #bbb;
}

/* Chat Container */
.chat-container {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    min-height: 0;
}

/* Messages */
.chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 15px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    min-height: 0;
}

.message {
    display: flex;
    gap: 8px;
    animation: fadeIn 0.3s ease;
}

.message.own {
    justify-content: flex-end;
}

.message.other {
    justify-content: flex-start;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Wrapper bao ngoài bubble, giới hạn max-width đúng cách */
.message-content {
    max-width: 70%;
    display: flex;
    flex-direction: column;
}

.message.own .message-content {
    align-items: flex-end;
}

.message.other .message-content {
    align-items: flex-start;
}

.message-bubble {
    padding: 10px 12px;
    border-radius: 10px;
    font-size: 13px;
    line-height: 1.5;
    word-wrap: break-word;
    word-break: break-word;
    white-space: pre-wrap;
}

.message.other .message-bubble {
    background: #e9ecef;
    color: #333;
    border-radius: 4px 12px 12px 12px;
}

.message.own .message-bubble {
    background: #667eea;
    color: white;
    border-radius: 12px 4px 12px 12px;
}

.message-time {
    font-size: 11px;
    color: #999;
    margin-top: 4px;
}

/* Form */
.chat-form {
    padding: 12px 15px;
    border-top: 1px solid #e9ecef;
    display: flex;
    gap: 8px;
}

.chat-form textarea {
    flex: 1;
    border: 1px solid #ddd;
    border-radius: 6px;
    padding: 8px 10px;
    font-size: 13px;
    font-family: inherit;
    resize: none;
    transition: border-color 0.2s;
}

.chat-form textarea:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.btn-send {
    background: #667eea;
    color: white;
    border: none;
    border-radius: 6px;
    width: 36px;
    height: 36px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s;
}

.btn-send:hover {
    background: #764ba2;
}

/* Responsive */
@media (max-width: 480px) {
    .chat-window {
        width: calc(100% - 40px);
        height: 500px;
        bottom: 80px;
        left: 20px;
        right: auto;
    }
    .message-content {
        max-width: 85%;
    }
}
</style>

<script>
const currentUserId = {{ Auth::user()->id_nd }};
const isCustomer = {{ Auth::user()->id_phanquyen == 2 ? 'true' : 'false' }};
let selectedConvId = null;
let refreshInterval = null;

console.log('Chat initialized:', { currentUserId, isCustomer });

// Toggle chat window — vào thẳng chat, không qua danh sách
function toggleChatWindow() {
    const win = document.getElementById('chatWindow');
    win.classList.toggle('active');
    if (win.classList.contains('active') && !selectedConvId) {
        openChatDirectly();
    }
}

// Mở chat trực tiếp: tự động start/load conversation
function openChatDirectly() {
    showLoading(true);

    fetch('/chat/start', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
        },
        credentials: 'same-origin'
    })
    .then(r => r.json())
    .then(data => {
        if (data.id) {
            selectedConvId = data.id;
            showLoading(false);
            document.getElementById('chatContainer').style.display = 'flex';

            loadMessages();
            clearInterval(refreshInterval);
            refreshInterval = setInterval(loadMessages, 3000);

            document.getElementById('sendForm').onsubmit = sendMessage;
            const textarea = document.getElementById('messageInput');
            textarea.onkeydown = function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    document.getElementById('sendForm').dispatchEvent(new Event('submit'));
                }
            };
            setTimeout(() => textarea.focus(), 100);
        } else {
            showError(data.error || 'Không thể kết nối. Vui lòng thử lại.');
        }
    })
    .catch(err => {
        console.error('openChatDirectly error:', err);
        showError('Không thể kết nối. Vui lòng thử lại.');
    });
}

function showLoading(show) {
    const loading = document.getElementById('chatLoading');
    const container = document.getElementById('chatContainer');
    if (loading) loading.style.display = show ? 'flex' : 'none';
    if (!show) container.style.display = 'flex';
}

function showError(msg) {
    const loading = document.getElementById('chatLoading');
    if (loading) loading.innerHTML = `
        <div class="text-center" style="color:#d32f2f; padding:20px;">
            <i class="fas fa-exclamation-circle" style="font-size:32px; margin-bottom:10px;"></i>
            <p style="font-size:13px;">${msg}</p>
            <button onclick="openChatDirectly()" style="background:#667eea;color:white;border:none;padding:6px 14px;border-radius:6px;cursor:pointer;font-size:13px;margin-top:8px;">Thử lại</button>
        </div>
    `;
}

// Load danh sách cuộc chat — KHÔNG dùng nữa (giữ lại để tránh JS error nếu có chỗ gọi)
function loadConversationsList() { /* deprecated */ }
function startNewChat() { openChatDirectly(); }
function backToList() { /* deprecated */ }

// Load tin nhắn
function loadMessages() {
    if (!selectedConvId) return;
    fetch(`/chat/${selectedConvId}/messages`, {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
        },
        credentials: 'same-origin'
    })
    .then(r => r.json())
    .then(messages => {
        const container = document.getElementById('messagesContainer');
        container.innerHTML = '';

        messages.forEach(msg => {
            const isOwn = msg.sender_id === currentUserId;
            const time = new Date(msg.created_at).toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' });
            
            const html = `
                <div class="message ${isOwn ? 'own' : 'other'}">
                    <div class="message-content">
                        <div class="message-bubble">${msg.content}</div>
                        <div class="message-time">${time}</div>
                    </div>
                </div>
            `;
            container.innerHTML += html;
        });

        container.scrollTop = container.scrollHeight;
    })
    .catch(err => console.warn('loadMessages error:', err));
}

// Gửi tin nhắn
function sendMessage(e) {
    e.preventDefault();
    const input = document.getElementById('messageInput');
    const content = input.value.trim();

    if (!content) return;

    // Hiển thị ngay lập tức (optimistic UI)
    input.value = '';

    fetch(`/chat/${selectedConvId}/send`, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
        },
        credentials: 'same-origin',
        body: JSON.stringify({ content })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            loadMessages();
        } else {
            console.error('Send error:', data);
        }
    })
    .catch(err => console.error('sendMessage error:', err));
}
</script>
@endauth

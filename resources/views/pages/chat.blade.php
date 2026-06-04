@extends('layout')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-comments"></i> Hỗ trợ khách hàng
                    </h4>
                </div>

                <div class="card-body p-0">
                    <div class="row g-0" style="height: 600px;">
                        <!-- Danh sách cuộc chat -->
                        <div class="col-md-3 border-end" style="overflow-y: auto;">
                            <div id="conversationsList" class="list-group">
                                <div class="text-center p-4">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Đang tải...</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Chi tiết cuộc chat -->
                        <div class="col-md-9 d-flex flex-column" id="chatPanel">
                            <div class="p-4 text-center text-muted flex-grow-1 d-flex align-items-center justify-content-center">
                                <div>
                                    <i class="fas fa-comments" style="font-size: 48px; color: #ccc;"></i>
                                    <p class="mt-3">Chọn cuộc chat để bắt đầu</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Template hiển thị cuộc chat -->
<template id="chatTemplate">
    <div class="d-flex flex-column" style="height: 100%; overflow-y: hidden;">
        <!-- Header -->
        <div class="p-3 border-bottom bg-light d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0" id="chatTitle">Chat</h5>
                <small class="text-muted" id="chatStatus">Đang hoạt động</small>
            </div>
            <button class="btn btn-sm btn-outline-danger" id="closeBtn">
                <i class="fas fa-times"></i> Đóng
            </button>
        </div>

        <!-- Tin nhắn -->
        <div id="messagesContainer" style="flex: 1; overflow-y: auto; padding: 15px;">
            <!-- Tin nhắn sẽ hiển thị ở đây -->
        </div>

        <!-- Input -->
        <div class="border-top p-3">
            <form id="sendMessageForm" class="d-flex gap-2">
                <textarea 
                    id="messageInput" 
                    class="form-control" 
                    placeholder="Nhập tin nhắn..." 
                    rows="2"
                    required
                ></textarea>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
</template>

<!-- Template tin nhắn -->
<template id="messageTemplate">
    <div class="d-flex mb-3" id="message-__ID__">
        <div style="flex: 1;">
            <div style="
                background: __BG__;
                color: __TEXT__;
                padding: 10px 15px;
                border-radius: 10px;
                max-width: 70%;
                margin-left: __MARGIN__;
            ">
                <small style="opacity: 0.7;">__SENDER__</small>
                <p class="mb-0">__CONTENT__</p>
                <small style="opacity: 0.6;">__TIME__</small>
            </div>
        </div>
    </div>
</template>

<script>
const currentUserId = {{ Auth::user()->id_nd }};
const isCustomer = {{ Auth::user()->id_phanquyen == 2 ? 'true' : 'false' }};
let selectedConversationId = null;
let messageRefreshInterval = null;

// Load danh sách cuộc chat
function loadConversations() {
    fetch('/chat', {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
        },
        credentials: 'same-origin'
    })
    .then(r => r.json())
    .then(data => {
        const list = document.getElementById('conversationsList');
        list.innerHTML = '';

        if (data.length === 0) {
            list.innerHTML = '<div class="p-3 text-center text-muted">Không có cuộc chat nào</div>';
            return;
        }

        data.forEach(conv => {
            const customerName = isCustomer ? (conv.staff?.hoten || 'Chưa có staff') : conv.customer?.hoten;
            const lastMsg = conv.last_message?.content?.substring(0, 30) || 'Không có tin nhắn';
            const statusColor = conv.status === 'active' ? '#10b981' : conv.status === 'waiting' ? '#f59e0b' : '#6b7280';

            const html = `
                <div class="list-group-item p-3 border-bottom cursor-pointer" 
                     onclick="selectConversation(${conv.id})"
                     style="background: ${selectedConversationId === conv.id ? '#e9ecef' : 'white'}">
                    <div class="d-flex justify-content-between">
                        <strong>${customerName}</strong>
                        <small style="color: ${statusColor};">&#9679;</small>
                    </div>
                    <small class="text-muted">${lastMsg}...</small>
                </div>
            `;
            list.innerHTML += html;
        });
    })
    .catch(err => console.error('loadConversations error:', err));
}

// Chọn cuộc chat
function selectConversation(id) {
    selectedConversationId = id;
    const panel = document.getElementById('chatPanel');
    const template = document.getElementById('chatTemplate');
    panel.innerHTML = template.innerHTML;

    loadMessages();
    clearInterval(messageRefreshInterval);
    messageRefreshInterval = setInterval(loadMessages, 2000);

    // Event listeners
    document.getElementById('sendMessageForm').onsubmit = sendMessage;
    document.getElementById('closeBtn').onclick = () => {
        closeConversation();
    };
}

// Load tin nhắn
function loadMessages() {
    fetch(`/chat/${selectedConversationId}/messages`, {
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
            const template = document.getElementById('messageTemplate').innerHTML;
            const time = new Date(msg.created_at).toLocaleTimeString('vi-VN');
            
            const html = template
                .replace(/__ID__/g, msg.id)
                .replace(/__BG__/g, isOwn ? '#007bff' : '#e9ecef')
                .replace(/__TEXT__/g, isOwn ? 'white' : 'black')
                .replace(/__MARGIN__/g, isOwn ? 'auto' : '0')
                .replace(/__SENDER__/g, msg.sender?.hoten || 'Ẩn danh')
                .replace(/__CONTENT__/g, msg.content)
                .replace(/__TIME__/g, time);

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

    fetch(`/chat/${selectedConversationId}/send`, {
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
            input.value = '';
            loadMessages();
        }
    })
    .catch(err => console.error('sendMessage error:', err));
}

// Đóng cuộc chat
function closeConversation() {
    fetch(`/chat/${selectedConversationId}/close`, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
        },
        credentials: 'same-origin'
    })
    .then(() => {
        selectedConversationId = null;
        loadConversations();
        document.getElementById('chatPanel').innerHTML = `
            <div class="text-center text-muted flex-grow-1 d-flex align-items-center justify-content-center">
                <div>
                    <i class="fas fa-comments" style="font-size: 48px; color: #ccc;"></i>
                    <p class="mt-3">Cuộc chat đã đóng</p>
                </div>
            </div>
        `;
    });
}

// Khởi tạo
loadConversations();
setInterval(loadConversations, 5000);
</script>

<style>
.cursor-pointer { cursor: pointer; }
</style>
@endsection

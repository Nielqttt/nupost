@extends('layouts.requestor')

@section('title', 'Comments')

@section('head-styles')
<style>
    .main { max-width: 700px; margin: 0 auto; padding: 28px 24px; }
    
    .back-btn { 
        display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; 
        background: white; border: 1px solid var(--color-border); border-radius: 8px; 
        font-size: 13px; font-weight: 500; color: var(--color-text-muted); 
        text-decoration: none; transition: background .15s; margin-bottom: 20px; 
    }
    .back-btn:hover { background: var(--color-bg); }

    .chat-card { 
        background: white; border-radius: 16px; box-shadow: var(--shadow-md); 
        overflow: hidden; display: flex; flex-direction: column; height: 600px; 
    }

    /* BLUE GRADIENT HEADER */
    .chat-header { 
        padding: 20px 24px; 
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); 
        color: white; display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-shrink: 0; 
    }
    .header-info-group { display: flex; flex-direction: column; gap: 2px; }
    .chat-header-title { font-size: 15px; font-weight: 700; letter-spacing: -0.01em; }
    .chat-header-sub { font-size: 11px; opacity: 0.85; font-weight: 400; }
    
    /* STATUS BADGE INSIDE HEADER */
    .header-badge {
        padding: 4px 12px; border-radius: 20px; font-size: 10px; font-weight: 700; 
        text-transform: uppercase; background: rgba(255, 255, 255, 0.2); 
        backdrop-filter: blur(4px); color: white; border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .chat-messages { flex: 1; overflow-y: auto; padding: 20px 18px; display: flex; flex-direction: column; gap: 14px; background: #f8faff; }
    .chat-messages::-webkit-scrollbar { width: 4px; }
    .chat-messages::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }

    .chat-bubble-row { display: flex; align-items: flex-end; gap: 8px; }
    .chat-bubble-row--me { flex-direction: row-reverse; }
    
    .chat-avatar { width: 32px; height: 32px; border-radius: 50%; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; color: white; }
    .chat-avatar--me { background: #7c3aed; }
    .chat-avatar--admin { background: #1e3a8a; }

    .chat-bubble { max-width: 75%; padding: 12px 16px; border-radius: 18px; font-size: 13.5px; line-height: 1.5; word-break: break-word; position: relative; }
    .chat-bubble--me { background: #7c3aed; color: white; border-bottom-right-radius: 4px; }
    .chat-bubble--admin { background: white; color: var(--color-text); border: 1px solid var(--color-border); border-bottom-left-radius: 4px; }

    .chat-meta { font-size: 10px; margin-top: 6px; opacity: 0.7; }
    .chat-bubble--me .chat-meta { text-align: right; color: rgba(255,255,255,0.9); }
    .chat-bubble--admin .chat-meta { color: #9ca3af; }

    .chat-empty { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px; color: #9ca3af; }
    
    .chat-input-area { border-top: 1px solid var(--color-border); padding: 16px; background: white; display: flex; gap: 12px; align-items: flex-end; }
    .chat-input { flex: 1; border: 1.5px solid #e5e7eb; border-radius: 12px; padding: 12px 16px; font-size: 13.5px; outline: none; transition: all .2s; min-height: 46px; max-height: 120px; }
    .chat-input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
    
    .chat-send-btn { width: 46px; height: 46px; background: #1e3a8a; color: white; border: none; border-radius: 12px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: transform 0.1s; }
    .chat-send-btn:active { transform: scale(0.95); }
    .chat-send-btn:hover { background: #1e40af; }
</style>
@endsection

@section('content')
<main class="main">
    <a href="{{ route('requestor.requests') }}" class="back-btn">
        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        Back to Requests
    </a>

    <div class="chat-card">
        {{-- HEADER WITH GRADIENT AND REQUEST TITLE --}}
        <div class="chat-header">
            <div class="header-info-group">
                <div class="chat-header-title">{{ $req->title }}</div>
                <div class="chat-header-sub">ID: {{ $req->request_id ?? 'REQ-' . $req->id }} &bull; Internal Comments</div>
            </div>
            <div class="header-badge">
                {{ $req->status }}
            </div>
        </div>

        <div class="chat-messages" id="chat-messages">
            @forelse($chat_messages as $msg)
                @php $is_me = $msg->sender_role === 'requestor'; @endphp
                <div class="chat-bubble-row {{ $is_me ? 'chat-bubble-row--me' : '' }}">
                    <div class="chat-avatar {{ $is_me ? 'chat-avatar--me' : 'chat-avatar--admin' }}">
                        {{ strtoupper(substr($msg->sender_name, 0, 1)) }}
                    </div>
                    <div class="chat-bubble {{ $is_me ? 'chat-bubble--me' : 'chat-bubble--admin' }}">
                        {!! nl2br(e($msg->message)) !!}
                        <div class="chat-meta">
                            {{ $is_me ? 'You' : 'Admin' }} &middot; {{ $msg->created_at->format('M j, g:i A') }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="chat-empty">
                    <svg width="40" height="40" fill="none" stroke="#d1d5db" stroke-width="1.5" viewBox="0 0 24 24">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                    <p style="font-size: 14px;">No messages yet. Send a query to admin.</p>
                </div>
            @endforelse
        </div>

        <form method="POST" action="{{ route('requestor.requests.chat.send', $req->id) }}" class="chat-input-area" id="chat-form">
            @csrf
            <textarea class="chat-input" name="chat_message" id="chat-input"
                      placeholder="Type your message here..."
                      rows="1"
                      onkeydown="handleChatKey(event)"></textarea>
            <button type="submit" class="chat-send-btn">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
            </button>
        </form>
    </div>
</main>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const chatBox = document.getElementById('chat-messages');
        if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;
    });

    function handleChatKey(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            const val = document.getElementById('chat-input').value.trim();
            if (val) document.getElementById('chat-form').submit();
        }
    }
</script>
@endsection
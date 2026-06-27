@extends('layouts.app')

@section('title', 'Chat with ' . $user->name)

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden flex flex-col" style="height: calc(100vh - 180px); min-height: 500px;">
        <!-- Chat Header -->
        <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
            <a href="{{ route('chat.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>

            <!-- Avatar -->
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-semibold">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>

            <div class="flex-1">
                <h2 class="font-semibold text-gray-900 dark:text-white">{{ $user->name }}</h2>
                @if($booking)
                    <p class="text-xs text-gray-500 dark:text-gray-400">Booking: {{ $booking->booking_code }}</p>
                @else
                    <p class="text-xs text-green-500">Online</p>
                @endif
            </div>

            <div class="flex items-center gap-2">
                @if($user->phone)
                    <span class="text-xs text-gray-400 dark:text-gray-500 hidden sm:inline">{{ $user->phone }}</span>
                @endif
            </div>
        </div>

        <!-- Messages Area -->
        <div id="chat-messages" class="flex-1 overflow-y-auto px-4 py-4 space-y-3 bg-gray-50 dark:bg-gray-900/50">
            @foreach($messages as $msg)
                @if($msg->sender_id === auth()->id())
                    <!-- Sent Message (Right - Blue) -->
                    <div class="flex justify-end">
                        <div class="max-w-[75%]">
                            <div class="bg-primary-500 text-white rounded-2xl rounded-br-sm px-4 py-2.5 shadow-sm">
                                <p class="text-sm whitespace-pre-wrap break-words">{{ $msg->message }}</p>
                            </div>
                            <div class="flex items-center justify-end gap-1 mt-1">
                                <span class="text-[11px] text-gray-400">{{ $msg->created_at->format('H:i') }}</span>
                                @if($msg->sent_via === 'whatsapp')
                                    <svg class="w-3 h-3 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Received Message (Left - Gray) -->
                    <div class="flex justify-start">
                        <div class="max-w-[75%] flex gap-2">
                            <div class="w-8 h-8 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center text-gray-600 dark:text-gray-300 text-xs font-semibold flex-shrink-0">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-2xl rounded-bl-sm px-4 py-2.5 shadow-sm">
                                    <p class="text-sm whitespace-pre-wrap break-words">{{ $msg->message }}</p>
                                </div>
                                <span class="text-[11px] text-gray-400 ml-1 mt-1 block">{{ $msg->created_at->format('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

            @if($messages->isEmpty())
                <div class="flex flex-col items-center justify-center h-full text-center py-12">
                    <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-3">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">No messages yet. Say hello!</p>
                </div>
            @endif
        </div>

        <!-- Message Input -->
        <div class="border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-3">
            <form id="message-form" action="{{ route('chat.store') }}" method="POST" class="flex items-end gap-3">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $user->id }}">
                @if($booking)
                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                @endif

                <!-- Send via selector -->
                <div class="flex items-center gap-1">
                    <label class="flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400 cursor-pointer select-none">
                        <input type="radio" name="send_via" value="in_app" checked class="w-3 h-3 text-primary-500">
                        In-App
                    </label>
                    <label class="flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400 cursor-pointer select-none">
                        <input type="radio" name="send_via" value="whatsapp" class="w-3 h-3 text-green-500">
                        <svg class="w-3 h-3 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                    </label>
                </div>

                <!-- Text Input -->
                <div class="flex-1 relative">
                    <textarea
                        name="message"
                        id="message-input"
                        rows="1"
                        placeholder="Type a message..."
                        class="w-full px-4 py-2.5 bg-gray-100 dark:bg-gray-700 border-0 rounded-full resize-none text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500/50 transition-all"
                        style="max-height: 120px; min-height: 42px;"
                        oninput="this.style.height = ''; this.style.height = Math.min(this.scrollHeight, 120) + 'px'"
                        @keydown.enter.prevent="if (!$event.shiftKey) sendMessage()"
                    ></textarea>
                </div>

                <!-- Send Button -->
                <button
                    type="submit"
                    id="send-btn"
                    class="w-10 h-10 bg-primary-500 hover:bg-primary-600 text-white rounded-full flex items-center justify-center flex-shrink-0 transition-colors shadow-sm"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const messagesContainer = document.getElementById('chat-messages');
    const messageForm = document.getElementById('message-form');
    const messageInput = document.getElementById('message-input');
    const sendBtn = document.getElementById('send-btn');

    // Auto-scroll to bottom
    function scrollToBottom() {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    // Initial scroll
    scrollToBottom();

    // Send message function
    function sendMessage() {
        const message = messageInput.value.trim();
        if (!message) return;

        const formData = new FormData(messageForm);

        // Add loading state
        sendBtn.disabled = true;
        sendBtn.classList.add('opacity-50');

        fetch('{{ route("chat.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reset input
                messageInput.value = '';
                messageInput.style.height = '';

                // Reload the page to show the new message (since we need relationship data)
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Fallback to form submit
            messageForm.submit();
        })
        .finally(() => {
            sendBtn.disabled = false;
            sendBtn.classList.remove('opacity-50');
        });
    }

    // Form submit handler
    messageForm.addEventListener('submit', function(e) {
        e.preventDefault();
        sendMessage();
    });

    // Auto-focus input
    messageInput.focus();
</script>
@endpush

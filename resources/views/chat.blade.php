<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $chatTitle }} | LearnLoop</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .glass-effect { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        /* Kustomisasi scrollbar biar estetik */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-slate-50 h-screen flex justify-center overflow-hidden">

    <div class="w-full max-w-3xl bg-white shadow-xl flex flex-col h-full border-x border-slate-200">
        
        <header class="glass-effect border-b border-slate-200 px-6 py-4 flex items-center justify-between shrink-0 z-10">
            <div class="flex items-center gap-4">
                <a href="/contacts" class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-50 border border-slate-200 text-slate-500 hover:text-violet-600 hover:bg-violet-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                </a>
                <div>
                    <h2 class="text-lg font-bold text-slate-900">{{ $chatTitle }}</h2>
                    <p class="text-xs text-slate-500 font-medium flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-green-500 block"></span> Online
                    </p>
                </div>
            </div>
            
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-100 text-violet-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
            </div>
        </header>

        <div id="chat-box" class="flex-1 overflow-y-auto p-6 space-y-4 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] bg-slate-50">
            @foreach($messages as $msg)
                @if($msg->username === Auth::user()->name)
                    <div class="flex justify-end">
                        <div class="max-w-[75%] bg-violet-600 text-white px-4 py-2.5 rounded-2xl rounded-tr-sm shadow-sm">
                            <p class="text-sm leading-relaxed">{{ $msg->text }}</p>
                        </div>
                    </div>
                @else
                    <div class="flex items-end gap-2.5">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($msg->username) }}&background=e2e8f0&color=475569&bold=true" alt="{{ $msg->username }}" class="w-8 h-8 rounded-full mb-1 border border-slate-200">
                        <div class="max-w-[75%]">
                            <span class="text-[10px] text-slate-500 font-bold ml-1 mb-1 block">{{ $msg->username }}</span>
                            <div class="bg-white text-slate-800 px-4 py-2.5 rounded-2xl rounded-tl-sm shadow-sm border border-slate-100">
                                <p class="text-sm leading-relaxed">{{ $msg->text }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="bg-white border-t border-slate-200 p-4 shrink-0">
            <form id="chat-form" class="flex items-center gap-3">
                <div class="relative flex-1">
                    <input type="text" id="message-text" placeholder="Ketik pesan..." class="w-full bg-slate-100 border-transparent focus:bg-white focus:border-violet-500 focus:ring-2 focus:ring-violet-200 rounded-full pl-5 pr-4 py-3 text-sm transition-all outline-none" required autocomplete="off">
                </div>
                
                <button type="submit" class="bg-violet-600 hover:bg-violet-700 text-white rounded-full h-11 w-11 flex items-center justify-center transition-transform hover:scale-105 shadow-md shadow-violet-200 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                </button>
            </form>
        </div>
    </div>

    <script type="module">
        const chatBox = document.getElementById('chat-box');
        const chatForm = document.getElementById('chat-form');
        const textInput = document.getElementById('message-text');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const roomId = {{ $room->id }};
        const myName = "{{ Auth::user()->name }}"; // Ambil nama kita buat ngecek Kanan/Kiri

        // Auto-scroll pas awal load
        chatBox.scrollTop = chatBox.scrollHeight;

        window.Echo.private(`chat.room.${roomId}`)
            .listen('.message.sent', (e) => {
                const newChat = document.createElement('div');
                const isMe = e.username === myName;

                // Logika nampilin Kanan (Kita) atau Kiri (Orang Lain)
                if (isMe) {
                    newChat.className = 'flex justify-end mt-4 mb-4';
                    newChat.innerHTML = `
                        <div class="max-w-[75%] bg-violet-600 text-white px-4 py-2.5 rounded-2xl rounded-tr-sm shadow-sm">
                            <p class="text-sm leading-relaxed">${e.message}</p>
                        </div>
                    `;
                } else {
                    newChat.className = 'flex items-end gap-2.5 mt-4 mb-4';
                    newChat.innerHTML = `
                        <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(e.username)}&background=e2e8f0&color=475569&bold=true" class="w-8 h-8 rounded-full mb-1 border border-slate-200">
                        <div class="max-w-[75%]">
                            <span class="text-[10px] text-slate-500 font-bold ml-1 mb-1 block">${e.username}</span>
                            <div class="bg-white text-slate-800 px-4 py-2.5 rounded-2xl rounded-tl-sm shadow-sm border border-slate-100">
                                <p class="text-sm leading-relaxed">${e.message}</p>
                            </div>
                        </div>
                    `;
                }
                
                chatBox.appendChild(newChat);
                chatBox.scrollTop = chatBox.scrollHeight;
            });

        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const text = textInput.value;
            if (!text.trim()) return;

            fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message: text, room_id: roomId })
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response error');
                return response.json();
            })
            .then(data => { textInput.value = ''; })
            .catch(error => { console.error('Error:', error); });
        });
    </script>
</body>
</html>
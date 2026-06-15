<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AI Mentor | LearnLoop</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: { brand: '#7c3aed', lightBg: '#f0f2fe', darkBg: '#090616' }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

    <style>
        /* Style Tambahan untuk Chat Bubble & Markdown */
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 999px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #2e2773; }

        .markdown-body pre { background-color: #1e293b; color: #f8fafc; padding: 1rem; border-radius: 12px; overflow-x: auto; margin: 0.75rem 0; font-family: monospace; font-size: 0.85rem; }
        .markdown-body code { background-color: #e2e8f0; color: #b91c1c; padding: 0.15rem 0.4rem; border-radius: 4px; font-size: 0.85em; font-family: monospace; }
        .markdown-body pre code { background-color: transparent; color: inherit; padding: 0; }
        .markdown-body p { margin-bottom: 0.5rem; }
        .markdown-body ul { list-style-type: disc; padding-left: 1.25rem; margin-bottom: 0.5rem; }
        
        /* Efek Neumorphism/3D Halus untuk Riwayat Chat List */
        .chat-history-item {
            background: #ffffff;
            border: 2px solid #e2e8f0;
            transition: all 0.2s ease-in-out;
        }
        .chat-history-item:hover {
            transform: translateY(2px);
            border-color: #cbd5e1;
        }
        .dark .chat-history-item { background: #161245; border: 2px solid #2e2773; }
    </style>
</head>
<body class="h-screen w-screen bg-[#f0f2fe] dark:bg-[#060412] text-[#1e1b4b] dark:text-[#f3f1fa] antialiased font-sans p-3 md:p-6 flex items-center justify-center overflow-hidden transition-colors duration-300">

    <!-- KOTAK PUTIH BESAR UTAMA (Sesuai image_84b156.jpg) -->
    <div class="w-full max-w-[1440px] h-full bg-[#f8fafc] dark:bg-[#0b0822] rounded-[3.5rem] p-4 md:p-6 border-4 border-slate-200 dark:border-slate-800 shadow-xl grid grid-cols-1 lg:grid-cols-12 gap-6 overflow-hidden">
        
        <!-- KOLOM 1: SIDEBAR KIRI (lg:col-span-2) -->
        <div class="lg:col-span-2 h-full overflow-hidden">
            @include('components.sidebar')
        </div>

        <!-- KOLOM 2: AREA UTAMA CHAT (lg:col-span-7) -->
        <main class="lg:col-span-7 h-full flex flex-col bg-white dark:bg-[#110d35] rounded-[2.5rem] border-2 border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden relative">
            
            <!-- Header Atas Chat -->
            <div class="p-5 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between bg-slate-50/50 dark:bg-[#161245]/30 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-xl flex items-center justify-center text-white text-xl shadow-md">
                        🤖
                    </div>
                    <div>
                        <h1 class="text-sm font-black text-purple-950 dark:text-white" id="chat-title-header">
                            {{ $activeChat ? $activeChat->title : 'Amalia' }}
                        </h1>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">AI Mentor & Asisten Kuliah</p>
                    </div>
                </div>
                
                <!-- Dark Mode Toggle Mini -->
                <button @click="darkMode = !darkMode; localStorage.setItem('theme', darkMode ? 'dark' : 'light')" class="text-slate-400 hover:text-purple-600 p-2 text-xs">
                    <span x-show="!darkMode">🌙</span><span x-show="darkMode">☀️</span>
                </button>
            </div>

            <!-- Area Isi Obrolan (Scrollable) -->
            <div id="chat-history" class="flex-1 overflow-y-auto p-5 space-y-4 custom-scrollbar bg-slate-50/30 dark:bg-[#0e0a2f]/40">
                @if($activeChat && $activeChat->messages->count() > 0)
                    @foreach($activeChat->messages as $msg)
                        @if($msg->role === 'user')
                            <!-- Chat User -->
                            <div class="flex justify-end">
                                <div class="max-w-[75%] bg-purple-600 text-white px-4 py-2.5 rounded-2xl rounded-tr-sm shadow-sm text-xs font-medium whitespace-pre-wrap">
                                    {{ $msg->content }}
                                </div>
                            </div>
                        @else
                            <!-- Chat AI -->
                            <div class="flex items-start gap-2.5">
                                <div class="h-7 w-7 bg-gradient-to-tr from-purple-500 to-indigo-500 rounded-lg flex items-center justify-center text-white text-[10px] font-black shrink-0 shadow-sm">AI</div>
                                <div class="max-w-[80%] bg-white dark:bg-[#161245] border border-slate-200 dark:border-slate-800 px-4 py-2.5 rounded-2xl rounded-tl-sm shadow-sm text-xs text-slate-800 dark:text-slate-200 font-medium markdown-body">
                                    <script>document.write(marked.parse({!! json_encode($msg->content) !!}));</script>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    <!-- Tampilan Awal jika Belum Ada Chat -->
                    <div class="flex items-start gap-2.5" id="welcome-message">
                        <div class="h-7 w-7 bg-gradient-to-tr from-purple-500 to-indigo-500 rounded-lg flex items-center justify-center text-white text-[10px] font-black shrink-0 shadow-sm">AI</div>
                        <div class="max-w-[80%] bg-white dark:bg-[#161245] border border-slate-200 dark:border-slate-800 px-4 py-2.5 rounded-2xl rounded-tl-sm shadow-sm text-xs text-slate-800 dark:text-slate-200 font-bold">
                            Halo! Ada tugas kuliah atau codingan yang mau kita bahas hari ini, beb?
                        </div>
                    </div>
                @endif
            </div>

            <!-- Loading Indicator -->
            <div id="loading-indicator" class="hidden absolute bottom-20 left-5 bg-white/90 dark:bg-[#161245]/90 backdrop-blur border border-slate-200 dark:border-slate-700 px-3 py-1.5 rounded-full shadow-sm items-center gap-2 z-10">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-purple-500"></span>
                </span>
                <span class="text-[10px] font-black text-slate-500 dark:text-slate-300">Amalia sedang mengetik...</span>
            </div>

            <!-- Form Input Textarea Fix di Bawah -->
            <div class="p-4 bg-white dark:bg-[#110d35] border-t border-slate-100 dark:border-slate-800 shrink-0">
                <form id="ai-form" class="flex items-center gap-2.5">
                    <textarea id="ai-input" rows="1" placeholder="Tanya Amalia di sini..." class="w-full bg-slate-100 dark:bg-[#0d0926] border-2 border-transparent focus:border-purple-500 rounded-xl px-4 py-3 text-xs font-bold text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none resize-none custom-scrollbar" required></textarea>
                    <button type="submit" id="ai-submit" class="bg-purple-600 hover:bg-purple-700 text-white rounded-xl h-10 w-10 flex items-center justify-center transition-all shadow-md shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform rotate-45" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                    </button>
                </form>
            </div>
        </main>

        <!-- KOLOM 3: RIWAYAT CHAT KANAN (lg:col-span-3) -->
        <div class="lg:col-span-3 h-full overflow-hidden flex flex-col bg-white dark:bg-[#110d35] rounded-[2.5rem] border-2 border-slate-200/80 dark:border-slate-800 shadow-sm p-4">
            
            <!-- Header Sidebar Kanan -->
            <div class="flex justify-between items-center pb-3 mb-3 border-b border-slate-100 dark:border-slate-800 shrink-0">
                <div>
                    <h2 class="text-xs font-black text-purple-950 dark:text-white uppercase tracking-wider">Riwayat Chat</h2>
                    <p class="text-[9px] text-slate-400 font-bold">HISTORY LOG</p>
                </div>
                <!-- Tombol Chat Baru Pop Style -->
                <a href="/ai-mentor" class="bg-purple-100 dark:bg-purple-950 text-purple-700 dark:text-purple-300 p-2 rounded-xl hover:scale-105 transition-transform" title="Mulai Chat Baru">
                    ➕ New
                </a>
            </div>

            <!-- List Percakapan -->
            <div class="flex-1 overflow-y-auto space-y-3 pr-1 custom-scrollbar">
                
                <!-- Kategori Pinned -->
                <div>
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-2 px-1">📍 PINNED</span>
                    <div class="space-y-1.5">
                        @forelse($chats->where('is_pinned', true) as $c)
                            <div id="chat-item-{{ $c->id }}" class="chat-history-item p-2.5 rounded-xl flex items-center justify-between text-xs font-bold {{ $activeChat && $activeChat->id == $c->id ? 'bg-purple-50 dark:bg-purple-950/40 border-purple-400' : '' }}">
                                <a href="/ai-mentor?chat_id={{ $c->id }}" class="truncate flex-1 pr-2 text-slate-700 dark:text-slate-300">💬 {{ $c->title }}</a>
                                <div class="flex gap-1 text-[10px]">
                                    <button onclick="togglePin({{ $c->id }})">📌</button>
                                    <button onclick="deleteChat({{ $c->id }})" class="text-red-400">🗑️</button>
                                </div>
                            </div>
                        @empty
                            <p class="text-[10px] text-slate-400 italic px-1">Tidak ada pin.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Kategori Semua Chat -->
                <div class="pt-2">
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-2 px-1">📁 SEMUA PERCAKAPAN</span>
                    <div class="space-y-1.5">
                        @forelse($chats->where('is_pinned', false) as $c)
                            <div id="chat-item-{{ $c->id }}" class="chat-history-item p-2.5 rounded-xl flex items-center justify-between text-xs font-bold {{ $activeChat && $activeChat->id == $c->id ? 'bg-purple-50 dark:bg-purple-950/40 border-purple-400' : '' }}">
                                <a href="/ai-mentor?chat_id={{ $c->id }}" class="truncate flex-1 pr-2 text-slate-700 dark:text-slate-300">💬 {{ $c->title }}</a>
                                <div class="flex gap-1 text-[10px]">
                                    <button onclick="togglePin({{ $c->id }})">📌</button>
                                    <button onclick="deleteChat({{ $c->id }})" class="text-red-400">🗑️</button>
                                </div>
                            </div>
                        @empty
                            <p class="text-[10px] text-slate-400 italic px-1">Belum ada riwayat.</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- LOGIC JAVASCRIPT ASLI (Tetap dipertahankan tanpa merusak fitur backend) -->
    <script>
        const chatHistory = document.getElementById('chat-history');
        const aiForm = document.getElementById('ai-form');
        const aiInput = document.getElementById('ai-input');
        const submitBtn = document.getElementById('ai-submit');
        const loadingIndicator = document.getElementById('loading-indicator');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        let currentChatId = {{ $activeChat ? $activeChat->id : 'null' }};
        chatHistory.scrollTop = chatHistory.scrollHeight;

        aiInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight < 100 ? this.scrollHeight : 100) + 'px';
        });

        aiInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                if(this.value.trim() !== '') { aiForm.dispatchEvent(new Event('submit')); }
            }
        });

        function appendMessage(role, text) {
            const welcome = document.getElementById('welcome-message');
            if(welcome) welcome.remove();

            const msgDiv = document.createElement('div');
            if (role === 'user') {
                msgDiv.className = "flex justify-end";
                msgDiv.innerHTML = `<div class="max-w-[75%] bg-purple-600 text-white px-4 py-2.5 rounded-2xl rounded-tr-sm shadow-sm text-xs font-medium whitespace-pre-wrap">${text}</div>`;
            } else {
                msgDiv.className = "flex items-start gap-2.5";
                msgDiv.innerHTML = `<div class="h-7 w-7 bg-gradient-to-tr from-purple-500 to-indigo-500 rounded-lg flex items-center justify-center text-white text-[10px] font-black shrink-0 shadow-sm">AI</div><div class="max-w-[80%] bg-white dark:bg-[#161245] border border-slate-200 dark:border-slate-800 px-4 py-2.5 rounded-2xl rounded-tl-sm shadow-sm text-xs text-slate-800 dark:text-slate-200 font-medium markdown-body">${marked.parse(text)}</div>`;
            }
            chatHistory.appendChild(msgDiv);
            chatHistory.scrollTop = chatHistory.scrollHeight;
        }

        aiForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const message = aiInput.value.trim();
            if (!message) return;

            appendMessage('user', message);
            aiInput.value = '';
            aiInput.style.height = 'auto';
            submitBtn.disabled = true;
            loadingIndicator.classList.remove('hidden');
            loadingIndicator.classList.add('flex');

            try {
                const response = await fetch('/ai-mentor/ask', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ message: message, chat_id: currentChatId })
                });
                const result = await response.json();
                if (result.success) {
                    appendMessage('ai', result.data);
                    if (currentChatId === null) {
                        window.location.href = '/ai-mentor?chat_id=' + result.chat_id;
                    }
                } else {
                    appendMessage('ai', 'Error nih beb: ' + result.message);
                }
            } catch (error) {
                appendMessage('ai', 'Gagal terkoneksi dengan AI.');
            } finally {
                submitBtn.disabled = false;
                loadingIndicator.classList.add('hidden');
                loadingIndicator.classList.remove('flex');
            }
        });

        async function togglePin(id) {
            try {
                const response = await fetch(`/ai-mentor/pin/${id}`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                });
                const result = await response.json();
                if(result.success) { window.location.reload(); }
            } catch (error) { alert('Gagal memproses pin.'); }
        }

        async function deleteChat(id) {
            if(!confirm('Hapus riwayat chat ini?')) return;
            try {
                const response = await fetch(`/ai-mentor/delete/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                });
                const result = await response.json();
                if(result.success) {
                    document.getElementById(`chat-item-${id}`).remove();
                    if(currentChatId == id) { window.location.href = '/ai-mentor'; }
                }
            } catch (error) { alert('Gagal menghapus chat.'); }
        }
    </script>
</body>
</html>
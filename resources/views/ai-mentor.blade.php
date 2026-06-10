<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AI Mentor | LearnLoop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .glass-effect { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        
        /* Style Markdown Kodingan */
        .markdown-body pre { background-color: #1e293b; color: #f8fafc; padding: 1rem; border-radius: 12px; overflow-x: auto; margin: 0.75rem 0; font-family: monospace; font-size: 0.85rem; }
        .markdown-body code { background-color: #e2e8f0; color: #b91c1c; padding: 0.15rem 0.4rem; border-radius: 4px; font-size: 0.85em; font-family: monospace; }
        .markdown-body pre code { background-color: transparent; color: inherit; padding: 0; }
        .markdown-body p { margin-bottom: 0.75rem; }
        .markdown-body ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 0.75rem; }
        .markdown-body ol { list-style-type: decimal; padding-left: 1.5rem; margin-bottom: 0.75rem; }
        .markdown-body strong { color: #0f172a; }
    </style>
</head>
<body class="min-h-screen text-slate-900">

    <header class="sticky top-0 z-50 border-b border-slate-200 glass-effect">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6">
            <div class="flex flex-1 items-center gap-8">
                <a href="/beranda" class="flex items-center gap-2">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-600 shadow-lg shadow-violet-200">
                        <span class="text-xl font-bold text-white">L</span>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight text-slate-900">LearnLoop</span>
                </a>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm font-bold text-slate-700 hidden md:block">{{ Auth::user()->name }}</span>
                <a href="/profile" class="transition-transform hover:scale-110 active:scale-95">
                    <img src="{{ Auth::user()->photo ? asset(Auth::user()->photo) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name ?? 'User').'&background=8b5cf6&color=ffffff&rounded=true' }}" class="h-9 w-9 rounded-xl object-cover shadow-sm border border-violet-100" />
                </a>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-8 pb-24 sm:px-6">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
            @include('components.sidebar')

            <section class="lg:col-span-6 flex flex-col bg-white rounded-[32px] border border-slate-200 shadow-xl overflow-hidden relative h-[calc(100vh-7rem)]">
                
                <div class="p-6 border-b border-slate-100 flex items-center gap-4 bg-slate-50/50 shrink-0">
                    <div class="h-12 w-12 bg-gradient-to-br from-violet-500 to-fuchsia-500 rounded-2xl flex items-center justify-center text-white text-2xl shadow-lg shadow-violet-200">
                        🤖
                    </div>
                    <div>
                        <h1 class="text-xl font-extrabold text-slate-900" id="chat-title-header">
                            {{ $activeChat ? $activeChat->title : 'Amalia' }}
                        </h1>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mt-0.5">Teman Kuliah & Mentor IT</p>
                    </div>
                </div>

                <div id="chat-history" class="flex-1 overflow-y-auto p-6 space-y-6 custom-scrollbar bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] bg-slate-50">
                    
                    @if($activeChat && $activeChat->messages->count() > 0)
                        @foreach($activeChat->messages as $msg)
                            @if($msg->role === 'user')
                                <div class="flex justify-end animate-fade-in">
                                    <div class="w-fit max-w-[70%] bg-violet-600 text-white px-4 py-3 rounded-2xl rounded-tr-sm shadow-md text-sm whitespace-pre-wrap">{{ $msg->content }}</div>
                                </div>
                            @else
                                <div class="flex items-end gap-3 animate-fade-in">
                                    <div class="h-8 w-8 bg-gradient-to-br from-violet-500 to-fuchsia-500 rounded-full flex items-center justify-center text-white text-xs shrink-0 shadow-sm">AI</div>
                                    <div class="w-fit max-w-[80%] bg-white border border-slate-200 px-4 py-3 rounded-2xl rounded-tl-sm shadow-sm text-sm text-slate-800 markdown-body">
                                        <script>document.write(marked.parse({!! json_encode($msg->content) !!}));</script>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="flex items-end gap-3" id="welcome-message">
                            <div class="h-8 w-8 bg-gradient-to-br from-violet-500 to-fuchsia-500 rounded-full flex items-center justify-center text-white text-xs shrink-0 shadow-sm">AI</div>
                            <div class="w-fit max-w-[80%] bg-white border border-slate-200 px-4 py-3 rounded-2xl rounded-tl-sm shadow-sm text-sm text-slate-800">
                                Mau nanya aja atau curhat nih?
                            </div>
                        </div>
                    @endif

                </div>

                <div id="loading-indicator" class="hidden absolute bottom-20 left-6 w-fit bg-white/90 backdrop-blur border border-slate-200 px-4 py-2.5 rounded-full shadow-lg items-center gap-3 z-10">
                    <div class="flex items-center gap-1">
                        <span class="h-2 w-2 rounded-full bg-violet-500 animate-bounce" style="animation-delay: 0ms;"></span>
                        <span class="h-2 w-2 rounded-full bg-violet-400 animate-bounce" style="animation-delay: 150ms;"></span>
                        <span class="h-2 w-2 rounded-full bg-violet-300 animate-bounce" style="animation-delay: 300ms;"></span>
                    </div>
                    <span class="text-xs font-bold text-slate-600">Amalia lagi mikir...</span>
                </div>

                <div class="p-4 bg-white border-t border-slate-100 shrink-0">
                    <form id="ai-form" class="flex items-center gap-3">
                        <textarea id="ai-input" rows="1" placeholder="Tanya apa aja beb..." class="w-full bg-slate-100 border-transparent focus:bg-white focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 rounded-2xl px-5 py-3.5 text-sm transition-all outline-none resize-none custom-scrollbar" required></textarea>
                        
                        <button type="submit" id="ai-submit" class="bg-violet-600 hover:bg-violet-700 text-white rounded-2xl h-[52px] w-[52px] flex items-center justify-center transition-all shadow-lg shadow-violet-200 shrink-0 disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" /></svg>
                        </button>
                    </form>
                </div>
            </section>

            <aside class="hidden lg:col-span-3 lg:flex flex-col h-[calc(100vh-7rem)] bg-white rounded-[32px] border border-slate-200 shadow-xl overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50 shrink-0 flex justify-between items-center">
                    <div>
                        <h2 class="text-base font-extrabold text-slate-900">Riwayat Chat</h2>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-0.5">History</p>
                    </div>
                    <a href="/ai-mentor" class="bg-violet-100 hover:bg-violet-200 text-violet-700 p-2 rounded-xl transition-all shadow-sm flex items-center justify-center" title="Mulai Chat Baru">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                    </a>
                </div>

                <div class="flex-1 overflow-y-auto p-4 space-y-6 custom-scrollbar bg-slate-50">
                    
                    <div>
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3 px-2 flex items-center gap-2">
                            <span class="text-violet-500">📍</span> Pinned
                        </h3>
                        <div class="space-y-2" id="pinned-chats-container">
                            @forelse($chats->where('is_pinned', true) as $c)
                                <div id="chat-item-{{ $c->id }}" class="group flex items-center justify-between p-3 rounded-2xl transition-all cursor-pointer {{ $activeChat && $activeChat->id == $c->id ? 'bg-violet-600 text-white shadow-md' : 'bg-white border border-slate-200 hover:border-violet-300' }}">
                                    <a href="/ai-mentor?chat_id={{ $c->id }}" class="flex items-center gap-3 overflow-hidden flex-1 select-none">
                                        <span class="text-lg shrink-0">💬</span>
                                        <p class="text-sm font-bold truncate {{ $activeChat && $activeChat->id == $c->id ? 'text-white' : 'text-slate-700 group-hover:text-violet-700' }}">{{ $c->title }}</p>
                                    </a>
                                    <div class="opacity-0 group-hover:opacity-100 flex items-center gap-1 shrink-0 transition-opacity ml-2">
                                        <button onclick="togglePin({{ $c->id }})" class="p-1 rounded-lg {{ $activeChat && $activeChat->id == $c->id ? 'hover:bg-violet-500 text-white' : 'hover:bg-slate-100 text-slate-400 hover:text-violet-600' }}" title="Lepas Pin">
                                            📌
                                        </button>
                                        <button onclick="deleteChat({{ $c->id }})" class="p-1 rounded-lg {{ $activeChat && $activeChat->id == $c->id ? 'hover:bg-violet-500 text-violet-200 hover:text-white' : 'hover:bg-red-50 text-slate-400 hover:text-red-500' }}" title="Hapus Chat">
                                            🗑️
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-slate-400 italic px-2 py-1">Belum ada chat yang di-pin.</p>
                            @endforelse
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3 px-2">Semua Percakapan</h3>
                        <div class="space-y-2" id="recent-chats-container">
                            @forelse($chats->where('is_pinned', false) as $c)
                                <div id="chat-item-{{ $c->id }}" class="group flex items-center justify-between p-3 rounded-2xl transition-all cursor-pointer {{ $activeChat && $activeChat->id == $c->id ? 'bg-violet-600 text-white shadow-md' : 'bg-white border border-slate-200 hover:border-violet-300' }}">
                                    <a href="/ai-mentor?chat_id={{ $c->id }}" class="flex items-center gap-3 overflow-hidden flex-1 select-none">
                                        <span class="text-lg shrink-0 opacity-50">💭</span>
                                        <p class="text-sm font-bold truncate {{ $activeChat && $activeChat->id == $c->id ? 'text-white' : 'text-slate-700 group-hover:text-violet-700' }}">{{ $c->title }}</p>
                                    </a>
                                    <div class="opacity-0 group-hover:opacity-100 flex items-center gap-1 shrink-0 transition-opacity ml-2">
                                        <button onclick="togglePin({{ $c->id }})" class="p-1 rounded-lg {{ $activeChat && $activeChat->id == $c->id ? 'hover:bg-violet-500 text-white' : 'hover:bg-slate-100 text-slate-400 hover:text-violet-600' }}" title="Sematkan Chat">
                                            📌
                                        </button>
                                        <button onclick="deleteChat({{ $c->id }})" class="p-1 rounded-lg {{ $activeChat && $activeChat->id == $c->id ? 'hover:bg-violet-500 text-violet-200 hover:text-white' : 'hover:bg-red-50 text-slate-400 hover:text-red-500' }}" title="Hapus Chat">
                                            🗑️
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-slate-400 italic px-2 py-1">Belum ada riwayat percakapan.</p>
                            @endforelse
                        </div>
                    </div>

                </div>
            </aside>
        </div>
    </main>

    <script>
        const chatHistory = document.getElementById('chat-history');
        const aiForm = document.getElementById('ai-form');
        const aiInput = document.getElementById('ai-input');
        const submitBtn = document.getElementById('ai-submit');
        const loadingIndicator = document.getElementById('loading-indicator');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Simpan state chat_id aktif dari server Blade
        let currentChatId = {{ $activeChat ? $activeChat->id : 'null' }};

        // Scroll otomatis ke dasar chat pas halaman kebuka
        chatHistory.scrollTop = chatHistory.scrollHeight;

        // Auto-expand kolom input textarea sesuai panjang ketikan
        aiInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight < 120 ? this.scrollHeight : 120) + 'px';
        });

        // Kirim chat lewat Enter (Shift+Enter buat bikin baris baru)
        aiInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                if(this.value.trim() !== '') {
                    aiForm.dispatchEvent(new Event('submit'));
                }
            }
        });

        // Render gelembung chat baru di layar
        function appendMessage(role, text) {
            const welcome = document.getElementById('welcome-message');
            if(welcome) welcome.remove(); // Hapus pesan sambutan kalau user mulai ngetik

            const msgDiv = document.createElement('div');
            if (role === 'user') {
                msgDiv.className = "flex justify-end animate-fade-in";
                msgDiv.innerHTML = `<div class="w-fit max-w-[70%] bg-violet-600 text-white px-4 py-3 rounded-2xl rounded-tr-sm shadow-md text-sm whitespace-pre-wrap">${text}</div>`;
            } else {
                msgDiv.className = "flex items-end gap-3 animate-fade-in";
                msgDiv.innerHTML = `<div class="h-8 w-8 bg-gradient-to-br from-violet-500 to-fuchsia-500 rounded-full flex items-center justify-center text-white text-xs shrink-0 shadow-sm">AI</div><div class="w-fit max-w-[80%] bg-white border border-slate-200 px-4 py-3 rounded-2xl rounded-tl-sm shadow-sm text-sm text-slate-800 markdown-body">${marked.parse(text)}</div>`;
            }
            chatHistory.appendChild(msgDiv);
            chatHistory.scrollTop = chatHistory.scrollHeight;
        }

        // Eksekusi kirim pesan via AJAX
        aiForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const message = aiInput.value.trim();
            if (!message) return;

            // Render langsung chat user di UI
            appendMessage('user', message);
            
            // Reset form input
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
                    body: JSON.stringify({ 
                        message: message,
                        chat_id: currentChatId
                    })
                });

                const result = await response.json();

                if (result.success) {
                    appendMessage('ai', result.data);
                    
                    // JURUS VIP: Kalo ini chat baru, langsung redirect ke URL sesinya biar judul bikinan AI nampil di history!
                    if (currentChatId === null) {
                        window.location.href = '/ai-mentor?chat_id=' + result.chat_id;
                    }
                } else {
                    appendMessage('ai', 'Error nih beb: ' + result.message);
                }
            } catch (error) {
                appendMessage('ai', 'Gagal nyambung ke server. Coba cek VPN lu, beb.');
            } finally {
                submitBtn.disabled = false;
                loadingIndicator.classList.add('hidden');
                loadingIndicator.classList.remove('flex');
            }
        });

        // Fungsi AJAX buat nge-Pin / Unpin Chat
        async function togglePin(id) {
            try {
                const response = await fetch(`/ai-mentor/pin/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                const result = await response.json();
                if(result.success) {
                    // Refresh halaman biar list pinned & recent ke-render ulang rapi dari database
                    window.location.reload();
                }
            } catch (error) {
                alert('Gagal nge-pin chat beb!');
            }
        }

        // Fungsi AJAX buat ngehapus Sesi Chat
        async function deleteChat(id) {
            if(!confirm('Beneran mau hapus sesi chat ini, beb? Sumpah ntar memorinya ilang semua lho.')) return;
            
            try {
                const response = await fetch(`/ai-mentor/delete/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                const result = await response.json();
                if(result.success) {
                    // Hapus elemen dari DOM
                    document.getElementById(`chat-item-${id}`).remove();
                    // Kalo chat yang lagi dibuka yang dihapus, balikin ke halaman awal
                    if(currentChatId == id) {
                        window.location.href = '/ai-mentor';
                    }
                }
            } catch (error) {
                alert('Gagal hapus chat beb!');
            }
        }
    </script>
</body>
</html>
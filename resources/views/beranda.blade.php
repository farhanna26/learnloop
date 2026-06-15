<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: localStorage.getItem('theme') === 'dark', editProfileOpen: false, selectedPost: null }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LearnLoop | Platform Kolaborasi Mahasiswa</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: { 
                        brand: '#7c3aed',
                        lightBg: '#f0f2fe',
                        darkBg: '#090616'
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* --- TENGAH: HIGH-CONTRAST POP-UP STYLE (3D SOLID BLOK) --- */
        .card-feed {
            background: #ffffff;
            border-radius: 2.25rem;
            border: 2px solid #e2e8f0;
            box-shadow: 0px 14px 0px #cbd5e1;
            transition: all 0.2s ease-in-out;
        }
        .card-feed:hover {
            transform: translateY(4px);
            box-shadow: 0px 8px 0px #cbd5e1;
        }

        .btn-pop-purple {
            background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
            border: 2px solid #4c1d95;
            box-shadow: 0px 6px 0px #4c1d95;
            transition: all 0.15s ease;
        }
        .btn-pop-purple:active { transform: translateY(6px); box-shadow: 0px 0px 0px #4c1d95; }

        .btn-pop-white {
            background: #ffffff;
            border: 2px solid #cbd5e1;
            box-shadow: 0px 5px 0px #cbd5e1;
            transition: all 0.15s ease;
        }
        .btn-pop-white:active { transform: translateY(5px); box-shadow: 0px 0px 0px #cbd5e1; }

        .custom-input {
            background: #ffffff;
            border: 2px solid #cbd5e1;
            border-radius: 1.5rem;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.06);
        }

        /* --- SINKRONISASI PER KONTEN SIDEBAR KANAN (3D UNGU & BORDER SAMAR) --- */
        /* Hanya menargetkan elemen div pembungkus modul konten (bukan membungkus seluruh aside/logout) */
        .lg\:col-span-3 aside > div:not(.pt-2) {
            border: 1px solid rgba(124, 58, 237, 0.2) !important; /* Border samar ungu halus awal */
            box-shadow: 0px 0px 0px transparent !important;
            transform: translateY(0);
            transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
        }
        
        /* Efek melayang 3D Ungu solid saat PER KOTAK KONTEN (Teman/Kreator) disorot kursor */
        .lg\:col-span-3 aside > div:not(.pt-2):hover {
            transform: translateY(-6px) !important;
            border-color: #c084fc !important; /* Border ungu cerah saat hover */
            box-shadow: 0px 10px 0px #7c3aed !important; /* Bayangan 3D Blok Ungu solid */
        }

        /* Flat item list di dalam kontainer modul sidebar */
        .item-user-clean {
            background: rgba(248, 250, 252, 0.6);
            transition: background 0.2s ease;
        }
        .lg\:col-span-3 aside > div:hover .item-user-clean {
            background: #ffffff;
        }

        /* Tombol Keluar Akun Mini 3D Merah Bawaan */
        .btn-logout-mini {
            background: #ffffff;
            border: 2px solid #fecaca;
            box-shadow: 0px 4px 0px #fca5a5;
            transition: all 0.15s ease-in-out;
        }
        .btn-logout-mini:hover {
            transform: translateY(2px);
            box-shadow: 0px 2px 0px #fca5a5;
            background: #fff5f5;
        }
        .btn-logout-mini:active { transform: translateY(4px); box-shadow: 0px 0px 0px #fca5a5; }

        /* Dark Mode Styling */
        .dark .card-feed { background: #161245; border: 2px solid #2e2773; box-shadow: 0px 14px 0px #0d0a2d; }
        .dark .card-feed:hover { box-shadow: 0px 8px 0px #0d0a2d; }
        .dark .btn-pop-white { background: #161245; border: 2px solid #2e2773; box-shadow: 0px 5px 0px #0d0a2d; color: white; }
        .dark .custom-input { background: #0d0926; border: 2px solid #2e2773; color: #ffffff; }

        /* Dark Mode Per Konten Modul Sidebar */
        .dark .lg\:col-span-3 aside > div:not(.pt-2) { 
            border: 1px solid rgba(139, 92, 246, 0.15) !important; 
        }
        .dark .lg\:col-span-3 aside > div:not(.pt-2):hover { 
            border-color: #4c1d95 !important; 
            box-shadow: 0px 10px 0px #4c1d95 !important; 
        }
        .dark .item-user-clean { background: rgba(13, 9, 38, 0.4); }
        .dark .btn-logout-mini { background: #1a102f; border: 2px solid #e11d48; box-shadow: 0px 4px 0px #9f1239; color: #f43f5e; }

        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 999px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #2e2773; }
        @keyframes cardPop { from { opacity: 0; transform: scale(0.95) translateY(15px); } to { opacity: 1; transform: scale(1) translateY(0); } }
        .animate-card { animation: cardPop 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }
    </style>
</head>
<body class="h-screen w-screen bg-[#f0f2fe] dark:bg-[#060412] text-[#1e1b4b] dark:text-[#f3f1fa] antialiased font-sans p-3 md:p-6 flex items-center justify-center overflow-hidden transition-colors duration-300">

    <div class="w-full max-w-[1440px] h-full bg-[#f8fafc] dark:bg-[#0b0822] rounded-[3.5rem] p-4 md:p-6 border-4 border-slate-200 dark:border-slate-800 shadow-xl grid grid-cols-1 lg:grid-cols-12 gap-6 overflow-hidden">
        
        <div class="lg:col-span-2 h-full overflow-hidden">
            @include('components.sidebar')
        </div>

        <main class="lg:col-span-7 h-full flex flex-col space-y-6 overflow-y-auto custom-scrollbar pr-2 pb-4">
            
            <div class="flex items-center justify-between gap-4 pt-1 shrink-0">
                <div class="relative w-full max-w-md">
                    <span class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-purple-600 text-xs z-10">🔍</span>
                    <input type="text" placeholder="Cari portfolio, riset, atau teman..." class="w-full custom-input pl-11 pr-4 py-3.5 text-xs font-black placeholder-slate-400 focus:outline-none">
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <a href="/upload-karya" class="btn-pop-purple text-white px-6 py-3.5 text-xs font-black rounded-2xl uppercase tracking-wider inline-block text-center">
                    ➕ Upload Karya
                    </a>
                    <button @click="darkMode = !darkMode; localStorage.setItem('theme', darkMode ? 'dark' : 'light')" class="btn-pop-white p-3.5 rounded-2xl text-xs">
                        <span x-show="!darkMode">🌙</span><span x-show="darkMode">☀️</span>
                    </button>
                </div>
            </div>

            <div class="p-7 relative overflow-hidden flex flex-col md:flex-row items-center justify-between bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 text-white rounded-[2.5rem] border-2 border-purple-700 shadow-xl shrink-0">
                <div class="space-y-2 max-w-full md:max-w-[70%] text-center md:text-left z-10">
                    <h1 class="text-xl md:text-2xl font-black mt-1">Selamat datang di Beranda Academic! 👋</h1>
                    <p class="text-xs text-purple-100 font-semibold leading-relaxed">Temukan riset, portofolio, dan ruang kelas kolaboratif mahasiswa hari ini.</p>
                </div>
                <div class="hidden md:flex items-center justify-center pr-4 z-10">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-3xl transform rotate-12 border-2 border-white/30 shadow-lg">📚</div>
                </div>
            </div>

            <div class="space-y-4 shrink-0">
                <div class="flex gap-2 bg-slate-200/60 dark:bg-[#0d0926] p-1.5 rounded-2xl w-max border border-slate-300/40">
                    <button id="tab-portfolio" class="px-5 py-2.5 text-xs font-black bg-purple-600 text-white rounded-xl shadow-md uppercase tracking-wider">💼 Portofolio</button>
                    <button id="tab-learning" class="px-5 py-2.5 text-xs font-black text-slate-600 dark:text-purple-300/70 hover:text-purple-600 uppercase tracking-wider">📘 Pembelajaran</button>
                </div>
            </div>

            <div id="postsWrapper" class="space-y-6"></div>
        </main>

        <div class="lg:col-span-3 h-full overflow-hidden">
            @include('components.right-sidebar')
        </div>

    </div>

    <div x-show="selectedPost" x-transition class="fixed inset-0 z-[150] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" style="display: none;">
        <div class="w-full max-w-lg card-feed p-6 dark:bg-[#1d1545]" @click.away="selectedPost = null">
            <div class="flex justify-between items-center mb-4 pb-2 border-b border-purple-100/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-purple-500 to-indigo-500 flex items-center justify-center text-white font-black text-sm" x-text="selectedPost ? selectedPost.user.name[0] : ''"></div>
                    <div>
                        <h4 class="font-black text-xs text-purple-950 dark:text-white" x-text="selectedPost ? selectedPost.user.name : ''"></h4>
                        <p class="text-[9px] text-slate-400 font-bold">Detail Post</p>
                    </div>
                </div>
                <button @click="selectedPost = null" class="text-slate-400 bg-slate-100 dark:bg-purple-950/40 p-2 rounded-xl text-xs">✕</button>
            </div>
            <p class="text-xs md:text-sm font-semibold text-slate-700 dark:text-slate-200 leading-relaxed bg-purple-50/40 dark:bg-[#0d0926] p-4 rounded-2xl" x-text="selectedPost ? selectedPost.content : ''"></p>
        </div>
    </div>

    <script>
        function renderPost(post) {
            const article = document.createElement('article');
            article.className = 'card-feed p-6 relative animate-card cursor-pointer mb-6';
            article.setAttribute('x-on:click', `selectedPost = ${JSON.stringify(post)}`);
            const userName = post.user?.name || 'User';
            
            article.innerHTML = `
                <div class="flex items-start justify-between pb-3">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(userName)}&background=8b5cf6&color=ffffff" class="h-11 w-11 rounded-2xl object-cover border-2 border-purple-200 dark:border-purple-900 shadow-sm" />
                        <div>
                            <span class="text-xs font-black text-purple-950 dark:text-purple-100 tracking-tight">${userName}</span>
                            <p class="text-[9px] text-slate-400 dark:text-slate-500 font-bold mt-0.5">Baru saja</p>
                        </div>
                    </div>
                </div>
                <div class="pb-4 text-xs md:text-sm text-slate-800 dark:text-slate-200 leading-relaxed font-bold px-0.5">${post.content}</div>
                <div class="pt-3 border-t-2 border-dashed border-slate-100 dark:border-slate-800/60 flex gap-2 text-[11px] font-bold" onclick="event.stopPropagation();">
                    <button class="flex items-center gap-1.5 px-4 py-2 rounded-xl bg-pink-50 dark:bg-pink-950/20 text-pink-500 border border-pink-200 transition-transform active:scale-95">👍 <span>${post.likes_count || 0}</span></button>
                    <button class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-slate-500 dark:text-purple-300 bg-slate-50 dark:bg-purple-950/10 border border-slate-200 transition-all active:scale-95" x-on:click="$parent.selectedPost = ${JSON.stringify(post)}">💬 <span>Tanggapi</span></button>
                </div>`;
            return article;
        }

        const postsWrapper = document.getElementById('postsWrapper');
        for (let i = 0; i < 5; i++) {
            postsWrapper.appendChild(renderPost({
                id: i, 
                content: 'Berhasil membuat modul integrasi sistem AI Mentor menggunakan arsitektur Laravel Engine tingkat lanjut untuk tracking portofolio mahasiswa.', 
                likes_count: 12 + i,
                user: {name: 'Alex Joshua'}
            }));
        }
    </script>
</body>
</html>
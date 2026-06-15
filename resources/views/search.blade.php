<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cari Mahasiswa | LearnLoop</title>
    
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
        /* --- HIGH-CONTRAST POP-UP STYLE (3D SOLID BLOK) --- */
        .btn-pop-white {
            background: #ffffff;
            border: 2px solid #cbd5e1;
            box-shadow: 0px 5px 0px #cbd5e1;
            transition: all 0.15s ease;
        }
        .btn-pop-white:active { transform: translateY(5px); box-shadow: 0px 0px 0px #cbd5e1; }
        .dark .btn-pop-white { background: #161245; border: 2px solid #2e2773; box-shadow: 0px 5px 0px #0d0a2d; color: white; }

        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 999px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #2e2773; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeIn 0.4s ease-out forwards; }
    </style>
</head>
<body class="h-screen w-screen bg-[#f0f2fe] dark:bg-[#060412] text-[#1e1b4b] dark:text-[#f3f1fa] antialiased font-sans p-3 md:p-6 flex items-center justify-center overflow-hidden transition-colors duration-300">

    <div class="w-full max-w-[1440px] h-full bg-[#f8fafc] dark:bg-[#0b0822] rounded-[3.5rem] p-4 md:p-6 border-4 border-slate-200 dark:border-slate-800 shadow-xl grid grid-cols-1 lg:grid-cols-12 gap-6 overflow-hidden">
        
        <div class="lg:col-span-2 h-full overflow-hidden">
            @include('components.sidebar')
        </div>

        <main class="lg:col-span-7 h-full flex flex-col bg-white dark:bg-[#110d35] rounded-[2.5rem] border-2 border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden relative">
            
            <div class="p-6 border-b border-slate-100 dark:border-slate-800/80 bg-slate-50/50 dark:bg-[#161245]/30 shrink-0">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 bg-gradient-to-br from-violet-500 to-fuchsia-500 rounded-xl flex items-center justify-center text-xl shadow-md">
                            👋
                        </div>
                        <div>
                            <h1 class="text-base font-black text-purple-950 dark:text-white uppercase tracking-wider">Cari Mahasiswa</h1>
                            <p class="text-[9px] font-bold text-slate-400 dark:text-slate-500">Temukan teman kolaborasi atau sekedar berbagi materi.</p>
                        </div>
                    </div>
                    
                    <button @click="darkMode = !darkMode; localStorage.setItem('theme', darkMode ? 'dark' : 'light')" class="btn-pop-white p-2.5 rounded-xl text-xs">
                        <span x-show="!darkMode">🌙</span><span x-show="darkMode">☀️</span>
                    </button>
                </div>

                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 dark:text-slate-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <input type="text" id="search-input" placeholder="Ketik nama teman belajar lu di sini..." 
                           class="w-full rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#0c0926] py-3.5 pl-11 pr-4 text-xs font-medium outline-none text-slate-800 dark:text-slate-100 focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 transition-all" autocomplete="off">
                </div>
            </div>

            <div id="search-results" class="flex-1 overflow-y-auto p-6 space-y-3 custom-scrollbar bg-slate-50/30 dark:bg-[#0e0a2f]/20">
                
                <div id="initial-placeholder" class="text-center py-20 bg-white dark:bg-[#161245] rounded-3xl border border-slate-100 dark:border-slate-800/80">
                    <div class="flex justify-center mb-4 text-slate-200 dark:text-slate-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    </div>
                    <p class="text-slate-400 dark:text-slate-500 font-bold text-xs uppercase tracking-wider italic">Ketik sesuatu buat cari temen belajar.</p>
                </div>

            </div>
        </main>

        <div class="lg:col-span-3 h-full overflow-hidden">
            @include('components.right-sidebar')
        </div>

    </div>

    <script>
        const searchInput = document.getElementById('search-input');
        const searchResults = document.getElementById('search-results');
        const initialPlaceholder = document.getElementById('initial-placeholder');

        searchInput.addEventListener('input', function() {
            const keyword = this.value;

            if (keyword.length === 0) {
                searchResults.innerHTML = '';
                searchResults.appendChild(initialPlaceholder);
                return;
            }

            fetch(`/search?q=${keyword}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(users => {
                if (users.length === 0) {
                    searchResults.innerHTML = `
                        <div class="text-center py-12 bg-white dark:bg-[#161245] rounded-3xl border border-slate-100 dark:border-slate-800/80 animate-fade-in">
                            <p class="text-rose-500 dark:text-rose-400 font-black text-xs uppercase tracking-wider">Yah, orangnya kagak ketemu 🕵️‍♂️</p>
                        </div>`;
                    return;
                }

                let html = `<p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest px-1 mb-2">Hasil pencarian buat: "${keyword}"</p>`;
                
                users.forEach(user => {
                    const avatarUrl = user.photo ? `/${user.photo}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=8b5cf6&color=ffffff&rounded=true`;
                    
                    html += `
                        <div class="animate-fade-in flex items-center justify-between gap-4 p-4 bg-white dark:bg-[#161245] rounded-2xl border border-slate-100 dark:border-slate-800/80 transition-all hover:translate-x-1">
                            <div class="flex items-center gap-3 min-w-0">
                                <img src="${avatarUrl}" class="h-10 w-10 rounded-full object-cover border border-slate-100 dark:border-slate-700 shrink-0" />
                                <div class="min-w-0">
                                    <h3 class="font-black text-xs text-purple-950 dark:text-white truncate">${user.name}</h3>
                                    <p class="text-[10px] text-slate-400 dark:text-slate-500 font-medium truncate">Mahasiswa Universitas Lampung</p>
                                </div>
                            </div>
                            <a href="/profile/${user.id}" class="shrink-0 px-4 py-1.5 rounded-xl bg-purple-600 text-white text-[11px] font-black hover:bg-purple-700 transition-all shadow-md shadow-purple-200 dark:shadow-none">
                                Profil
                            </a>
                        </div>
                    `;
                });

                searchResults.innerHTML = html;
            });
        });
    </script>
</body>
</html>
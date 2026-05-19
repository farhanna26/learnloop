<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cari Mahasiswa | LearnLoop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .glass-effect { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-3px); box-shadow: 0 10px 20px -5px rgb(0 0 0 / 0.05); }
    </style>
</head>
<body class="min-h-screen text-slate-900">

    <header class="sticky top-0 z-50 border-b border-slate-200 glass-effect">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6">
            <div class="flex items-center gap-2">
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
                    <img src="{{ Auth::user()->photo ? asset(Auth::user()->photo) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name ?? 'User').'&background=8b5cf6&color=ffffff&rounded=true' }}" 
                         class="h-9 w-9 rounded-xl object-cover shadow-sm border border-violet-100" />
                </a>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-8 pb-24 sm:px-6">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
            
            <aside class="hidden lg:col-span-3 lg:block">
                <div class="sticky top-28 space-y-4">
                    <nav class="space-y-1">
                        <a href="/beranda" class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium text-slate-600 transition-all hover:bg-slate-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Beranda
                        </a>
                        <a href="/contacts" class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium text-slate-600 transition-all hover:bg-slate-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            Pesan
                        </a>
                        <a href="/search" class="group flex items-center gap-3 rounded-2xl bg-violet-50 px-4 py-3 text-sm font-bold text-violet-700 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            Search
                        </a>
                        <a href="/notifications" class="group flex items-center justify-between rounded-2xl px-4 py-3 text-sm font-medium text-slate-600 transition-all hover:bg-slate-100">
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                                Notifikasi
                            </div>
                        </a>
                        <a href="/profile" class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium text-slate-600 transition-all hover:bg-slate-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            Profil
                        </a>
                    </nav>
                </div>
            </aside>

            <section class="lg:col-span-6 space-y-6">
                <div class="rounded-[32px] bg-white border border-slate-200 p-8 shadow-sm">
                    <h1 class="text-2xl font-extrabold text-slate-900 mb-2">Cari Mahasiswa 👋</h1>
                    <p class="text-sm text-slate-500 mb-6">Temukan teman kolaborasi atau sekedar berbagi materi.</p>
                    
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                        <input type="text" id="search-input" placeholder="Cari temanmu..." 
                               class="w-full rounded-2xl border border-slate-200 bg-slate-50 py-4 pl-12 pr-4 text-sm outline-none focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 transition-all" autocomplete="off">
                    </div>
                </div>

                <div id="search-results" class="space-y-4">
                    <div id="initial-placeholder" class="text-center py-20 bg-white rounded-[32px] border border-slate-200">
                        <div class="flex justify-center mb-4 text-slate-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        </div>
                        <p class="text-slate-500 font-medium italic">Ketik sesuatu buat cari temen belajar.</p>
                    </div>
                </div>
            </section>

            <aside class="hidden lg:col-span-3 lg:block"></aside>
        </div>
    </main>

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
                        <div class="text-center py-12 bg-white rounded-[32px] border border-slate-200">
                            <p class="text-red-500 font-bold">Yah, orangnya kagak ketemu 🕵️‍♂️</p>
                        </div>`;
                    return;
                }

                let html = `<p class="text-xs font-bold text-slate-400 uppercase tracking-widest px-4 mb-4">Hasil pencarian buat: "${keyword}"</p>`;
                
                users.forEach(user => {
                    const avatarUrl = user.photo ? `/${user.photo}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=8b5cf6&color=ffffff&rounded=true`;
                    
                    html += `
                        <div class="card-hover flex items-center justify-between p-5 bg-white rounded-[28px] border border-slate-200 shadow-sm transition-all">
                            <div class="flex items-center gap-4">
                                <img src="${avatarUrl}" class="h-12 w-12 rounded-full object-cover border border-slate-100 shadow-sm" />
                                <div>
                                    <h3 class="font-bold text-slate-900">${user.name}</h3>
                                    <p class="text-[11px] text-slate-400 font-medium">Mahasiswa Universitas Lampung</p>
                                </div>
                            </div>
                            <a href="/profile/${user.id}" class="rounded-xl bg-violet-600 px-5 py-2 text-xs font-bold text-white hover:bg-violet-700 transition-all shadow-md shadow-violet-100">
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
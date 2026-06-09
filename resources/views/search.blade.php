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
        * { box-sizing: border-box; }
        html, body { height: 100%; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8F7FF; display: flex; }

        #sidebar {
            position: fixed; top: 0; left: 0;
            width: 260px; height: 100vh;
            background: #ffffff;
            border-right: 1px solid #ede9fe;
            display: flex; flex-direction: column;
            z-index: 40; overflow-y: auto;
        }
        #app-content {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            width: 100%;
        }
        .sidebar-link {
            display: flex; align-items: center; gap: 12px;
            padding: 9px 12px; border-radius: 10px;
            font-size: 14px; font-weight: 600; color: #475569;
            transition: all 0.15s ease; text-decoration: none;
        }
       .sidebar-link:hover { background: transparent; color: #7c3aed; }
        .sidebar-link.active { background: #ede9fe; color: #7c3aed; }
        .sidebar-link svg { width: 18px; height: 18px; flex-shrink: 0; opacity: 0.65; }
        .sidebar-link.active svg, .sidebar-link:hover svg { opacity: 1; }
        .notif-badge {
            margin-left: auto; background: #7c3aed; color: white;
            border-radius: 999px; font-size: 10px; font-weight: 700;
            min-width: 18px; height: 18px;
            display: flex; align-items: center; justify-content: center; padding: 0 5px;
        }
        #top-header {
            position: sticky; top: 0; z-index: 30;
            background: rgba(248,247,255,0.92);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid #ede9fe;
            padding: 12px 32px;
            display: flex; align-items: center; justify-content: flex-end;
        }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-3px); box-shadow: 0 10px 20px -5px rgb(0 0 0 / 0.05); }

        @media (max-width: 1023px) {
            #sidebar { display: none; }
            #app-content { margin-left: 0; }
            #top-header { justify-content: space-between; }
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<aside id="sidebar">
    <a href="/beranda" style="display:flex;align-items:center;gap:10px;padding:20px 20px 16px;border-bottom:1px solid #f5f3ff;text-decoration:none;">
        <div style="width:36px;height:36px;background:#7c3aed;border-radius:10px;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 10px rgba(124,58,237,0.3);flex-shrink:0;">
            <span style="font-size:16px;font-weight:800;color:white;">L</span>
        </div>
        <span style="font-size:17px;font-weight:800;color:#0f172a;letter-spacing:-0.3px;">LearnLoop</span>
    </a>

    <nav style="padding:8px 12px;flex:1;">
        <a href="/beranda" class="sidebar-link {{ request()->is('beranda*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Beranda
        </a>

        <a href="/contacts" class="sidebar-link {{ request()->is('contacts*') || request()->is('chat*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
            </svg>
            Pesan
        </a>

        <a href="/search" class="sidebar-link {{ request()->is('search*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            Search
        </a>

        <a href="/upload" class="sidebar-link {{ request()->is('upload*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m7-7H5"/>
            </svg>
            Upload Konten
        </a>

        <div style="height:8px;"></div>

        <a href="/notifications" class="sidebar-link {{ request()->is('notifications*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            Notifikasi
            @php $unreadCount = auth()->user()->unreadNotificationsCount(); @endphp
            @if($unreadCount > 0)
                <span class="notif-badge">{{ $unreadCount }}</span>
            @endif
        </a>

        <a href="/leaderboard" class="sidebar-link {{ request()->is('leaderboard*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
            </svg>
            Leaderboard
        </a>

        <a href="/profile" class="sidebar-link {{ request()->is('profile*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            Profil
        </a>
    </nav>

    <div style="padding:12px;border-top:1px solid #f5f3ff;">
        <a href="/profile" style="display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:10px;text-decoration:none;transition:background 0.15s;" onmouseover="this.style.background='#f5f3ff'" onmouseout="this.style.background='transparent'">
            <img src="{{ Auth::user()->photo ? asset(Auth::user()->photo) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name ?? 'User').'&background=7c3aed&color=ffffff&rounded=true' }}"
                 class="w-9 h-9 rounded-full object-cover border border-[#c4b5fd] flex-shrink-0" />
            <div style="overflow:hidden;">
                <p style="font-size:13px;font-weight:700;color:#1e293b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin:0;">{{ Auth::user()->name ?? 'User' }}</p>
                <p style="font-size:11px;color:#94a3b8;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin:0;">{{ Auth::user()->email ?? '' }}</p>
            </div>
        </a>
    </div>
</aside>

<!-- KONTEN UTAMA -->
<div id="app-content">

    <header id="top-header">
        <a href="#" class="flex items-center gap-2 lg:hidden">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#7c3aed]">
                <span class="text-sm font-bold text-white">L</span>
            </div>
            <span class="text-lg font-extrabold text-slate-900">LearnLoop</span>
        </a>
        <a href="/profile" class="transition-transform hover:scale-110 active:scale-95">
            <img src="{{ Auth::user()->photo ? asset(Auth::user()->photo) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name ?? 'User').'&background=7c3aed&color=ffffff&rounded=true' }}"
                 class="h-9 w-9 rounded-xl object-cover shadow-sm border border-[#c4b5fd]" title="Lihat Profil" />
        </a>
    </header>

    <main class="flex-1 px-8 py-8 pb-24 max-w-2xl w-full mx-auto">

        <div class="rounded-[32px] bg-white border border-slate-200 p-8 shadow-sm mb-6">
            <h1 class="text-2xl font-extrabold text-slate-900 mb-2">Cari Mahasiswa 👋</h1>
            <p class="text-sm text-slate-500 mb-6">Temukan teman kolaborasi atau sekedar berbagi materi.</p>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" id="search-input" placeholder="Cari temanmu..."
                       class="w-full rounded-2xl border border-slate-200 bg-slate-50 py-4 pl-12 pr-4 text-sm outline-none focus:border-[#7c3aed] focus:ring-4 focus:ring-[#7c3aed]/10 transition-all" autocomplete="off">
            </div>
        </div>

        <div id="search-results" class="space-y-4">
            <div id="initial-placeholder" class="text-center py-20 bg-white rounded-[32px] border border-slate-200">
                <div class="flex justify-center mb-4 text-slate-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <p class="text-slate-500 font-medium italic">Ketik sesuatu buat cari temen belajar.</p>
            </div>
        </div>

    </main>
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
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
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
                const avatarUrl = user.photo ? `/${user.photo}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=7c3aed&color=ffffff&rounded=true`;

                html += `
                    <div class="card-hover flex items-center justify-between p-5 bg-white rounded-[28px] border border-slate-200 shadow-sm">
                        <div class="flex items-center gap-4">
                            <img src="${avatarUrl}" class="h-12 w-12 rounded-full object-cover border border-slate-100 shadow-sm" />
                            <div>
                                <h3 class="font-bold text-slate-900">${user.name}</h3>
                                <p class="text-[11px] text-slate-400 font-medium">Mahasiswa</p>
                            </div>
                        </div>
                        <a href="/profile/${user.id}" class="rounded-xl bg-[#7c3aed] px-5 py-2 text-xs font-bold text-white hover:bg-[#6d28d9] transition-all shadow-md shadow-[#c4b5fd]">
                            Profil
                        </a>
                    </div>`;
            });

            searchResults.innerHTML = html;
        });
    });
</script>

</body>
</html>
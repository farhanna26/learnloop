<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Leaderboard | LearnLoop</title>
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
        .sidebar-link:hover { background: #f5f3ff; color: #1e293b; }
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
        .podium-1 { transform: scale(1.15); z-index: 10; margin-bottom: 2rem; }
        .podium-2 { margin-bottom: 0.5rem; }
        .podium-3 { margin-bottom: -0.5rem; }

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

    <main class="flex-1 px-8 py-8 pb-24 w-full max-w-5xl mx-auto">

        <div class="bg-white rounded-[32px] border border-slate-200 p-8 shadow-sm min-h-[70vh]">

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900">Papan Peringkat 🏆</h1>
                    <p class="text-sm text-slate-500 mt-1">Siapa yang paling ambis hari ini?</p>
                </div>

                <div class="flex bg-slate-100 p-1 rounded-2xl shrink-0">
                    <button onclick="changeTime('today')" id="btn-today" class="time-btn px-4 py-2 text-xs font-bold rounded-xl transition-all text-slate-500 hover:text-slate-900">Hari Ini</button>
                    <button onclick="changeTime('week')" id="btn-week" class="time-btn px-4 py-2 text-xs font-bold rounded-xl transition-all text-slate-500 hover:text-slate-900">Minggu Ini</button>
                    <button onclick="changeTime('month')" id="btn-month" class="time-btn px-4 py-2 text-xs font-bold rounded-xl transition-all bg-white shadow-sm text-slate-900">Bulan Ini</button>
                </div>
            </div>

            <div class="flex border-b border-slate-200 mb-12">
                <button onclick="changeCategory('pembelajaran')" id="tab-pembelajaran" class="cat-tab flex-1 py-4 text-sm font-bold border-b-4 border-[#7c3aed] text-[#7c3aed] transition-colors">
                    📚 Poin Pembelajaran (Tugas)
                </button>
                <button onclick="changeCategory('portofolio')" id="tab-portofolio" class="cat-tab flex-1 py-4 text-sm font-bold border-b-4 border-transparent text-slate-500 hover:text-slate-900 transition-colors">
                    🎨 Poin Portofolio (Postingan)
                </button>
            </div>

            <div id="loading" class="hidden py-20 w-full text-center">
                <svg class="animate-spin h-10 w-10 text-[#7c3aed] mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="text-sm font-bold text-slate-400">Menghitung skor...</p>
            </div>

            <div id="leaderboard-content" class="transition-opacity duration-300">
                <div id="podium-container" class="flex justify-center items-end gap-2 sm:gap-6 mb-12 min-h-[200px]"></div>

                <div class="bg-slate-50 rounded-3xl p-6 border border-slate-100">
                    <div class="flex px-4 pb-4 border-b border-slate-200 text-xs font-extrabold text-slate-900 uppercase tracking-wider mb-4">
                        <div class="w-16">Rank</div>
                        <div class="flex-1">Mahasiswa</div>
                        <div class="text-right">Skor Total</div>
                    </div>
                    <div id="list-container" class="space-y-3"></div>
                </div>
            </div>

        </div>

    </main>
</div>

<script>
    let currentCategory = 'pembelajaran';
    let currentTime = 'month';

    async function fetchLeaderboard() {
        document.getElementById('loading').classList.remove('hidden');
        document.getElementById('leaderboard-content').style.opacity = '0';

        try {
            const response = await fetch(`/leaderboard/data?category=${currentCategory}&time=${currentTime}&_=${new Date().getTime()}`);
            const result = await response.json();
            if (result.success) {
                renderUI(result.data);
            }
        } catch (error) {
            console.error("Error fetching data:", error);
        } finally {
            document.getElementById('loading').classList.add('hidden');
            document.getElementById('leaderboard-content').style.opacity = '1';
        }
    }

    function renderUI(data) {
        const podiumContainer = document.getElementById('podium-container');
        const listContainer = document.getElementById('list-container');

        podiumContainer.innerHTML = '';
        listContainer.innerHTML = '';

        if (data.length === 0) {
            podiumContainer.innerHTML = `<div class="text-center w-full py-10 text-slate-400 font-medium">Belum ada skor yang tercatat. Ayo jadi yang pertama!</div>`;
            return;
        }

        const getPhoto = (name, photo) => {
            if (!photo) return `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=f1f5f9&color=64748b&bold=true`;
            return photo.startsWith('http') ? photo : (photo.startsWith('profile-photos') ? `/${photo}` : `/storage/${photo}`);
        };

        const top3 = [data[1], data[0], data[2]];
        const podiumOrder = [2, 1, 3];
        const medalColors = ['bg-slate-200 text-slate-700', 'bg-amber-400 text-white', 'bg-orange-300 text-white'];

        top3.forEach((user, index) => {
            if (!user) return;
            const rank = podiumOrder[index];
            const html = `
                <div class="flex flex-col items-center podium-${rank} w-24 sm:w-32">
                    <div class="relative mb-3">
                        <img src="${getPhoto(user.name, user.photo)}" class="w-16 h-16 sm:w-20 sm:h-20 rounded-full object-cover ring-4 ${rank === 1 ? 'ring-amber-400' : (rank === 2 ? 'ring-slate-300' : 'ring-orange-300')} shadow-lg">
                        <div class="absolute -bottom-3 left-1/2 -translate-x-1/2 w-8 h-8 rounded-full ${medalColors[index]} flex items-center justify-center text-sm font-extrabold shadow-md border-2 border-white z-10">
                            ${rank}
                        </div>
                        ${rank === 1 ? '<div class="absolute -top-6 left-1/2 -translate-x-1/2 text-3xl">👑</div>' : ''}
                    </div>
                    <h3 class="font-extrabold text-slate-900 text-xs sm:text-sm text-center line-clamp-1 w-full px-1">${user.name}</h3>
                    <p class="text-[10px] sm:text-xs font-bold text-slate-900 mt-0.5">${user.score} Pts</p>
                </div>`;
            podiumContainer.innerHTML += html;
        });

        const restOfUsers = data.slice(3);
        if (restOfUsers.length === 0 && data.length <= 3) {
            listContainer.innerHTML = `<div class="text-center py-4 text-xs font-bold text-slate-400">Hanya ada ${data.length} peringkat saat ini.</div>`;
        }

        restOfUsers.forEach((user, index) => {
            const rank = index + 4;
            const html = `
                <div class="flex items-center bg-white p-3 rounded-2xl shadow-sm border border-slate-100 transition-transform hover:-translate-y-1">
                    <div class="w-16 text-center font-extrabold text-slate-900 text-sm">#${rank}</div>
                    <div class="flex-1 flex items-center gap-3">
                        <img src="${getPhoto(user.name, user.photo)}" class="w-10 h-10 rounded-full object-cover ring-2 ring-slate-50">
                        <span class="font-bold text-slate-900 text-sm">${user.name}</span>
                    </div>
                    <div class="font-extrabold text-slate-900 text-sm pr-4">${user.score}</div>
                </div>`;
            listContainer.innerHTML += html;
        });
    }

    function changeTime(time) {
        currentTime = time;
        document.querySelectorAll('.time-btn').forEach(btn => {
            btn.className = 'time-btn px-4 py-2 text-xs font-bold rounded-xl transition-all text-slate-500 hover:text-slate-900';
        });
        document.getElementById(`btn-${time}`).className = 'time-btn px-4 py-2 text-xs font-bold rounded-xl transition-all bg-white shadow-sm text-slate-900';
        fetchLeaderboard();
    }

    function changeCategory(cat) {
        currentCategory = cat;
        document.querySelectorAll('.cat-tab').forEach(tab => {
            tab.className = 'cat-tab flex-1 py-4 text-sm font-bold border-b-4 border-transparent text-slate-500 hover:text-slate-900 transition-colors';
        });
        document.getElementById(`tab-${cat}`).className = 'cat-tab flex-1 py-4 text-sm font-bold border-b-4 border-[#7c3aed] text-[#7c3aed] transition-colors';
        fetchLeaderboard();
    }

    document.addEventListener("DOMContentLoaded", fetchLeaderboard);
</script>

</body>
</html>
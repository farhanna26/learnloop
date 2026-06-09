<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LearnLoop | Platform Kolaborasi Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://api.fontshare.com/v2/css?f[]=satoshi@400,500,700,900&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        html, body { height: 100%; margin: 0; padding: 0; }
        body {
            font-family: 'Satoshi', sans-serif;
            background-color: #F8F7FF;
            display: flex;
            flex-direction: column;
        }

        /* ── SCROLLBAR ── */
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #c4b5fd; border-radius: 10px; }

        /* ── ANIMATIONS ── */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeIn 0.4s ease-out forwards; }

        .card-hover { transition: all 0.25s cubic-bezier(0.4,0,0.2,1); }
        .card-hover:hover { transform: translateY(-2px); box-shadow: 0 10px 24px -4px rgba(109,40,217,0.10); }

        /* ── APP SHELL ── */
        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100vh;
            background: #ffffff;
            border-right: 1px solid #ede9fe;
            display: flex;
            flex-direction: column;
            z-index: 40;
            overflow-y: auto;
        }

        #app-content {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── SIDEBAR ITEMS ── */
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 20px 20px 16px;
            border-bottom: 1px solid #f5f3ff;
            text-decoration: none;
        }
        .sidebar-logo-icon {
            width: 36px; height: 36px;
            background: #7c3aed;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 10px rgba(124,58,237,0.3);
            flex-shrink: 0;
        }
        .sidebar-logo-text {
            font-size: 17px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.3px;
        }

        .sidebar-section-label {
            font-size: 10px;
            font-weight: 700;
            color: #94a3b8;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 16px 20px 6px;
        }

        .sidebar-nav { padding: 8px 12px; flex: 1; }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 9px 12px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            color: #475569;
            transition: all 0.15s ease;
            width: 100%;
            text-decoration: none;
            position: relative;
        }

       .sidebar-link:hover {
    background: transparent;   /* hapus background */
    color: #7c3aed;            /* hanya warna teks yang berubah */
}
        }
        .sidebar-link.active {
            background: #ede9fe;
            color: #7c3aed;
        }
        .sidebar-link svg {
            width: 18px; height: 18px;
            flex-shrink: 0;
            opacity: 0.65;
        }
        .sidebar-link.active svg,
        .sidebar-link:hover svg { opacity: 1; }

        .sidebar-upload-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 9px 12px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            color: #475569;
            background: transparent;
            border: none;
            transition: all 0.15s ease;
            width: 100%;
            cursor: pointer;
            text-align: left;
        }
        
        .sidebar-upload-btn:hover {
    background: transparent;   /* hapus background */
    color: #7c3aed;
}
        .sidebar-upload-btn svg {
            width: 18px; height: 18px;
            flex-shrink: 0;
            opacity: 0.65;
        }

        .notif-badge {
            margin-left: auto;
            background: #7c3aed;
            color: white;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 5px;
        }

        .sidebar-footer {
            padding: 12px;
            border-top: 1px solid #f5f3ff;
        }
        .sidebar-user-card {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            text-decoration: none;
            transition: background 0.15s;
        }
        .sidebar-user-card:hover { background: #f5f3ff; }

        /* ── FEED TABS ── */
        .feed-tab-active {
            background: #7c3aed;
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(124,58,237,0.30);
        }
        .feed-tab-inactive {
            background: transparent;
            color: #64748b;
        }
        .feed-tab-inactive:hover {
            background: #f5f3ff;
            color: #7c3aed;
        }

        /* ── HEADER ── */
        #top-header {
            position: sticky;
            top: 0;
            z-index: 30;
            background: rgba(248,247,255,0.92);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid #ede9fe;
            padding: 12px 32px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        /* ── WELCOME BANNER MODERN ── */
        .welcome-banner {
            position: relative;
            overflow: hidden;
            border-radius: 28px;
            padding: 48px 48px;
            margin-bottom: 24px;
            background: linear-gradient(135deg, #1e0a3c 0%, #2d1458 40%, #4c1d95 70%, #6d28d9 100%);
        }
        .welcome-banner::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse at 20% 50%, rgba(124,58,237,0.45) 0%, transparent 55%),
                radial-gradient(ellipse at 80% 20%, rgba(139,92,246,0.5) 0%, transparent 50%),
                radial-gradient(ellipse at 90% 80%, rgba(76,29,149,0.6) 0%, transparent 45%),
                radial-gradient(ellipse at 10% 90%, rgba(167,139,250,0.25) 0%, transparent 40%);
            pointer-events: none;
        }
        .welcome-banner::after {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 220px; height: 220px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,255,255,0.06) 0%, transparent 70%);
            pointer-events: none;
        }
        .banner-orb {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }
        .banner-orb-1 {
            width: 120px; height: 120px;
            bottom: -30px; left: 40%;
            background: radial-gradient(circle, rgba(139,92,246,0.35) 0%, transparent 70%);
            filter: blur(20px);
        }
        .banner-orb-2 {
            width: 80px; height: 80px;
            top: 10px; right: 25%;
            background: radial-gradient(circle, rgba(196,181,253,0.25) 0%, transparent 70%);
            filter: blur(15px);
        }
        .banner-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 32px 32px;
            pointer-events: none;
        }
        .banner-content {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: flex-start;
            gap: 18px;
        }
        .banner-icon {
            width: 52px; height: 52px;
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, rgba(124,58,237,0.9), rgba(167,139,250,0.7));
            box-shadow: 0 8px 24px rgba(124,58,237,0.4), inset 0 1px 0 rgba(255,255,255,0.2);
            flex-shrink: 0;
        }
        .banner-title {
            font-size: 22px;
            font-weight: 900;
            color: #ffffff;
            letter-spacing: -0.5px;
            line-height: 1.2;
            margin-bottom: 6px;
        }
        .banner-title span {
            background: linear-gradient(90deg, #c4b5fd, #a78bfa, #ddd6fe);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .banner-subtitle {
            font-size: 13px;
            font-weight: 500;
            color: rgba(255,255,255,0.55);
            line-height: 1.5;
        }
        .banner-pills {
            display: flex;
            gap: 8px;
            margin-top: 14px;
            flex-wrap: wrap;
        }
        .banner-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            color: rgba(255,255,255,0.7);
            letter-spacing: 0.02em;
        }
        .banner-pill-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
        }

        /* ── ACTION BUTTONS (Like & Comment) ── */
        .action-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            color: #64748b;
            background: transparent;
            border: 1.5px solid #e2e8f0;
            cursor: pointer;
            transition: all 0.18s ease;
            letter-spacing: -0.01em;
        }
        .action-btn:hover {
            background: #f5f3ff;
            border-color: #c4b5fd;
            color: #7c3aed;
        }
        .action-btn.liked {
            color: #e11d48;
            border-color: #fecdd3;
            background: #fff1f2;
        }
        .action-btn svg {
            width: 16px; height: 16px;
            stroke-width: 1.8;
            transition: transform 0.15s ease;
        }
        .action-btn:hover svg { transform: scale(1.15); }
        .action-btn.liked svg { fill: #e11d48; stroke: #e11d48; }

        /* ── POST MENU (3-dot) ── */
        .post-menu-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px; height: 32px;
            border-radius: 8px;
            border: none;
            background: transparent;
            color: #94a3b8;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .post-menu-btn:hover {
            background: #f5f3ff;
            color: #7c3aed;
        }
        .post-menu-dropdown {
            position: absolute;
            right: 0; top: 38px;
            background: white;
            border: 1px solid #ede9fe;
            border-radius: 14px;
            box-shadow: 0 8px 24px rgba(109,40,217,0.12);
            overflow: hidden;
            z-index: 100;
            min-width: 140px;
        }
        .post-menu-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.12s;
            border: none;
            background: transparent;
            width: 100%;
            text-align: left;
        }
        .post-menu-item:hover { background: #f5f3ff; }
        .post-menu-item.danger { color: #ef4444; }
        .post-menu-item.danger:hover { background: #fff1f2; }
        .post-menu-item svg { width: 15px; height: 15px; }

        /* ── EDIT MODAL ── */
        #editPostModal {
            display: none;
        }
        #editPostModal.show {
            display: flex;
        }

        /* ── RESPONSIVE ── */
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
    <a href="/beranda" class="sidebar-logo">
        <div class="sidebar-logo-icon">
            <span style="font-size:16px;font-weight:800;color:white;">L</span>
        </div>
        <span class="sidebar-logo-text">LearnLoop</span>
    </a>

    <nav class="sidebar-nav">
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

        <input type="file" id="fileInput" class="hidden" accept="image/*,video/*,.pdf">
        <button id="uploadBtn" class="sidebar-upload-btn">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m7-7H5"/>
            </svg>
            Upload Konten
        </button>

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

    <div class="sidebar-footer">
        <a href="/profile" class="sidebar-user-card">
            <img src="{{ Auth::user()->photo ? asset(Auth::user()->photo) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name ?? 'User').'&background=7c3aed&color=ffffff&rounded=true' }}"
                 class="w-9 h-9 rounded-full object-cover border border-[#c4b5fd] flex-shrink-0" />
            <div style="overflow:hidden;">
                <p style="font-size:13px;font-weight:700;color:#1e293b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    {{ Auth::user()->name ?? 'User' }}
                </p>
                <p style="font-size:11px;color:#94a3b8;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    {{ Auth::user()->email ?? '' }}
                </p>
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

    <main style="flex:1; padding: 28px 32px 80px; max-width: 960px; width: 100%; margin: 0 auto;">

        @if(session('success'))
            <div class="animate-fade-in flex items-center gap-3 rounded-2xl border border-emerald-100 bg-emerald-50 p-4 text-sm font-bold text-emerald-700 shadow-sm mb-6">
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-200/50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                {{ session('success') }}
            </div>
        @endif

        <!-- ══ WELCOME BANNER MODERN ══ -->
        <div class="welcome-banner mb-6">
            <div class="banner-grid"></div>
            <div class="banner-orb banner-orb-1"></div>
            <div class="banner-orb banner-orb-2"></div>

            <div class="banner-content">
                <div class="banner-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div>
                    <h1 class="banner-title">Halo, <span>Mahasiswa Kreatif!</span></h1>
                    <p class="banner-subtitle">Bagikan materi atau hasil karyamu hari ini — ilmu yang dibagi, nilainya berlipat.</p>
                    <div class="banner-pills">
                        <span class="banner-pill">
                            <span class="banner-pill-dot" style="background:#ffffff;"></span>
                            Komunitas Aktif
                        </span>
                        <span class="banner-pill">
                            <span class="banner-pill-dot" style="background:#ffffff;"></span>
                            Materi Terkurasi
                        </span>
                        <span class="banner-pill">
                            <span class="banner-pill-dot" style="background:#ffffff;"></span>
                            Kolaborasi Real-time
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Row -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 animate-fade-in">
            <div class="flex items-center gap-1 bg-white p-2 rounded-2xl border border-[#ede9fe] shadow-sm w-fit">
                <button id="tab-portfolio" onclick="switchFeedType('portfolio')"
                    class="feed-tab-active px-7 py-3 rounded-xl text-sm font-bold transition-all">
                    <span class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Portofolio
                    </span>
                </button>
                <button id="tab-learning" onclick="switchFeedType('learning')"
                    class="feed-tab-inactive px-7 py-3 rounded-xl text-sm font-bold transition-all">
                    <span class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14v6.5"/>
                        </svg>
                        Pembelajaran
                    </span>
                </button>
            </div>

            @if(auth()->user()->role === 'creator')
                <button onclick="document.getElementById('learningUploadModal').classList.remove('hidden')"
                    class="flex items-center gap-2 bg-[#7c3aed] hover:bg-[#6d28d9] text-white px-5 py-3 rounded-xl font-bold text-sm transition-all shadow-md shadow-[#c4b5fd] active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Upload Materi Pembelajaran
                </button>
            @endif
        </div>

        <!-- Posts -->
        <div id="postsWrapper" class="space-y-5"></div>

        <div id="loadingIndicator" class="hidden text-center py-6">
            <div class="inline-block animate-spin">
                <svg class="h-6 w-6 text-[#7c3aed]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </div>

        

    </main>
</div>


<!-- MODALS -->

<!-- Upload Modal -->
<div id="uploadModal" class="fixed inset-0 z-[60] hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
    <div class="w-full max-w-lg rounded-[32px] bg-white p-8 shadow-2xl">
        <h3 class="text-xl font-bold mb-6">Posting Konten Baru</h3>
        <div id="previewArea" class="mb-4 rounded-2xl bg-slate-50 border-2 border-dashed border-slate-200 min-h-[150px] flex items-center justify-center overflow-hidden"></div>
        <textarea id="captionText" rows="3" class="w-full rounded-2xl border border-slate-200 p-4 text-sm outline-none focus:border-[#7c3aed] transition-all" placeholder="Tulis deskripsi postingan..."></textarea>
        <button id="submitUpload" class="mt-6 w-full rounded-2xl bg-[#7c3aed] py-4 text-sm font-bold text-white hover:bg-[#6d28d9] transition-all">Posting Sekarang</button>
        <button id="closeModal" class="w-full mt-2 text-sm text-slate-400 font-medium py-2 hover:text-slate-600">Batal</button>
    </div>
</div>

<!-- Comment Modal -->
<div id="commentModal" class="fixed inset-0 z-[70] hidden flex items-end justify-center sm:items-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all">
    <div class="w-full max-w-lg rounded-t-[32px] sm:rounded-[32px] bg-white flex flex-col shadow-2xl overflow-hidden max-h-[80vh]">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-white shrink-0">
            <h3 class="font-bold text-lg text-slate-900">Komentar</h3>
            <button id="closeCommentModal" class="text-slate-400 hover:text-slate-600 p-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <div id="commentsList" class="p-6 overflow-y-auto custom-scrollbar flex-1 space-y-5 bg-slate-50"></div>
        <div id="replyInfo" class="hidden px-5 py-2 bg-[#f5f3ff] border-x border-t border-slate-100 flex justify-between items-center shrink-0">
            <p class="text-[10px] font-bold text-[#7c3aed]">Membalas: <span id="replyTargetName"></span></p>
            <button type="button" onclick="cancelReply()" class="text-[10px] text-red-400 hover:text-red-600">Batal</button>
        </div>
        <div class="p-4 bg-white border-t border-slate-100 shrink-0">
            <form id="commentForm" class="flex items-center gap-3">
                <input type="text" id="commentInput" placeholder="Tulis komentar..." class="w-full bg-slate-100 border-transparent focus:bg-white focus:border-[#7c3aed] focus:ring-2 focus:ring-[#c4b5fd] rounded-full pl-5 pr-4 py-3 text-sm transition-all outline-none" required autocomplete="off">
                <button type="submit" class="bg-[#7c3aed] hover:bg-[#6d28d9] text-white rounded-2xl h-12 w-12 flex items-center justify-center transition-all hover:scale-105 active:scale-95 shadow-lg shadow-[#c4b5fd] shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Learning Upload Modal -->
<div id="learningUploadModal" class="fixed inset-0 z-[60] hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
    <div class="w-full max-w-lg rounded-[32px] bg-white p-8 shadow-2xl">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-extrabold text-slate-900">Upload Materi Baru</h3>
            <button onclick="document.getElementById('learningUploadModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 bg-slate-50 hover:bg-slate-100 p-2 rounded-full transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        @php $categories = \App\Models\Category::all(); @endphp
        <form id="learningUploadForm" onsubmit="submitLearningPost(event)">
            <div class="mb-4">
                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Kategori Materi</label>
                <select id="learningCategory" class="w-full rounded-2xl border border-slate-200 p-3.5 text-sm font-medium outline-none focus:border-[#7c3aed] focus:ring-4 focus:ring-[#7c3aed]/10 transition-all bg-slate-50 cursor-pointer" required>
                    <option value="" disabled selected>Pilih Kategori Pembelajaran...</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Judul / Deskripsi Materi</label>
                <textarea id="learningCaption" rows="3" class="w-full rounded-2xl border border-slate-200 p-4 text-sm outline-none focus:border-[#7c3aed] focus:ring-4 focus:ring-[#7c3aed]/10 transition-all bg-slate-50" placeholder="Jelaskan isi materi ini..." required></textarea>
            </div>
            <div class="mb-8">
                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">File Materi (PDF/Video/Gambar)</label>
                <input type="file" id="learningFile" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#ede9fe] file:text-[#7c3aed] hover:file:bg-[#c4b5fd] transition-colors cursor-pointer" accept="image/*,video/*,.pdf" required>
            </div>
            <div class="mb-6 p-4 border border-[#c4b5fd] bg-[#f5f3ff] rounded-2xl">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" id="checkBuatKelas" name="create_class" value="true" class="w-5 h-5 text-[#7c3aed] rounded focus:ring-[#7c3aed]" onchange="document.getElementById('areaNamaKelas').classList.toggle('hidden')">
                    <span class="text-sm font-bold text-slate-900">Sekaligus buat Ruang Kelas Pembelajaran?</span>
                </label>
                <div id="areaNamaKelas" class="hidden mt-3 pt-3 border-t border-[#c4b5fd]">
                    <label class="text-xs font-bold text-[#7c3aed] mb-1 block">Nama Kelas</label>
                    <input type="text" id="inputClassName" name="class_name" placeholder="Misal: Masterclass Laravel Basic..." class="w-full bg-white border border-[#c4b5fd] focus:border-[#7c3aed] focus:ring-4 focus:ring-[#7c3aed]/10 rounded-xl px-4 py-2.5 text-sm outline-none transition-all">
                </div>
            </div>
            <button type="submit" id="btnSubmitLearning" class="w-full rounded-2xl bg-[#7c3aed] py-4 text-sm font-bold text-white hover:bg-[#6d28d9] transition-all shadow-lg shadow-[#c4b5fd] active:scale-95">Upload Materi Sekarang</button>
        </form>
    </div>
</div>

<!-- Edit Post Modal -->
<div id="editPostModal" class="fixed inset-0 z-[80] items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
    <div class="w-full max-w-lg rounded-[32px] bg-white p-8 shadow-2xl">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-extrabold text-slate-900">Edit Postingan</h3>
            <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 bg-slate-50 hover:bg-slate-100 p-2 rounded-full transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <input type="hidden" id="editPostId">
        <div class="mb-4">
            <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Deskripsi Postingan</label>
            <textarea id="editPostContent" rows="4" class="w-full rounded-2xl border border-slate-200 p-4 text-sm outline-none focus:border-[#7c3aed] focus:ring-4 focus:ring-[#7c3aed]/10 transition-all bg-slate-50" placeholder="Tulis deskripsi postingan..."></textarea>
        </div>
        <button onclick="submitEditPost()" id="btnSubmitEdit" class="w-full rounded-2xl bg-[#7c3aed] py-4 text-sm font-bold text-white hover:bg-[#6d28d9] transition-all shadow-lg shadow-[#c4b5fd] active:scale-95">Simpan Perubahan</button>
        <button onclick="closeEditModal()" class="w-full mt-2 text-sm text-slate-400 font-medium py-2 hover:text-slate-600">Batal</button>
    </div>
</div>

<!-- Delete Confirm Modal -->
<div id="deleteConfirmModal" class="fixed inset-0 z-[80] hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
    <div class="w-full max-w-sm rounded-[28px] bg-white p-8 shadow-2xl text-center">
        <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </div>
        <h3 class="text-lg font-extrabold text-slate-900 mb-2">Hapus Postingan?</h3>
        <p class="text-sm text-slate-500 mb-6">Postingan ini akan dihapus permanen dan tidak bisa dikembalikan.</p>
        <input type="hidden" id="deletePostId">
        <div class="flex gap-3">
            <button onclick="document.getElementById('deleteConfirmModal').classList.add('hidden')" class="flex-1 py-3 rounded-2xl border border-slate-200 text-sm font-bold text-slate-600 hover:bg-slate-50 transition-all">Batal</button>
            <button onclick="submitDeletePost()" id="btnConfirmDelete" class="flex-1 py-3 rounded-2xl bg-red-500 hover:bg-red-600 text-white text-sm font-bold transition-all active:scale-95 shadow-lg shadow-red-100">Hapus</button>
        </div>
    </div>
</div>


<script>
    let currentFeedType = 'portfolio';

    function switchFeedType(type) {
        currentFeedType = type;
        const btnPorto = document.getElementById('tab-portfolio');
        const btnLearn = document.getElementById('tab-learning');
        btnPorto.className = "feed-tab-inactive px-7 py-3 rounded-xl text-sm font-bold transition-all";
        btnLearn.className = "feed-tab-inactive px-7 py-3 rounded-xl text-sm font-bold transition-all";
        if(type === 'portfolio') {
            btnPorto.className = "feed-tab-active px-7 py-3 rounded-xl text-sm font-bold transition-all";
        } else {
            btnLearn.className = "feed-tab-active px-7 py-3 rounded-xl text-sm font-bold transition-all";
        }
        postsWrapper.innerHTML = '';
        currentOffset = 0;
        allPostsLoaded = false;
        noMorePosts.classList.add('hidden');
        fetchPosts(0, 5);
    }

    const uploadBtn = document.getElementById('uploadBtn');
    const fileInput = document.getElementById('fileInput');
    const uploadModal = document.getElementById('uploadModal');
    const closeModal = document.getElementById('closeModal');
    const submitUpload = document.getElementById('submitUpload');
    const previewArea = document.getElementById('previewArea');
    const postsWrapper = document.getElementById('postsWrapper');
    const captionText = document.getElementById('captionText');
    const loadingIndicator = document.getElementById('loadingIndicator');
    const noMorePosts = document.getElementById('noMorePosts');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const currentUserId = {{ Auth::id() }};

    const commentModal = document.getElementById('commentModal');
    const closeCommentModal = document.getElementById('closeCommentModal');
    const commentsList = document.getElementById('commentsList');
    const commentForm = document.getElementById('commentForm');
    const commentInput = document.getElementById('commentInput');
    let currentActivePostId = null;
    let globalPostsData = {};
    let currentParentId = null;

    let selectedFileUrl = "";
    let currentOffset = 0;
    let isLoading = false;
    let allPostsLoaded = false;

    function formatTimeAgo(date) {
        const now = new Date();
        const postDate = new Date(date);
        const seconds = Math.floor((now - postDate) / 1000);
        if (seconds < 60) return 'Baru saja';
        if (seconds < 3600) return Math.floor(seconds / 60) + ' menit lalu';
        if (seconds < 86400) return Math.floor(seconds / 3600) + ' jam lalu';
        return Math.floor(seconds / 86400) + ' hari lalu';
    }

    // ── POST MENU HELPERS ──
    function togglePostMenu(postId) {
        const menu = document.getElementById(`post-menu-${postId}`);
        // Close all other menus first
        document.querySelectorAll('.post-menu-dropdown').forEach(m => {
            if (m.id !== `post-menu-${postId}`) m.classList.add('hidden');
        });
        menu.classList.toggle('hidden');
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.post-menu-wrapper')) {
            document.querySelectorAll('.post-menu-dropdown').forEach(m => m.classList.add('hidden'));
        }
    });

    function openEditModal(postId) {
        const post = globalPostsData[postId];
        document.getElementById('editPostId').value = postId;
        document.getElementById('editPostContent').value = post.content;
        document.getElementById('editPostModal').classList.add('show');
        document.querySelectorAll('.post-menu-dropdown').forEach(m => m.classList.add('hidden'));
    }

    function closeEditModal() {
        document.getElementById('editPostModal').classList.remove('show');
    }

    async function submitEditPost() {
        const postId = document.getElementById('editPostId').value;
        const content = document.getElementById('editPostContent').value.trim();
        const btn = document.getElementById('btnSubmitEdit');
        if (!content) return alert("Konten tidak boleh kosong!");
        btn.innerText = "Menyimpan..."; btn.disabled = true;
        try {
            const response = await fetch(`/posts/${postId}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                body: JSON.stringify({ content })
            });
            const result = await response.json();
            if (result.success) {
                globalPostsData[postId].content = content;
                const postEl = document.getElementById(`post-${postId}`);
                if (postEl) {
                    const contentEl = postEl.querySelector('.post-content-text');
                    if (contentEl) contentEl.textContent = content;
                }
                closeEditModal();
            } else {
                alert(result.message || "Gagal mengedit postingan.");
            }
        } catch (error) { alert("Gagal mengedit postingan!"); }
        finally { btn.innerText = "Simpan Perubahan"; btn.disabled = false; }
    }

    function openDeleteModal(postId) {
        document.getElementById('deletePostId').value = postId;
        document.getElementById('deleteConfirmModal').classList.remove('hidden');
        document.querySelectorAll('.post-menu-dropdown').forEach(m => m.classList.add('hidden'));
    }

    async function submitDeletePost() {
        const postId = document.getElementById('deletePostId').value;
        const btn = document.getElementById('btnConfirmDelete');
        btn.innerText = "Menghapus..."; btn.disabled = true;
        try {
            const response = await fetch(`/posts/${postId}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
            });
            const result = await response.json();
            if (result.success) {
                const postEl = document.getElementById(`post-${postId}`);
                if (postEl) {
                    postEl.style.transition = 'all 0.3s ease';
                    postEl.style.opacity = '0';
                    postEl.style.transform = 'translateY(-10px)';
                    setTimeout(() => postEl.remove(), 300);
                }
                delete globalPostsData[postId];
                document.getElementById('deleteConfirmModal').classList.add('hidden');
            } else {
                alert(result.message || "Gagal menghapus postingan.");
            }
        } catch (error) { alert("Gagal menghapus postingan!"); }
        finally { btn.innerText = "Hapus"; btn.disabled = false; }
    }

    function renderPost(post) {
        globalPostsData[post.id] = post;
        const article = document.createElement('article');
        article.className = 'card-hover overflow-hidden rounded-[28px] border border-slate-200 bg-white mb-5';
        article.id = `post-${post.id}`;

        const userName = post.user?.name || 'User';
        const filePath = post.image ? `/storage/${post.image}` : null;

        let roleBadge = '';
        if (post.user?.role === 'creator') {
            roleBadge = `<span class="bg-[#7c3aed] text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full ml-2 align-middle shadow-sm">Creator</span>`;
        } else {
            roleBadge = `<span class="bg-slate-200 text-slate-600 text-[10px] font-bold px-2.5 py-0.5 rounded-full ml-2 align-middle shadow-sm">Learner</span>`;
        }

        const userPhoto = post.user?.photo
            ? `/${post.user.photo}`
            : `https://ui-avatars.com/api/?name=${encodeURIComponent(userName)}&background=7c3aed&color=ffffff&rounded=true`;

        const isVideo = post.image?.match(/\.(mp4|webm|ogg|mov)$/i);
        const isPDF = post.image?.match(/\.(pdf)$/i);
        const isImage = post.image?.match(/\.(jpg|jpeg|png|gif|webp)$/i);

        const isLiked = post.is_liked;

        // Show edit/delete menu only for own posts
        const isOwnPost = post.user_id === currentUserId;
        const menuHtml = isOwnPost ? `
            <div class="post-menu-wrapper relative ml-auto">
                <button class="post-menu-btn" onclick="togglePostMenu(${post.id})" title="Opsi">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="5" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="12" cy="19" r="1.5"/>
                    </svg>
                </button>
                <div id="post-menu-${post.id}" class="post-menu-dropdown hidden">
                    <button class="post-menu-item" onclick="openEditModal(${post.id})">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit
                    </button>
                    <button class="post-menu-item danger" onclick="openDeleteModal(${post.id})">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Hapus
                    </button>
                </div>
            </div>` : '';

        let roomBannerHtml = '';
        if (post.room_id && post.room) {
            let isJoined = false;
            if (post.user_id === currentUserId) {
                isJoined = true;
            } else if (post.room.users) {
                isJoined = post.room.users.some(u => u.id === currentUserId);
            }
            let buttonHtml = '';
            if (isJoined) {
                buttonHtml = `<a href="/chat/${post.room_id}" class="w-full sm:w-auto bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-2.5 rounded-xl text-xs font-extrabold transition-all text-center block">Buka Kelas</a>`;
            } else {
                buttonHtml = `<form action="/chat/join/${post.room_id}" method="POST" class="w-full sm:w-auto shrink-0"><input type="hidden" name="_token" value="${csrfToken}"><button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-xl text-xs font-extrabold shadow-lg shadow-emerald-200 transition-all active:scale-95">Gabung Kelas</button></form>`;
            }
            roomBannerHtml = `
                <div class="mx-5 mb-5 p-4 bg-emerald-50 rounded-2xl border border-emerald-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 shrink-0 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14v6.5"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-extrabold text-emerald-600 uppercase tracking-wider mb-0.5">Ruang Kelas Tersedia</p>
                            <p class="text-sm font-bold text-slate-900 line-clamp-1">${post.room.name}</p>
                        </div>
                    </div>
                    ${buttonHtml}
                </div>`;
        }

        article.innerHTML = `
            <div class="flex items-center gap-3 p-5">
                <a href="/profile/${post.user?.id}" class="shrink-0 transition-transform hover:scale-105">
                    <img src="${userPhoto}" class="h-11 w-11 rounded-full ring-2 ring-[#ede9fe]" />
                </a>
                <div>
                    <div class="flex items-center gap-2">
                        <a href="/profile/${post.user?.id}" class="text-sm font-bold text-slate-900 hover:text-[#7c3aed] hover:underline transition-colors">${userName}</a> ${roleBadge}
                        ${post.type === 'learning' && post.category ? `<span class="bg-[#ede9fe] text-[#7c3aed] text-[9px] font-extrabold px-2 py-0.5 rounded-full uppercase tracking-wider ml-1">${post.category.name}</span>` : ''}
                    </div>
                </div>
                ${menuHtml}
            </div>
            <div class="px-5 pb-4 text-sm text-slate-700 leading-relaxed post-content-text">${post.content}</div>
            ${roomBannerHtml}
            <div class="mx-5 mb-5 overflow-hidden rounded-2xl bg-slate-100 flex items-center justify-center">
                ${isImage && filePath ? `<img src="${filePath}" class="w-full h-auto object-cover max-h-[500px]">` : ''}
                ${isVideo && filePath ? `<video src="${filePath}" controls class="w-full h-auto max-h-[500px] bg-black"></video>` : ''}
                ${isPDF && filePath ? `
                    <div class="w-full flex items-center justify-between p-6 bg-[#f5f3ff] border border-[#c4b5fd] rounded-2xl">
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-12 flex items-center justify-center bg-white rounded-xl shadow-sm text-[#7c3aed] font-bold text-[10px]">PDF</div>
                            <p class="text-sm font-bold text-slate-900 truncate max-w-[150px]">Dokumen Materi</p>
                        </div>
                        <a href="${filePath}" target="_blank" class="rounded-xl bg-[#7c3aed] px-4 py-2 text-xs font-bold text-white hover:bg-[#6d28d9] shadow-lg shadow-[#c4b5fd]">Buka File</a>
                    </div>` : ''}
            </div>
            <div class="border-t border-slate-100 px-5 py-3.5 flex gap-3 text-sm font-bold">
                <button onclick="handleLike(${post.id})" id="like-btn-${post.id}"
                    class="action-btn ${isLiked ? 'liked' : ''}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="${isLiked ? 'currentColor' : 'none'}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                    </svg>
                    <span id="like-count-${post.id}">${post.likes_count || 0}</span>
                </button>
                <button onclick="openCommentModal(${post.id})" class="action-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 01-.923 1.785A5.969 5.969 0 006 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337z"/>
                    </svg>
                    <span id="comment-count-${post.id}">${post.comments_count || 0}</span>
                </button>
            </div>`;
        return article;
    }

    async function handleLike(postId) {
        const btnElement = document.getElementById(`like-btn-${postId}`);
        const countElement = document.getElementById(`like-count-${postId}`);
        const svgEl = btnElement.querySelector('svg');
        try {
            const response = await fetch(`/posts/${postId}/like`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
            });
            const result = await response.json();
            let currentCount = parseInt(countElement.innerText);
            if (result.status === 'liked') {
                btnElement.classList.add('liked');
                svgEl.setAttribute('fill', 'currentColor');
                countElement.innerText = currentCount + 1;
                globalPostsData[postId].is_liked = true;
            } else {
                btnElement.classList.remove('liked');
                svgEl.setAttribute('fill', 'none');
                countElement.innerText = currentCount - 1;
                globalPostsData[postId].is_liked = false;
            }
        } catch (error) { console.error("Gagal melakukan like:", error); }
    }

    function openCommentModal(postId) {
        currentActivePostId = postId;
        const post = globalPostsData[postId];
        commentsList.innerHTML = '';
        if (!post.comments || post.comments.length === 0) {
            commentsList.innerHTML = `<p class="text-center text-sm text-slate-400 mt-10">Belum ada komentar. Jadilah yang pertama!</p>`;
        } else {
            const parentComments = post.comments.filter(c => !c.parent_id || c.parent_id == 0 || c.parent_id == "null");
            const childComments = post.comments.filter(c => c.parent_id && c.parent_id != 0);
            parentComments.forEach(parent => {
                appendCommentToUI(parent, false);
                childComments.filter(child => child.parent_id == parent.id).forEach(child => {
                    appendCommentToUI(child, true);
                });
            });
        }
        commentModal.classList.remove('hidden');
    }

    closeCommentModal.addEventListener('click', () => {
        commentModal.classList.add('hidden');
        currentActivePostId = null;
    });

    function appendCommentToUI(comment, isReply = false) {
        const userName = comment.user?.name || 'User';
        let roleBadgeComment = '';
        if (comment.user?.role === 'creator') {
            roleBadgeComment = `<span class="bg-[#7c3aed] text-white text-[8px] font-bold px-2 py-0.5 rounded-full ml-1.5 align-middle shadow-sm">Creator</span>`;
        } else {
            roleBadgeComment = `<span class="bg-slate-200 text-slate-600 text-[8px] font-bold px-2 py-0.5 rounded-full ml-1.5 align-middle shadow-sm">Learner</span>`;
        }
        const commenterPhoto = comment.user?.photo
            ? `${window.location.origin}/${comment.user.photo}`
            : `https://ui-avatars.com/api/?name=${encodeURIComponent(userName)}&background=e2e8f0&color=475569`;
        const noDataHtml = commentsList.querySelector('p.text-slate-400');
        if (noDataHtml) noDataHtml.remove();
        const commentDiv = document.createElement('div');
        commentDiv.className = `flex gap-3 ${isReply ? 'ml-10 mt-2' : 'mt-5'}`;
        commentDiv.innerHTML = `
            <img src="${commenterPhoto}" class="h-8 w-8 rounded-full shrink-0">
            <div class="bg-white border border-slate-200 rounded-2xl rounded-tl-sm px-4 py-3 shadow-sm flex-1">
                <div class="flex justify-between items-center mb-0.5">
                    <p class="text-[11px] font-bold text-slate-500">${userName} ${roleBadgeComment}</p>
                    ${!isReply ? `<button onclick="setReply(${comment.id}, '${userName}')" class="text-[10px] text-[#7c3aed] hover:underline">Balas</button>` : ''}
                </div>
                <p class="text-sm text-slate-800">${comment.body}</p>
            </div>`;
        commentsList.appendChild(commentDiv);
        commentsList.scrollTop = commentsList.scrollHeight;
    }

    function setReply(commentId, name) {
        currentParentId = commentId;
        document.getElementById('replyTargetName').innerText = name;
        document.getElementById('replyInfo').classList.remove('hidden');
        document.getElementById('commentInput').focus();
    }

    function cancelReply() {
        currentParentId = null;
        document.getElementById('replyInfo').classList.add('hidden');
    }

    commentForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const text = commentInput.value.trim();
        if (!text || !currentActivePostId) return;
        const submitBtn = commentForm.querySelector('button');
        submitBtn.disabled = true;
        try {
            const response = await fetch(`/posts/${currentActivePostId}/comment`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                body: JSON.stringify({ body: text, parent_id: currentParentId })
            });
            const result = await response.json();
            if (result.success) {
                globalPostsData[currentActivePostId].comments.push(result.data);
                openCommentModal(currentActivePostId);
                commentInput.value = '';
                cancelReply();
                const countSpan = document.getElementById(`comment-count-${currentActivePostId}`);
                countSpan.innerText = parseInt(countSpan.innerText) + 1;
            }
        } catch (error) { alert("Gagal mengirim komentar!"); }
        finally { submitBtn.disabled = false; }
    });

    async function fetchPosts(offset, limit) {
        if (isLoading || allPostsLoaded) return;
        isLoading = true;
        loadingIndicator.classList.remove('hidden');
        try {
            const response = await fetch(`/posts/fetch?offset=${offset}&limit=${limit}&type=${currentFeedType}`);
            const result = await response.json();
            if (result.success) {
                if (result.data.length > 0) {
                    result.data.forEach(post => { postsWrapper.appendChild(renderPost(post)); });
                    currentOffset += result.data.length;
                    if (result.data.length < limit) { allPostsLoaded = true; noMorePosts.classList.remove('hidden'); }
                } else { allPostsLoaded = true; noMorePosts.classList.remove('hidden'); }
            }
        } catch (error) { console.error('Fetch Error:', error); }
        finally { isLoading = false; loadingIndicator.classList.add('hidden'); }
    }

    window.addEventListener('scroll', () => {
        if (allPostsLoaded || isLoading) return;
        if (window.innerHeight + window.scrollY >= document.documentElement.scrollHeight - 500) {
            fetchPosts(currentOffset, 3);
        }
    });

    fetchPosts(0, 5);

    uploadBtn.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            selectedFileUrl = URL.createObjectURL(file);
            previewArea.innerHTML = "";
            if (file.type.startsWith('image/')) {
                previewArea.innerHTML = `<img src="${selectedFileUrl}" class="max-h-[300px] w-full object-contain">`;
            } else if (file.type.startsWith('video/')) {
                previewArea.innerHTML = `<video src="${selectedFileUrl}" class="max-h-[300px] w-full" controls autoplay muted></video>`;
            } else if (file.type === 'application/pdf') {
                previewArea.innerHTML = `<div class="flex flex-col items-center gap-3 p-6 text-center"><div class="w-16 h-16 bg-[#f5f3ff] rounded-2xl flex items-center justify-center text-[#7c3aed] font-bold">PDF</div><div><p class="text-sm font-bold text-slate-700">${file.name}</p><p class="text-[10px] text-slate-400">Siap untuk diunggah</p></div></div>`;
            }
            uploadModal.classList.remove('hidden');
        }
    });

    submitUpload.addEventListener('click', async () => {
        const caption = captionText.value.trim();
        const file = fileInput.files[0];
        if (!caption || !file) return alert("Caption dan file harus diisi!");
        submitUpload.innerText = "Sedang Mengirim...";
        submitUpload.disabled = true;
        const formData = new FormData();
        formData.append('content', caption);
        formData.append('image', file);
        try {
            const response = await fetch('/posts', { method: 'POST', body: formData, headers: { 'X-CSRF-TOKEN': csrfToken } });
            const result = await response.json();
            if (result.success) {
                const newPost = renderPost(result.data);
                newPost.classList.add('animate-fade-in');
                postsWrapper.insertBefore(newPost, postsWrapper.children[0]);
                uploadModal.classList.add('hidden');
                captionText.value = ""; fileInput.value = ""; previewArea.innerHTML = "";
                newPost.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        } catch (error) { alert("Upload gagal!"); }
        finally { submitUpload.innerText = "Posting Sekarang"; submitUpload.disabled = false; }
    });

    closeModal.addEventListener('click', () => uploadModal.classList.add('hidden'));

    async function submitLearningPost(e) {
        e.preventDefault();
        const caption = document.getElementById('learningCaption').value;
        const categoryId = document.getElementById('learningCategory').value;
        const file = document.getElementById('learningFile').files[0];
        const btn = document.getElementById('btnSubmitLearning');
        const isCreateClass = document.getElementById('checkBuatKelas').checked;
        const className = document.getElementById('inputClassName').value;
        if (!caption || !file || !categoryId) return alert("Semua kolom wajib diisi, beb!");
        if (isCreateClass && !className) return alert("Nama kelas harus diisi kalau mau bikin kelas!");
        btn.innerText = "Mengunggah Materi..."; btn.disabled = true;
        const formData = new FormData();
        formData.append('content', caption); formData.append('image', file);
        formData.append('type', 'learning'); formData.append('category_id', categoryId);
        if (isCreateClass) { formData.append('create_class', 'true'); formData.append('class_name', className); }
        try {
            const response = await fetch('/posts', { method: 'POST', body: formData, headers: { 'X-CSRF-TOKEN': csrfToken } });
            const result = await response.json();
            if (result.success) {
                alert('Materi sukses mendarat!');
                document.getElementById('learningUploadModal').classList.add('hidden');
                document.getElementById('learningUploadForm').reset();
                switchFeedType('learning');
            }
        } catch (error) { alert("Waduh, upload gagal!"); }
        finally { btn.innerText = "Upload Materi Sekarang"; btn.disabled = false; }
    }
</script>
</body>
</html>
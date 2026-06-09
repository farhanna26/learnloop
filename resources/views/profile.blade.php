<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $user->name }} | LearnLoop Profile</title>
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
        .tab-active { border-bottom: 4px solid #7c3aed; color: #1e293b; font-weight: 700; }
        .tab-inactive { color: #64748b; font-weight: 500; }
        .tab-inactive:hover { background-color: #f1f5f9; }
        .card-hover { transition: all 0.25s ease; }
        .card-hover:hover { transform: translateY(-2px); box-shadow: 0 10px 24px -4px rgba(109,40,217,0.10); }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #c4b5fd; border-radius: 10px; }

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

        @if(session('success'))
            <div class="flex items-center gap-3 rounded-2xl border border-emerald-100 bg-emerald-50 p-4 text-sm font-bold text-emerald-700 shadow-sm mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-[32px] border border-slate-200 bg-white shadow-sm mb-8">

            <div class="h-40 w-full bg-slate-200 overflow-hidden">
                @if($user->banner)
                    <img src="{{ asset($user->banner) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-r from-violet-400 to-fuchsia-400"></div>
                @endif
            </div>

            <div class="px-6 flex justify-between items-start -mt-16 relative">
                <div class="rounded-full p-1.5 bg-white">
                    <img src="{{ $user->photo ? asset($user->photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=8b5cf6&color=ffffff&rounded=true' }}"
                         class="h-28 w-28 rounded-full object-cover shadow-md border-4 border-white bg-white" />
                </div>

                <div class="mt-20 flex items-center gap-3">
                    @if(Auth::id() == $user->id)
                        <a href="/profile/edit" class="rounded-full border border-slate-300 px-5 py-2 text-sm font-bold text-slate-700 transition hover:bg-slate-50">
                            Edit Profil
                        </a>
                    @else
                        <button id="follow-btn" onclick="handleFollow({{ $user->id }})" class="rounded-full px-5 py-2 text-sm font-bold shadow-lg transition active:scale-95 flex items-center gap-2 {{ $isFollowing ? 'bg-slate-200 text-slate-800 shadow-slate-200 hover:bg-red-100 hover:text-red-600' : 'bg-[#7c3aed] text-white shadow-[#c4b5fd] hover:bg-[#6d28d9]' }}">
                            <svg id="follow-icon" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ $isFollowing ? 'hidden' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            <span id="follow-text">{{ $isFollowing ? 'Following' : 'Follow' }}</span>
                        </button>

                        <a href="/chat/private/{{ $user->id }}" id="chat-btn" class="rounded-full h-9 w-9 flex items-center justify-center bg-white text-slate-600 hover:bg-[#ede9fe] hover:text-[#7c3aed] transition-colors shadow-sm border border-slate-200 {{ $isFollowing ? '' : 'hidden' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>

            <div class="px-6 mt-3 pb-8">
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl font-extrabold text-slate-900">{{ $user->name }}</h1>
                    @if($user->role === 'creator')
                        <span class="bg-[#7c3aed] text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm shadow-[#c4b5fd]">Creator</span>
                    @else
                        <span class="bg-slate-200 text-slate-600 text-xs font-bold px-3 py-1 rounded-full shadow-sm">Learner</span>
                    @endif
                </div>
                <p class="text-sm font-medium text-slate-500">{{ $user->email }}</p>

                <div class="mt-4 text-sm text-slate-800 leading-relaxed">
                    {{ $user->description ?? 'Belum ada deskripsi profil. Klik Edit Profil untuk menambahkan.' }}
                </div>

                <div class="mt-5 flex gap-6 text-sm">
                    <div class="flex gap-1.5 items-center">
                        <span class="font-extrabold text-slate-900">{{ $user->followings_count ?? 0 }}</span>
                        <span class="font-medium text-slate-500">Mengikuti</span>
                    </div>
                    <div class="flex gap-1.5 items-center">
                        <span class="font-extrabold text-slate-900" id="follower-count">{{ $user->followers_count ?? 0 }}</span>
                        <span class="font-medium text-slate-500">Pengikut</span>
                    </div>
                    <div class="flex gap-1.5 items-center">
                        <span class="font-extrabold text-slate-900">{{ $user->posts_count ?? 0 }}</span>
                        <span class="font-medium text-slate-500">Postingan</span>
                    </div>
                </div>

                <div class="mt-4 flex flex-wrap gap-4 text-sm text-slate-500">
                    <div class="flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        Indonesia
                    </div>
                    <div class="flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        Bergabung {{ $user->created_at->format('M Y') }}
                    </div>
                </div>
            </div>

            <div class="flex border-t border-slate-100">
                <button id="tab-portfolio" onclick="switchProfileTab('portfolio')" class="flex-1 py-4 text-sm font-bold text-slate-900 border-b-4 border-[#7c3aed] hover:bg-slate-50 transition-colors">
                    Portofolio
                </button>
                <button id="tab-learning" onclick="switchProfileTab('learning')" class="flex-1 py-4 text-sm font-bold text-slate-500 border-b-4 border-transparent hover:bg-slate-50 hover:text-slate-900 transition-colors">
                    Pembelajaran
                </button>
            </div>
        </div>

        <div id="profilePostsWrapper" class="space-y-6"></div>

        <div id="loadingIndicator" class="hidden text-center py-6">
            <div class="inline-block animate-spin text-[#7c3aed]">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </div>

    </main>
</div>

<!-- COMMENT MODAL -->
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
                <button type="submit" class="bg-[#7c3aed] hover:bg-[#6d28d9] text-white rounded-full h-11 w-11 flex items-center justify-center transition-transform hover:scale-105 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    const profileUserId = "{{ $user->id }}";
    const postsWrapper = document.getElementById('profilePostsWrapper');
    const loadingIndicator = document.getElementById('loadingIndicator');
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
    let currentTab = 'portfolio';
    let currentOffset = 0;
    let isLoading = false;
    let allLoaded = false;

    function switchProfileTab(type) {
        currentTab = type;
        const btnPorto = document.getElementById('tab-portfolio');
        const btnLearn = document.getElementById('tab-learning');
        const activeClass = "flex-1 py-4 text-sm font-bold text-slate-900 border-b-4 border-[#7c3aed] hover:bg-slate-50 transition-colors";
        const inactiveClass = "flex-1 py-4 text-sm font-bold text-slate-500 border-b-4 border-transparent hover:bg-slate-50 hover:text-slate-900 transition-colors";
        if(type === 'portfolio') { btnPorto.className = activeClass; btnLearn.className = inactiveClass; }
        else { btnPorto.className = inactiveClass; btnLearn.className = activeClass; }
        postsWrapper.innerHTML = '';
        currentOffset = 0;
        allLoaded = false;
        fetchProfilePosts();
    }

    function formatTimeAgo(date) {
        const now = new Date();
        const postDate = new Date(date);
        const seconds = Math.floor((now - postDate) / 1000);
        if (seconds < 60) return 'Baru saja';
        if (seconds < 3600) return Math.floor(seconds / 60) + ' menit lalu';
        if (seconds < 86400) return Math.floor(seconds / 3600) + ' jam lalu';
        return Math.floor(seconds / 86400) + ' hari lalu';
    }

    function renderPost(post) {
        globalPostsData[post.id] = post;
        const article = document.createElement('article');
        article.className = 'card-hover overflow-hidden rounded-[32px] border border-slate-200 bg-white mb-6';
        article.id = `post-${post.id}`;

        const userName = post.user?.name || 'User';
        const filePath = post.image ? `/storage/${post.image}` : null;

        let roleBadge = '';
        if (post.user?.role === 'creator') {
            roleBadge = `<span class="bg-[#7c3aed] text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full ml-2 align-middle shadow-sm">Creator</span>`;
        } else {
            roleBadge = `<span class="bg-slate-200 text-slate-600 text-[10px] font-bold px-2.5 py-0.5 rounded-full ml-2 align-middle shadow-sm">Learner</span>`;
        }

        const userPhoto = post.user?.photo ? `/${post.user.photo}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(userName)}&background=7c3aed&color=ffffff&rounded=true`;
        const isVideo = post.image?.match(/\.(mp4|webm|ogg|mov)$/i);
        const isPDF = post.image?.match(/\.(pdf)$/i);
        const isImage = post.image?.match(/\.(jpg|jpeg|png|gif|webp)$/i);
        const likeColorClass = post.is_liked ? 'text-red-500' : 'text-slate-600 hover:text-red-500';

        let roomBannerHtml = '';
        if (post.room_id && post.room) {
            let isJoined = false;
            if (post.user_id === currentUserId) { isJoined = true; }
            else if (post.room.users) { isJoined = post.room.users.some(u => u.id === currentUserId); }
            let buttonHtml = isJoined
                ? `<a href="/chat/${post.room_id}" class="w-full sm:w-auto bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-2.5 rounded-xl text-xs font-extrabold transition-all text-center block">Buka Kelas</a>`
                : `<form action="/chat/join/${post.room_id}" method="POST" class="w-full sm:w-auto shrink-0"><input type="hidden" name="_token" value="${csrfToken}"><button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-xl text-xs font-extrabold shadow-lg shadow-emerald-200 transition-all active:scale-95">Gabung Kelas</button></form>`;
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
                    <p class="text-[11px] text-slate-400 uppercase font-medium">${formatTimeAgo(post.created_at)}</p>
                </div>
            </div>
            <div class="px-5 pb-4 text-sm text-slate-700 leading-relaxed">${post.content}</div>
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
            <div class="border-t border-slate-50 px-6 py-4 flex gap-6 text-sm font-bold">
                <button onclick="handleLike(${post.id})" id="like-btn-${post.id}" class="flex items-center gap-1.5 transition-colors ${likeColorClass}">
                    ❤️ <span id="like-count-${post.id}">${post.likes_count || 0}</span>
                </button>
                <button onclick="openCommentModal(${post.id})" class="flex items-center gap-1.5 text-slate-600 hover:text-[#7c3aed] transition-colors">
                    💬 <span id="comment-count-${post.id}">${post.comments_count || 0}</span>
                </button>
            </div>`;
        return article;
    }

    async function fetchProfilePosts() {
        if (isLoading || allLoaded) return;
        isLoading = true;
        loadingIndicator.classList.remove('hidden');
        try {
            const response = await fetch(`/posts/fetch?offset=${currentOffset}&limit=5&type=${currentTab}&user_id=${profileUserId}`);
            const result = await response.json();
            if (result.success) {
                if (result.data.length > 0) {
                    result.data.forEach(post => { postsWrapper.appendChild(renderPost(post)); });
                    currentOffset += result.data.length;
                } else {
                    allLoaded = true;
                    if(currentOffset === 0) {
                        postsWrapper.innerHTML = `<div class="text-center py-10 bg-white rounded-[32px] border border-slate-200"><p class="text-slate-500 font-medium italic">Belum ada postingan ${currentTab} nih.</p></div>`;
                    }
                }
            }
        } catch (error) { console.error('Fetch Error:', error); }
        finally { isLoading = false; loadingIndicator.classList.add('hidden'); }
    }

    fetchProfilePosts();

    window.addEventListener('scroll', () => {
        if (window.innerHeight + window.scrollY >= document.documentElement.scrollHeight - 500) {
            fetchProfilePosts();
        }
    });

    async function handleLike(postId) {
        const btnElement = document.getElementById(`like-btn-${postId}`);
        const countElement = document.getElementById(`like-count-${postId}`);
        try {
            const response = await fetch(`/posts/${postId}/like`, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' } });
            const result = await response.json();
            let currentCount = parseInt(countElement.innerText);
            if (result.status === 'liked') {
                btnElement.classList.remove('text-slate-600', 'hover:text-red-500');
                btnElement.classList.add('text-red-500');
                countElement.innerText = currentCount + 1;
                globalPostsData[postId].is_liked = true;
            } else {
                btnElement.classList.remove('text-red-500');
                btnElement.classList.add('text-slate-600', 'hover:text-red-500');
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
                childComments.filter(child => child.parent_id == parent.id).forEach(child => { appendCommentToUI(child, true); });
            });
        }
        commentModal.classList.remove('hidden');
    }

    closeCommentModal.addEventListener('click', () => { commentModal.classList.add('hidden'); currentActivePostId = null; });

    function appendCommentToUI(comment, isReply = false) {
        const userName = comment.user?.name || 'User';
        let roleBadgeComment = '';
        if (comment.user?.role === 'creator') {
            roleBadgeComment = `<span class="bg-[#7c3aed] text-white text-[8px] font-bold px-2 py-0.5 rounded-full ml-1.5 align-middle shadow-sm">Creator</span>`;
        } else {
            roleBadgeComment = `<span class="bg-slate-200 text-slate-600 text-[8px] font-bold px-2 py-0.5 rounded-full ml-1.5 align-middle shadow-sm">Learner</span>`;
        }
        const commenterPhoto = comment.user?.photo ? `${window.location.origin}/${comment.user.photo}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(userName)}&background=e2e8f0&color=475569`;
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

    async function handleFollow(targetId) {
        const followBtn = document.getElementById('follow-btn');
        const followText = document.getElementById('follow-text');
        const followIcon = document.getElementById('follow-icon');
        const followerCountSpan = document.getElementById('follower-count');
        const chatBtn = document.getElementById('chat-btn');
        followBtn.disabled = true;
        try {
            const response = await fetch(`/profile/${targetId}/follow`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'Content-Type': 'application/json' }
            });
            const result = await response.json();
            if (result.success) {
                let currentFollowers = parseInt(followerCountSpan.innerText);
                if (result.is_following) {
                    followBtn.className = "rounded-full px-5 py-2 text-sm font-bold shadow-lg transition active:scale-95 flex items-center gap-2 bg-slate-200 text-slate-800 shadow-slate-200 hover:bg-red-100 hover:text-red-600";
                    followText.innerText = "Following";
                    followIcon.classList.add('hidden');
                    followerCountSpan.innerText = currentFollowers + 1;
                    if(chatBtn) chatBtn.classList.remove('hidden');
                } else {
                    followBtn.className = "rounded-full px-5 py-2 text-sm font-bold shadow-lg transition active:scale-95 flex items-center gap-2 bg-[#7c3aed] text-white shadow-[#c4b5fd] hover:bg-[#6d28d9]";
                    followText.innerText = "Follow";
                    followIcon.classList.remove('hidden');
                    followerCountSpan.innerText = currentFollowers - 1;
                    if(chatBtn) chatBtn.classList.add('hidden');
                }
            }
        } catch (error) { console.error("Gagal melakukan follow:", error); }
        finally { followBtn.disabled = false; }
    }
</script>

</body>
</html>
<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: localStorage.getItem('theme') === 'dark', editProfileOpen: false, selectedPost: null }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $user->name }} | LearnLoop Profile</title>
    
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

        /* --- SOSMED LINK 3D SOLID BLOK BUTTONS --- */
        .btn-pop-linkedin {
            background: #0077b5;
            border: 2px solid #004165;
            box-shadow: 0px 4px 0px #004165;
            transition: all 0.15s ease;
        }
        .btn-pop-linkedin:active { transform: translateY(4px); box-shadow: 0px 0px 0px #004165; }

        .btn-pop-portfolio {
            background: #10b981;
            border: 2px solid #065f46;
            box-shadow: 0px 4px 0px #065f46;
            transition: all 0.15s ease;
        }
        .btn-pop-portfolio:active { transform: translateY(4px); box-shadow: 0px 0px 0px #065f46; }

        /* --- SIDEBAR KANAN: KOTAK KONTEN DENGAN BAYANGAN 3D UNGU --- */
        .sidebar-content-box {
            background: #ffffff;
            border-radius: 2.5rem;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0px 0px 0px transparent;
            transform: translateY(0);
            transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .sidebar-content-box:hover {
            transform: translateY(-6px);
            border-color: #c084fc; 
            box-shadow: 0px 10px 0px #7c3aed; 
        }

        .item-user-clean {
            background: rgba(248, 250, 252, 0.6);
            transition: background 0.2s ease;
        }
        .sidebar-content-box:hover .item-user-clean {
            background: #ffffff;
        }

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

        /* --- Dark Mode --- */
        .dark .card-feed { background: #161245; border: 2px solid #2e2773; box-shadow: 0px 14px 0px #0d0a2d; }
        .dark .card-feed:hover { box-shadow: 0px 8px 0px #0d0a2d; }
        .dark .btn-pop-white { background: #161245; border: 2px solid #2e2773; box-shadow: 0px 5px 0px #0d0a2d; color: white; }
        
        .dark .sidebar-content-box { background: #161245; border: 1px solid rgba(46, 39, 115, 0.6); }
        .dark .sidebar-content-box:hover { border-color: #4c1d95; box-shadow: 0px 10px 0px #4c1d95; }
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

        <main class="lg:col-span-7 h-full flex flex-col space-y-6 overflow-y-auto custom-scrollbar pr-2 pb-4 relative">
            
            @if(session('success'))
                <div class="flex items-center gap-3 rounded-2xl border border-emerald-100 bg-emerald-50/80 p-4 text-sm font-semibold text-emerald-800 shadow-sm shrink-0">
                    <span>✨</span> {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden card-feed shrink-0 hover:transform-none hover:shadow-[0px_14px_0px_#cbd5e1] dark:hover:shadow-[0px_14px_0px_#0d0a2d]">
                <div class="h-44 w-full bg-slate-100 dark:bg-[#0d0926] overflow-hidden relative">
                    @if($user->banner)
                        <img src="{{ asset($user->banner) }}" class="w-full h-full object-cover" style="object-position: {{ $user->banner_x ?? 50 }}% {{ $user->banner_y ?? 50 }}%;">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-violet-500 via-purple-500 to-fuchsia-500 opacity-95"></div>
                    @endif
                </div>
                
                <div class="px-6 flex justify-between items-start -mt-16 relative z-10">
                    <div class="rounded-3xl p-1 bg-white dark:bg-[#161245] shadow-md">
                        <img src="{{ $user->photo ? asset($user->photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=8b5cf6&color=ffffff&rounded=true' }}" 
                             class="h-28 w-28 rounded-2xl object-cover border-4 border-white dark:border-[#161245] bg-slate-50" style="object-position: {{ $user->photo_x ?? 50 }}% {{ $user->photo_y ?? 50 }}%;" />
                    </div>
                    
                    <div class="mt-20 flex items-center gap-2">
                        @if(Auth::id() == $user->id)
                            <a href="{{ route('profile.edit') }}" class="btn-pop-purple px-5 py-2.5 text-xs font-black uppercase tracking-wider rounded-xl block text-center text-white">
                                Edit Profil
                            </a>
                        @else
                            <button id="follow-btn" onclick="handleFollow({{ $user->id }})" class="rounded-xl px-5 py-2.5 text-xs font-black uppercase bg-violet-600 text-white shadow-sm transition-all active:scale-95">
                                <span id="follow-text">{{ Auth::user()->isFollowing($user) ? 'Following' : 'Follow' }}</span>
                            </button>
                        @endif
                    </div>
                </div>

                <div class="px-6 mt-4 pb-6">
                    <div class="flex items-center gap-2.5">
                        <h1 class="text-xl font-black text-purple-950 dark:text-white tracking-tight">{{ $user->name }}</h1>
                        @if(($user->role ?? 'learner') === 'creator')
                            <span class="bg-violet-600 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider shadow-sm">{{ ucfirst($user->role) }}</span>
                        @else
                            <span class="bg-slate-200 text-slate-600 text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider shadow-sm">{{ ucfirst($user->role ?? 'Learner') }}</span>
                        @endif
                    </div>
                    <p class="text-xs font-bold text-slate-400 mt-0.5">{{ $user->email }}</p>
                    
                    <div class="mt-4 text-xs font-semibold text-slate-600 dark:text-slate-300 leading-relaxed max-w-xl">
                        {{ $user->description ?? 'Belum ada deskripsi profil.' }}
                    </div>

                    @if($user->linkedin || $user->portfolio)
                        <div class="mt-4 flex flex-wrap gap-3">
                            @if($user->linkedin)
                                <a href="{{ $user->linkedin }}" target="_blank" class="btn-pop-linkedin inline-flex items-center gap-2 px-4 py-2 rounded-xl text-white text-[11px] font-black uppercase tracking-wider">
                                    <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                    LinkedIn
                                </a>
                            @endif
                            @if($user->portfolio)
                                <a href="{{ $user->portfolio }}" target="_blank" class="btn-pop-portfolio inline-flex items-center gap-2 px-4 py-2 rounded-xl text-white text-[11px] font-black uppercase tracking-wider">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                    Portofolio
                                </a>
                            @endif
                        </div>
                    @endif

                    <div class="mt-6 flex gap-6 text-xs border-t border-dashed border-slate-200 dark:border-slate-800 pt-4">
                        <div class="flex gap-1.5 items-center">
                            <span class="font-black text-purple-950 dark:text-white text-sm">{{ $user->followings_count ?? 0 }}</span>
                            <span class="font-bold text-slate-400">Mengikuti</span>
                        </div>
                        <div class="flex gap-1.5 items-center">
                            <span class="font-black text-purple-950 dark:text-white text-sm" id="follower-count">{{ $user->followers_count ?? 0 }}</span>
                            <span class="font-bold text-slate-400">Pengikut</span>
                        </div>
                        <div class="flex gap-1.5 items-center">
                            <span class="font-black text-purple-950 dark:text-white text-sm">{{ $user->posts_count ?? 0 }}</span>
                            <span class="font-bold text-slate-400">Postingan</span>
                        </div>
                    </div>
                </div> 

                <div class="flex border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-[#0d0926]/40 p-1">
                    <button id="tab-portfolio" onclick="switchProfileTab('portfolio')" class="flex-1 py-3 text-xs font-black bg-white dark:bg-[#161245] text-purple-600 rounded-xl shadow-sm uppercase tracking-wider transition-all">Portofolio</button>
                    <button id="tab-learning" onclick="switchProfileTab('learning')" class="flex-1 py-3 text-xs font-black text-slate-400 hover:text-purple-600 uppercase tracking-wider transition-all">Pembelajaran</button>
                </div>
            </div>

            <div id="profilePostsWrapper" class="space-y-6"></div>

            <div id="loadingIndicator" class="hidden text-center py-4">
                <div class="inline-flex h-6 w-6 animate-spin rounded-full border-4 border-purple-600 border-r-transparent"></div>
            </div>
            <div id="noMorePosts" class="hidden text-center py-6">
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider italic">✨ Sudah di penghujung materi ✨</p>
            </div>

        </main>

        <div class="lg:col-span-3 h-full overflow-hidden">
            @php
                $friends = Auth::user()->followings()->inRandomOrder()->take(5)->get();
                $topCreators = \App\Models\User::where('id', '!=', Auth::id())->where('role', 'creator')->take(5)->get();
            @endphp
            <aside class="flex flex-col space-y-6 overflow-y-auto custom-scrollbar pl-2 h-full pb-4">
                
                <div class="sidebar-content-box p-6 shrink-0">
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-400 dark:text-purple-300/40 mb-4">Teman Online</h3>
                    <div class="space-y-3">
                        @forelse($friends as $friend)
                            <div class="item-user-clean p-2.5 rounded-2xl flex items-center justify-between">
                                <a href="/profile/{{ $friend->id }}" class="flex items-center gap-3 flex-1">
                                    <div class="relative shrink-0">
                                        <img src="{{ $friend->photo ? asset($friend->photo) : 'https://ui-avatars.com/api/?name='.urlencode($friend->name).'&background=8b5cf6&color=ffffff' }}" class="h-11 w-11 rounded-full object-cover">
                                        <div class="absolute bottom-0 right-0 h-3 w-3 rounded-full bg-slate-300 border-2 border-white dark:border-[#161245]"></div>
                                    </div>
                                    <div class="truncate">
                                        <p class="text-xs font-black text-purple-950 dark:text-slate-200 truncate leading-tight">{{ $friend->name }}</p>
                                        <span class="text-[10px] font-bold text-slate-400">Offline</span>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 italic text-center py-2">Belum ada teman online.</p>
                        @endforelse
                    </div>
                </div>

                <div class="sidebar-content-box p-6 shrink-0">
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-400 dark:text-purple-300/40 mb-4">Top Creator</h3>
                    <div class="space-y-3">
                        @forelse($topCreators as $creator)
                            <div class="item-user-clean p-2.5 rounded-2xl flex items-center justify-between">
                                <a href="/profile/{{ $creator->id }}" class="flex items-center gap-3 flex-1">
                                    <div class="relative shrink-0">
                                        <img src="{{ $creator->photo ? asset($creator->photo) : 'https://ui-avatars.com/api/?name='.urlencode($creator->name).'&background=8b5cf6&color=ffffff' }}" class="h-11 w-11 rounded-full object-cover">
                                        <div class="absolute bottom-0 right-0 h-3 w-3 rounded-full bg-slate-300 border-2 border-white dark:border-[#161245]"></div>
                                    </div>
                                    <div class="truncate">
                                        <p class="text-xs font-black text-purple-950 dark:text-slate-200 truncate leading-tight">{{ $creator->name }}</p>
                                        <span class="text-[10px] font-bold text-slate-400">Offline</span>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400/80 font-medium italic text-center py-4">Belum ada creator rekomendasi.</p>
                        @endforelse
                    </div>
                </div>

                <div class="pt-2 shrink-0">
                    <form method="POST" action="/logout" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 text-xs font-black uppercase tracking-wider text-rose-500 btn-logout-mini py-3.5 rounded-2xl">
                            <span>🚪</span> Keluar Akun
                        </button>
                    </form>
                </div>
            </aside>
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

    <div id="editPostModal" class="fixed inset-0 z-[80] hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all">
        <div class="w-full max-w-lg rounded-[32px] bg-white p-8 shadow-2xl transform transition-all scale-95 opacity-0 duration-200" id="editModalContent">
            <h3 class="text-xl font-bold mb-6 text-slate-900">Edit Caption Postingan</h3>
            <input type="hidden" id="editPostId">
            <textarea id="editCaptionText" rows="4" class="w-full rounded-2xl border border-slate-200 p-4 text-sm outline-none focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 transition-all bg-slate-50 custom-scrollbar" placeholder="Tulis ulang caption lu di sini..."></textarea>
            <div class="mt-6 flex gap-3">
                <button onclick="closeEditModal()" class="w-full rounded-2xl bg-slate-100 py-3.5 text-sm font-bold text-slate-600 hover:bg-slate-200 transition-all">Batal</button>
                <button onclick="saveEditPost()" id="btnSaveEdit" class="w-full rounded-2xl bg-violet-600 py-3.5 text-sm font-bold text-white hover:bg-violet-700 transition-all shadow-lg shadow-violet-200 active:scale-95">Simpan Perubahan</button>
            </div>
        </div>
    </div>

    <div id="commentModal" class="fixed inset-0 z-[70] hidden flex items-end justify-center sm:items-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all">
        <div class="w-full max-w-lg rounded-t-[32px] sm:rounded-[32px] bg-white flex flex-col shadow-2xl overflow-hidden max-h-[80vh]">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-white shrink-0">
                <h3 class="font-bold text-lg text-slate-900">Komentar</h3>
                <button id="closeCommentModal" class="text-slate-400 hover:text-slate-600 p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            
            <div id="commentsList" class="p-6 overflow-y-auto custom-scrollbar flex-1 space-y-5 bg-slate-50"></div>

            <div id="replyInfo" class="hidden px-5 py-2 bg-violet-50 border-x border-t border-slate-100 flex justify-between items-center shrink-0">
                <p class="text-[10px] font-bold text-violet-600">Membalas: <span id="replyTargetName"></span></p>
                <button type="button" onclick="cancelReply()" class="text-[10px] text-red-400 hover:text-red-600">Batal</button>
            </div>

            <div class="p-4 bg-white border-t border-slate-100 shrink-0">
                <form id="commentForm" class="flex items-center gap-3">
                    <input type="text" id="commentInput" placeholder="Tulis komentar..." class="w-full bg-slate-100 border-transparent focus:bg-white focus:border-violet-500 focus:ring-2 focus:ring-violet-200 rounded-full pl-5 pr-4 py-3 text-sm transition-all outline-none" required autocomplete="off">
                    <button type="submit" class="bg-violet-600 hover:bg-violet-700 text-white rounded-full h-11 w-11 flex items-center justify-center transition-transform hover:scale-105 shrink-0">
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
    const noMorePosts = document.getElementById('noMorePosts');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const currentUserId = {{ Auth::id() }};
    
    // Variabel Global
    let globalPostsData = {}; 
    let currentTab = 'portfolio';
    let currentOffset = 0;
    let isLoading = false;
    let allLoaded = false;

    // --- 1. FITUR SWITCH TAB ---
    function switchProfileTab(type) {
        currentTab = type;
        const btnPorto = document.getElementById('tab-portfolio');
        const btnLearn = document.getElementById('tab-learning');
        const activeClass = "flex-1 py-3 text-xs font-black bg-white dark:bg-[#161245] text-purple-600 rounded-xl shadow-sm uppercase tracking-wider transition-all";
        const inactiveClass = "flex-1 py-3 text-xs font-black text-slate-400 hover:text-purple-600 uppercase tracking-wider transition-all";

        if(type === 'portfolio') {
            btnPorto.className = activeClass;
            btnLearn.className = inactiveClass;
        } else {
            btnPorto.className = inactiveClass;
            btnLearn.className = activeClass;
        }

        postsWrapper.innerHTML = ''; 
        currentOffset = 0; 
        allLoaded = false; 
        noMorePosts.classList.add('hidden');
        fetchProfilePosts();
    }

    // --- 2. FORMAT WAKTU ---
    function formatTimeAgo(date) {
        const now = new Date();
        const postDate = new Date(date);
        const seconds = Math.floor((now - postDate) / 1000);
        if (seconds < 60) return 'Baru saja';
        if (seconds < 3600) return Math.floor(seconds / 60) + 'm lalu';
        if (seconds < 86400) return Math.floor(seconds / 3600) + 'j lalu';
        return Math.floor(seconds / 86400) + ' hari lalu';
    }

    // --- 3. RENDER POSTINGAN (DENGAN FIX ALPINE & STOP PROPAGATION) ---
    function renderPost(post) {
        globalPostsData[post.id] = post;
        const article = document.createElement('article');
        article.className = 'card-feed p-6 relative animate-card mb-6';
        article.id = `post-${post.id}`;
        
        const userName = post.user?.name || 'User';
        const filePath = post.image ? `/storage/${post.image}` : null; 
        const userPhoto = post.user?.photo ? `/${post.user.photo}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(userName)}&background=8b5cf6&color=ffffff`;

        let roleBadge = post.user?.role === 'creator' 
            ? `<span class="bg-violet-600 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full ml-2 align-middle shadow-sm uppercase tracking-wider">Creator</span>` 
            : `<span class="bg-slate-200 text-slate-600 text-[10px] font-bold px-2.5 py-0.5 rounded-full ml-2 align-middle shadow-sm uppercase tracking-wider">Learner</span>`;
            
        const isVideo = post.image?.match(/\.(mp4|webm|ogg|mov)$/i);
        const isImage = post.image?.match(/\.(jpg|jpeg|png|gif|webp)$/i);
        const isPDF = post.image?.match(/\.(pdf)$/i);
        const likeColorClass = post.is_liked ? 'text-pink-500 bg-pink-50 border-pink-200' : 'text-slate-500 bg-slate-50 border-slate-200 hover:text-pink-500';

        // Fix Alpine: Cegah error string JSON pakai replace()
        const safePostData = JSON.stringify(post).replace(/"/g, '&quot;');

        let roomBannerHtml = '';
        if (post.room_id && post.room) {
            let isJoined = false;
            if (post.user_id === currentUserId) isJoined = true; 
            else if (post.room.users) isJoined = post.room.users.some(u => u.id === currentUserId);

            let buttonHtml = isJoined 
                ? `<a href="/chat/${post.room_id}" class="w-full sm:w-auto bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-2.5 rounded-xl text-xs font-extrabold transition-all text-center block">Buka Kelas</a>` 
                : `<form action="/chat/join/${post.room_id}" method="POST" class="w-full sm:w-auto shrink-0"><input type="hidden" name="_token" value="${csrfToken}"><button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-xl text-xs font-extrabold shadow-lg shadow-emerald-200 transition-all active:scale-95">Gabung Kelas</button></form>`;

            roomBannerHtml = `<div class="mx-5 mb-5 p-4 bg-emerald-50 rounded-2xl border border-emerald-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 relative z-20" onclick="event.stopPropagation();"><div class="flex items-center gap-3"><div class="h-10 w-10 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 shrink-0 shadow-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 14v6.5" /></svg></div><div><p class="text-[10px] font-extrabold text-emerald-600 uppercase tracking-wider mb-0.5">Ruang Kelas Tersedia</p><p class="text-sm font-bold text-slate-900 line-clamp-1">${post.room.name}</p></div></div>${buttonHtml}</div>`;
        }

        article.innerHTML = `
            <div class="flex items-start justify-between pb-3">
                <div class="flex items-center gap-3">
                    <a href="/profile/${post.user?.id}" class="shrink-0 hover:scale-105 transition-transform relative z-20" onclick="event.stopPropagation();">
                        <img src="${userPhoto}" class="h-11 w-11 rounded-2xl object-cover border-2 border-purple-200 dark:border-purple-900 shadow-sm" />
                    </a>
                    <div class="relative z-20" onclick="event.stopPropagation();">
                        <div class="flex items-center gap-1">
                            <a href="/profile/${post.user?.id}" class="text-xs font-black text-purple-950 dark:text-purple-100 tracking-tight hover:text-purple-600 hover:underline block">${userName}</a>
                            ${roleBadge}
                        </div>
                        <p class="text-[9px] text-slate-400 dark:text-slate-500 font-bold mt-0.5">${formatTimeAgo(post.created_at)}</p>
                    </div>
                </div>

                ${post.user_id === currentUserId ? `
                <div class="relative shrink-0 ml-4 z-30" onclick="event.stopPropagation();">
                    <button onclick="togglePostMenu(${post.id})" class="p-2 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-xl transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" /></svg>
                    </button>
                    <div id="post-menu-${post.id}" class="hidden absolute right-0 mt-1 w-36 bg-white dark:bg-[#161245] rounded-2xl shadow-xl border border-slate-200 dark:border-slate-800 z-50 overflow-hidden py-1">
                        <button onclick="editPost(${post.id})" class="w-full text-left px-4 py-2.5 text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-purple-50 dark:hover:bg-purple-900/30 transition-colors">✏️ Edit</button>
                        <button onclick="deletePost(${post.id})" class="w-full text-left px-4 py-2.5 text-xs font-bold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 transition-colors border-t border-slate-100 dark:border-slate-800">🗑️ Hapus</button>
                    </div>
                </div>
                ` : ''} 
            </div>

            <div class="pb-4 text-xs md:text-sm text-slate-800 dark:text-slate-200 leading-relaxed font-bold px-0.5 cursor-pointer relative z-10" x-on:click="selectedPost = ${safePostData}">${post.content}</div>

            ${roomBannerHtml}

            ${filePath ? `
            <div class="mb-5 overflow-hidden rounded-2xl flex items-center justify-center relative z-10 bg-slate-50 dark:bg-[#0d0926]" onclick="event.stopPropagation();">
                ${isImage ? `<img src="${filePath}" class="w-full h-auto object-cover max-h-[400px] rounded-2xl border border-slate-200">` : ''}
                ${isVideo ? `<video src="${filePath}" controls class="w-full h-auto max-h-[400px] bg-black rounded-2xl"></video>` : ''}
                ${isPDF ? `<div class="w-full flex items-center justify-between p-5 bg-white dark:bg-[#161245] rounded-2xl border-2 border-slate-200"><div class="flex items-center gap-3.5"><div class="h-11 w-11 flex items-center justify-center bg-rose-500 rounded-xl text-white font-extrabold text-[11px]">PDF</div><p class="text-sm font-bold text-slate-800 dark:text-white truncate max-w-[180px]">Materi Dokumen</p></div><a href="${filePath}" target="_blank" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-bold text-slate-700 shadow-sm">Buka</a></div>` : ''}
            </div>
            ` : ''}

            <div class="pt-3 border-t-2 border-dashed border-slate-100 dark:border-slate-800/60 flex gap-2 text-[11px] font-bold relative z-20" onclick="event.stopPropagation();">
                <button onclick="handleLike(${post.id})" id="like-btn-${post.id}" class="flex items-center gap-1.5 px-4 py-2 rounded-xl transition-transform active:scale-95 border ${likeColorClass}">
                    👍 <span id="like-count-${post.id}">${post.likes_count || 0}</span>
                </button>
                <button onclick="openCommentModal(${post.id})" class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-slate-500 bg-slate-50 border border-slate-200 transition-all active:scale-95">
                    💬 <span id="comment-count-${post.id}">${post.comments_count || 0}</span>
                </button>
            </div>
        `;
        return article;
    }

    // --- 4. FETCH DATA API ---
    async function fetchProfilePosts() {
        if (isLoading || allLoaded) return;
        isLoading = true;
        loadingIndicator.classList.remove('hidden');

        try {
            const response = await fetch(`/posts/fetch?offset=${currentOffset}&limit=5&type=${currentTab}&user_id=${profileUserId}`);
            const result = await response.json();

            if (result.success && result.data.length > 0) {
                result.data.forEach(post => { postsWrapper.appendChild(renderPost(post)); });
                currentOffset += result.data.length;
            } else {
                allLoaded = true;
                noMorePosts.classList.remove('hidden');
                if(currentOffset === 0) {
                    noMorePosts.classList.add('hidden');
                    postsWrapper.innerHTML = `<div class="text-center py-10 bg-white rounded-[32px] border border-slate-200"><p class="text-slate-500 font-medium italic">Belum ada postingan ${currentTab} nih.</p></div>`;
                }
            }
        } catch (error) { console.error(error); } 
        finally { isLoading = false; loadingIndicator.classList.add('hidden'); }
    }

    // --- 5. LOGIKA SOSIAL (FOLLOW & LIKE) ---
    async function handleFollow(userId) {
        const btn = document.getElementById('follow-btn');
        const textSpan = document.getElementById('follow-text');
        const followerCountSpan = document.getElementById('follower-count');
        btn.disabled = true;
        
        try {
            const response = await fetch(`/profile/${userId}/follow`, {
                method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
            });
            const result = await response.json();
            
            if(result.success) {
                let currentCount = parseInt(followerCountSpan.innerText);
                if(result.status === 'followed') {
                    textSpan.innerText = 'Following';
                    followerCountSpan.innerText = currentCount + 1;
                } else {
                    textSpan.innerText = 'Follow';
                    followerCountSpan.innerText = currentCount - 1;
                }
            }
        } catch(e) { console.error(e); } 
        finally { btn.disabled = false; }
    }

    async function handleLike(postId) {
        const btnElement = document.getElementById(`like-btn-${postId}`);
        const countElement = document.getElementById(`like-count-${postId}`);
        try {
            const response = await fetch(`/posts/${postId}/like`, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' } });
            const result = await response.json();
            let currentCount = parseInt(countElement.innerText);

            if (result.status === 'liked') {
                btnElement.className = 'flex items-center gap-1.5 px-4 py-2 rounded-xl transition-transform active:scale-95 border text-pink-500 bg-pink-50 border-pink-200';
                countElement.innerText = currentCount + 1;
                globalPostsData[postId].is_liked = true;
            } else {
                btnElement.className = 'flex items-center gap-1.5 px-4 py-2 rounded-xl transition-transform active:scale-95 border text-slate-500 bg-slate-50 border-slate-200 hover:text-pink-500';
                countElement.innerText = currentCount - 1;
                globalPostsData[postId].is_liked = false;
            }
        } catch (error) { console.error(error); }
    }

    // --- 6. LOGIKA EDIT & DELETE POST ---
    function togglePostMenu(id) { document.getElementById(`post-menu-${id}`).classList.toggle('hidden'); }
    document.addEventListener('click', function(event) {
        if (!event.target.closest('[id^="post-menu-"]') && !event.target.closest('button[onclick^="togglePostMenu"]')) {
            document.querySelectorAll('[id^="post-menu-"]').forEach(menu => { menu.classList.add('hidden'); });
        }
    });

    async function deletePost(id) {
        if(!confirm('Beneran mau hapus postingan ini?')) return;
        try {
            const response = await fetch(`/posts/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }});
            const result = await response.json();
            if(result.success) {
                const postCard = document.getElementById(`post-${id}`);
                postCard.style.transform = 'scale(0.9)'; postCard.style.opacity = '0';
                setTimeout(() => postCard.remove(), 300);
            }
        } catch(e) { alert('Gagal kontak server.'); }
    }

    function editPost(id) {
        const post = globalPostsData[id];
        document.getElementById('editPostId').value = id;
        document.getElementById('editCaptionText').value = post.content;
        const modal = document.getElementById('editPostModal');
        const modalContent = document.getElementById('editModalContent');
        modal.classList.remove('hidden');
        setTimeout(() => { modalContent.classList.remove('scale-95', 'opacity-0'); modalContent.classList.add('scale-100', 'opacity-100'); }, 10);
        togglePostMenu(id);
    }

    function closeEditModal() {
        const modal = document.getElementById('editPostModal');
        const modalContent = document.getElementById('editModalContent');
        modalContent.classList.remove('scale-100', 'opacity-100'); modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => { modal.classList.add('hidden'); }, 200);
    }

    async function saveEditPost() {
        const id = document.getElementById('editPostId').value;
        const newContent = document.getElementById('editCaptionText').value.trim();
        const btn = document.getElementById('btnSaveEdit');
        if(!newContent) return alert('Caption nggak boleh kosong!');
        btn.innerText = 'Menyimpan...'; btn.disabled = true;

        try {
            const response = await fetch(`/posts/${id}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                body: JSON.stringify({ content: newContent })
            });
            const result = await response.json();
            if(result.success) {
                globalPostsData[id].content = newContent;
                const postCard = document.getElementById(`post-${id}`);
                const contentDiv = postCard.querySelector('.leading-relaxed.font-bold');
                if(contentDiv) {
                    contentDiv.innerText = newContent;
                    const safePostData = JSON.stringify(globalPostsData[id]).replace(/"/g, '&quot;');
                    contentDiv.setAttribute('x-on:click', `selectedPost = ${safePostData}`);
                    contentDiv.classList.add('bg-yellow-100', 'transition-colors', 'duration-500');
                    setTimeout(() => contentDiv.classList.remove('bg-yellow-100'), 500);
                }
                closeEditModal();
            }
        } catch(e) { alert('Gagal terhubung ke server.'); } 
        finally { btn.innerText = 'Simpan Perubahan'; btn.disabled = false; }
    }

    // --- 7. LOGIKA KOMENTAR ---
    const commentModal = document.getElementById('commentModal');
    const closeCommentModal = document.getElementById('closeCommentModal');
    const commentsList = document.getElementById('commentsList');
    const commentForm = document.getElementById('commentForm');
    const commentInput = document.getElementById('commentInput');
    let currentActivePostId = null; let currentParentId = null;

    function openCommentModal(postId) {
        currentActivePostId = postId;
        const post = globalPostsData[postId];
        commentsList.innerHTML = ''; 
        if (!post.comments || post.comments.length === 0) {
            commentsList.innerHTML = `<p class="text-center text-sm text-slate-400 mt-10">Belum ada komentar.</p>`;
        } else {
            const parentComments = post.comments.filter(c => !c.parent_id || c.parent_id == 0 || c.parent_id == "null");
            const childComments = post.comments.filter(c => c.parent_id && c.parent_id != 0);
            parentComments.forEach(parent => {
                appendCommentToUI(parent, false);
                childComments.filter(child => child.parent_id == parent.id).forEach(child => appendCommentToUI(child, true));
            });
        }
        commentModal.classList.remove('hidden');
    }

    function appendCommentToUI(comment, isReply = false) {
        const userName = comment.user?.name || 'User';
        let roleBadgeComment = comment.user?.role === 'creator' 
            ? `<span class="bg-violet-600 text-white text-[8px] font-bold px-2 py-0.5 rounded-full ml-1.5 shadow-sm uppercase tracking-wider">Creator</span>` 
            : `<span class="bg-slate-200 text-slate-600 text-[8px] font-bold px-2 py-0.5 rounded-full ml-1.5 shadow-sm uppercase tracking-wider">Learner</span>`;
        const commenterPhoto = comment.user?.photo ? `/${comment.user.photo}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(userName)}&background=e2e8f0`;
        const noDataHtml = commentsList.querySelector('p.text-slate-400');
        if (noDataHtml) noDataHtml.remove();

        const commentDiv = document.createElement('div');
        commentDiv.className = `flex gap-3 ${isReply ? 'ml-10 mt-2' : 'mt-5'}`;
        commentDiv.innerHTML = `<img src="${commenterPhoto}" class="h-8 w-8 rounded-full shrink-0"><div class="bg-white border border-slate-200 rounded-2xl rounded-tl-sm px-4 py-3 shadow-sm flex-1"><div class="flex justify-between items-center mb-0.5"><p class="text-[11px] font-bold text-slate-500">${userName} ${roleBadgeComment}</p>${!isReply ? `<button onclick="setReply(${comment.id}, '${userName}')" class="text-[10px] text-violet-500 hover:underline">Balas</button>` : ''}</div><p class="text-sm text-slate-800">${comment.body}</p></div>`;
        commentsList.appendChild(commentDiv);
        commentsList.scrollTop = commentsList.scrollHeight; 
    }

    function setReply(commentId, name) {
        currentParentId = commentId;
        document.getElementById('replyTargetName').innerText = name;
        document.getElementById('replyInfo').classList.remove('hidden');
        document.getElementById('commentInput').focus();
    }

    function cancelReply() { currentParentId = null; document.getElementById('replyInfo').classList.add('hidden'); }

    commentForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const text = commentInput.value.trim();
        if (!text || !currentActivePostId) return;
        const submitBtn = commentForm.querySelector('button');
        submitBtn.disabled = true;

        try {
            const response = await fetch(`/posts/${currentActivePostId}/comment`, {
                method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                body: JSON.stringify({ body: text, parent_id: currentParentId })
            });
            const result = await response.json();
            if (result.success) {
                globalPostsData[currentActivePostId].comments.push(result.data);
                openCommentModal(currentActivePostId); 
                commentInput.value = ''; cancelReply(); 
                const countSpan = document.getElementById(`comment-count-${currentActivePostId}`);
                countSpan.innerText = parseInt(countSpan.innerText) + 1;
            }
        } catch (error) { alert("Gagal mengirim komentar!"); } 
        finally { submitBtn.disabled = false; }
    });

    closeCommentModal?.addEventListener('click', () => { commentModal.classList.add('hidden'); currentActivePostId = null; });

    // --- INIT ---
    // Fetch langsung pas pertama load
    fetchProfilePosts();

    window.addEventListener('scroll', () => {
        if (allLoaded || isLoading) return;
        if (window.innerHeight + window.scrollY >= document.documentElement.scrollHeight - 500) fetchProfilePosts();
    });

    // Panggil ulang fetch pas ganti mode (buat trigger Alpine refresh bug)
    document.addEventListener('alpine:initialized', () => {
        if(postsWrapper.innerHTML === '') fetchProfilePosts();
    });
    </script>
</body>
</html>
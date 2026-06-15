<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: localStorage.getItem('theme') === 'dark', selectedPost: null }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $user->name }} | LearnLoop Profile</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght=500;600;700;800&display=swap" rel="stylesheet">
    
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
        /* --- TENGAH FEED: 3D SOLID BLOK BERANDA --- */
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

        .btn-pop-white {
            background: #ffffff;
            border: 2px solid #cbd5e1;
            box-shadow: 0px 5px 0px #cbd5e1;
            transition: all 0.15s ease;
        }
        .btn-pop-white:active { transform: translateY(5px); box-shadow: 0px 0px 0px #cbd5e1; }

        .btn-pop-purple {
            background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
            border: 2px solid #4c1d95;
            box-shadow: 0px 5px 0px #4c1d95;
            transition: all 0.15s ease;
        }
        .btn-pop-purple:active { transform: translateY(5px); box-shadow: 0px 0px 0px #4c1d95; }

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

        /* --- ADJUSTMENT DARK MODE --- */
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

        <main class="lg:col-span-7 h-full flex flex-col space-y-6 overflow-y-auto custom-scrollbar pr-2 pb-4">
            
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
                            <button id="follow-btn" onclick="handleFollow({{ $user->id }})" class="rounded-xl px-5 py-2.5 text-xs font-black uppercase bg-violet-600 text-white shadow-sm">
                                <span id="follow-text">{{ $user->isFollowing ? 'Following' : 'Follow' }}</span>
                            </button>
                        @endif
                    </div>
                </div>

                <div class="px-6 mt-4 pb-6">
                    <div class="flex items-center gap-2.5">
                        <h1 class="text-xl font-black text-purple-950 dark:text-white tracking-tight">{{ $user->name }}</h1>
                        <span class="bg-purple-100 dark:bg-purple-950 text-purple-700 dark:text-purple-300 text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider">{{ $user->role ?? 'Learner' }}</span>
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
                    <button id="tab-portfolio" onclick="switchProfileTab('portfolio')" class="flex-1 py-3 text-xs font-black bg-white dark:bg-[#161245] text-purple-600 rounded-xl shadow-sm uppercase tracking-wider">Portofolio</button>
                    <button id="tab-learning" onclick="switchProfileTab('learning')" class="flex-1 py-3 text-xs font-black text-slate-400 uppercase tracking-wider">Pembelajaran</button>
                </div>
            </div>

            <div id="profilePostsWrapper" class="space-y-6"></div>
            <div id="loadingIndicator" class="hidden text-center py-4">
                <div class="inline-flex h-6 w-6 animate-spin rounded-full border-4 border-purple-600 border-r-transparent"></div>
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
                                <a href="/profile/{{ $friend->id }}" class="flex items-center gap-3 overflow-hidden flex-1">
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
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-400 dark:text-purple-300/40 mb-4">Top Kreator</h3>
                    <div class="space-y-3">
                        @forelse($topCreators as $creator)
                            <div class="item-user-clean p-2.5 rounded-2xl flex items-center justify-between">
                                <a href="/profile/{{ $creator->id }}" class="flex items-center gap-3 overflow-hidden flex-1">
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
                            <p class="text-xs text-slate-400/80 font-medium italic text-center py-4">Belum ada kreator rekomendasi.</p>
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

    <script>
    const profileUserId = "{{ $user->id }}"; 
    const postsWrapper = document.getElementById('profilePostsWrapper');
    const loadingIndicator = document.getElementById('loadingIndicator');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const currentUserId = {{ Auth::id() }};
    
    let globalPostsData = {}; 
    let currentTab = 'portfolio';
    let currentOffset = 0;
    let isLoading = false;
    let allLoaded = false;

    function formatTimeAgo(date) {
        const now = new Date();
        const postDate = new Date(date);
        const seconds = Math.floor((now - postDate) / 1000);
        if (seconds < 60) return 'Baru saja';
        if (seconds < 3600) return Math.floor(seconds / 60) + 'm lalu';
        if (seconds < 86400) return Math.floor(seconds / 3600) + 'j lalu';
        return Math.floor(seconds / 86400) + ' hari lalu';
    }

    function renderPost(post) {
        globalPostsData[post.id] = post;
        const article = document.createElement('article');
        article.className = 'card-feed p-6 relative animate-card cursor-pointer mb-6';
        article.setAttribute('x-on:click', `selectedPost = ${JSON.stringify(post)}`);
        
        const userName = post.user?.name || 'User';
        const filePath = post.image ? `/storage/${post.image}` : null; 

        const userPhoto = post.user?.photo 
            ? `/${post.user.photo}` 
            : `https://ui-avatars.com/api/?name=${encodeURIComponent(userName)}&background=8b5cf6&color=ffffff`;
        
        const isVideo = post.image?.match(/\.(mp4|webm|ogg|mov)$/i);
        const isPDF = post.image?.match(/\.(pdf)$/i);
        const isImage = post.image?.match(/\.(jpg|jpeg|png|gif|webp)$/i);

        article.innerHTML = `
            <div class="flex items-start justify-between pb-3">
                <div class="flex items-center gap-3">
                    <img src="${userPhoto}" class="h-11 w-11 rounded-2xl object-cover border-2 border-purple-200 dark:border-purple-900 shadow-sm" />
                    <div>
                        <span class="text-xs font-black text-purple-950 dark:text-purple-100 tracking-tight">${userName}</span>
                        <p class="text-[9px] text-slate-400 dark:text-slate-500 font-bold mt-0.5">${formatTimeAgo(post.created_at)}</p>
                    </div>
                </div>
            </div>

            <div class="pb-4 text-xs md:text-sm text-slate-800 dark:text-slate-200 leading-relaxed font-bold px-0.5">${post.content}</div>

            ${filePath ? `
            <div class="mb-5 overflow-hidden rounded-2xl bg-slate-50 dark:bg-[#0d0926] border border-slate-100 dark:border-slate-800 flex items-center justify-center" onclick="event.stopPropagation();">
                ${isImage ? `<img src="${filePath}" class="w-full h-auto object-cover max-h-[420px]">` : ''}
                ${isVideo ? `<video src="${filePath}" controls class="w-full h-auto max-h-[420px] bg-black"></video>` : ''}
                ${isPDF ? `
                    <div class="w-full flex items-center justify-between p-5 bg-white dark:bg-[#161245] rounded-2xl border-2 border-slate-200">
                        <div class="flex items-center gap-3.5">
                            <div class="h-11 w-11 flex items-center justify-center bg-rose-500 rounded-xl text-white font-extrabold text-[11px]">PDF</div>
                            <p class="text-sm font-bold text-slate-800 dark:text-white truncate max-w-[180px]">Materi Dokumen</p>
                        </div>
                        <a href="${filePath}" target="_blank" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-bold text-slate-700 shadow-sm">Buka</a>
                    </div>
                ` : ''}
            </div>
            ` : ''}

            <div class="pt-3 border-t-2 border-dashed border-slate-100 dark:border-slate-800/60 flex gap-2 text-[11px] font-bold" onclick="event.stopPropagation();">
                <button class="flex items-center gap-1.5 px-4 py-2 rounded-xl bg-pink-50 dark:bg-pink-950/20 text-pink-500 border border-pink-200 transition-transform active:scale-95">👍 <span>${post.likes_count || 0}</span></button>
                <button class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-slate-500 dark:text-purple-300 bg-slate-50 dark:bg-purple-950/10 border border-slate-200 transition-all active:scale-95" x-on:click="$parent.selectedPost = ${JSON.stringify(post)}">💬 <span>Tanggapi</span></button>
            </div>
        `;
        return article;
    }

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
                if(currentOffset === 0) {
                     postsWrapper.innerHTML = `<p class="text-slate-400 text-xs font-semibold italic text-center py-12">Belum ada rekaman data ${currentTab}.</p>`;
                }
            }
        } catch (error) { console.error(error); } 
        finally { isLoading = false; loadingIndicator.classList.add('hidden'); }
    }

    fetchProfilePosts();
    </script>
</body>
</html>
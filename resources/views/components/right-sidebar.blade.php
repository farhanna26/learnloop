@php
    $currentUser = Auth::user();

    // 1. QUERY TEMAN ONLINE
    // Kita bikin query dasarnya dulu buat dihitung
    $friendsQuery = $currentUser->followings();
    
    // Hitung total teman keseluruhan
    $totalFriends = $friendsQuery->count();
    
    // Baru kita ambil 5 doang buat ditampilin di awal
    $friends = $friendsQuery->inRandomOrder()->take(5)->get();


    // 2. QUERY TOP KREATOR (Rekomendasi)
    // Bikin query dasarnya dulu
    $creatorsQuery = \App\Models\User::where('id', '!=', $currentUser->id)
        ->where('role', 'creator')
        ->whereDoesntHave('followers', function ($query) use ($currentUser) {
            $query->where('follower_id', $currentUser->id);
        });

    // Hitung total kreator yang belum di-follow
    $totalCreators = $creatorsQuery->count();

    // Baru kita ambil 5 doang
    $topCreators = $creatorsQuery->withCount('posts')
        ->orderByDesc('posts_count')
        ->take(5)
        ->get();
@endphp

<aside class="hidden xl:col-span-3 xl:flex flex-col h-[calc(100vh-7rem)] sticky top-24 overflow-y-auto custom-scrollbar pr-2 space-y-6 pb-6">

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5">
        <h3 class="text-base font-extrabold text-slate-900 mb-4">Teman Online</h3>
        
        <div class="space-y-4" id="online-friends-list">
            @forelse($friends as $friend)
                @php
                    $friendPhoto = $friend->photo ? asset($friend->photo) : 'https://ui-avatars.com/api/?name='.urlencode($friend->name).'&background=10b981&color=ffffff&rounded=true';
                @endphp
                <div class="flex items-center justify-between group" id="friend-item-{{ $friend->id }}">
                    <a href="/profile/{{ $friend->id }}" class="flex items-center gap-3 cursor-pointer">
                        <div class="relative shrink-0">
                            <img src="{{ $friendPhoto }}" class="h-10 w-10 rounded-full object-cover shadow-sm border border-slate-100">
                            <div id="status-dot-{{ $friend->id }}" class="absolute bottom-0 right-0 h-3 w-3 rounded-full bg-slate-300 border-2 border-white transition-colors duration-300"></div>
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-sm font-bold text-slate-900 truncate group-hover:text-violet-600 transition-colors">{{ $friend->name }}</p>
                            <p id="status-text-{{ $friend->id }}" class="text-[11px] font-medium text-slate-400 truncate">Offline</p>
                        </div>
                    </a>
                    <a href="/chat/private/{{ $friend->id }}" class="p-2 bg-slate-50 text-slate-400 hover:text-violet-600 hover:bg-violet-50 rounded-full transition-all shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                    </a>
                </div>
            @empty
                <p class="text-xs text-slate-400 italic text-center">Belum ada teman yang ditambahkan.</p>
            @endforelse
        </div>

        @if($totalFriends > 5)
            <button class="mt-5 text-[13px] font-bold text-violet-600 hover:text-violet-700 w-full text-left transition-colors">
                Tampilkan lebih banyak ({{ $totalFriends - 5 }})
            </button>
        @endif
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5">
        <h3 class="text-base font-extrabold text-slate-900 mb-4">Top Kreator</h3>
        
        <div class="space-y-4" id="recommendation-list">
            @forelse($topCreators as $creator)
                @php
                    $creatorPhoto = $creator->photo ? asset($creator->photo) : 'https://ui-avatars.com/api/?name='.urlencode($creator->name).'&background=3b82f6&color=ffffff&rounded=true';
                @endphp
                <div class="flex items-center justify-between group">
                    <a href="/profile/{{ $creator->id }}" class="flex items-center gap-3 cursor-pointer overflow-hidden">
                        <img src="{{ $creatorPhoto }}" class="h-10 w-10 rounded-full shrink-0 shadow-sm border border-slate-100">
                        <div class="overflow-hidden">
                            <p class="text-sm font-bold text-slate-900 truncate group-hover:text-violet-600 transition-colors">{{ $creator->name }}</p>
                            <p class="text-[11px] font-medium text-slate-500 truncate">{{ $creator->posts_count ?? 0 }} Materi Publik</p>
                        </div>
                    </a>
                    <button class="bg-slate-900 text-white text-[10px] uppercase tracking-wider font-bold px-4 py-1.5 rounded-full hover:bg-slate-800 transition-all shrink-0 ml-2 shadow-sm">
                        Ikuti
                    </button>
                </div>
            @empty
                <p class="text-xs text-slate-400 italic text-center">Belum ada kreator yang tersedia.</p>
            @endforelse
        </div>

        @if($totalCreators > 5)
            <button class="mt-5 text-[13px] font-bold text-violet-600 hover:text-violet-700 w-full text-left transition-colors">
                Tampilkan lebih banyak...
            </button>
        @endif
    </div>

    <div class="px-3 flex flex-wrap gap-x-4 gap-y-2 text-[11px] text-slate-400 font-medium pb-4">
        <a href="#" class="hover:text-slate-600 hover:underline transition-colors">Privasi</a>
        <a href="#" class="hover:text-slate-600 hover:underline transition-colors">Ketentuan Layanan</a>
        <a href="#" class="hover:text-slate-600 hover:underline transition-colors">Panduan Kampus</a>
        <span>© 2026 LearnLoop by Rosecheroft Enterprise.</span>
    </div>
</aside>
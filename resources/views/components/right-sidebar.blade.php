@php
    $user = Auth::user();
    $bannerUrl = $user->banner ? asset($user->banner) : null;
    $photoUrl = $user->photo ? asset($user->photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name ?? 'User').'&background=8b5cf6&color=ffffff&rounded=true';
    $userName = $user->name;

    $friendsQuery = $user->followings();
    $friends = $friendsQuery->inRandomOrder()->take(5)->get();

    $topCreators = \App\Models\User::where('id', '!=', $user->id)
        ->where('role', 'creator')
        ->withCount('posts')
        ->orderByDesc('posts_count')
        ->take(5)
        ->get();
@endphp

<style>
    /* --- AREA KANAN (SOFT CLAYMORPHIC FLOATING POP-UP) --- */
    .card-right-clay {
        background: #ffffff;
        border-radius: 2.25rem;
        border: 1px solid rgba(255, 255, 255, 0.7);
        box-shadow: 
            0px 15px 35px rgba(124, 58, 237, 0.04),
            inset 3px 3px 6px rgba(255, 255, 255, 1);
        transition: all 0.3s cubic-bezier(0.19, 1, 0.22, 1);
    }
    .card-right-clay:hover {
        transform: translateY(-4px);
        box-shadow: 0px 20px 40px rgba(124, 58, 237, 0.1);
    }

    .btn-pop-pill {
        background: linear-gradient(135deg, #a855f7 0%, #7c3aed 100%);
        box-shadow: 0px 4px 12px rgba(124, 58, 237, 0.2);
    }

    .btn-logout-mini {
        background: #ffffff;
        border: 2px solid #fecaca;
        box-shadow: 0px 4px 0px #fca5a5;
        transition: all 0.15s ease-in-out;
    }
    .btn-logout-mini:hover {
        transform: translateY(-2px);
        box-shadow: 0px 5px 0px #fca5a5;
        background: #fff5f5;
    }
    .btn-logout-mini:active {
        transform: translateY(3px);
        box-shadow: 0px 0px 0px #fca5a5;
    }

    .dark .card-right-clay { background: #15103a; border: 1px solid rgba(255, 255, 255, 0.04); box-shadow: 0px 15px 35px rgba(0, 0, 0, 0.4); }
    .dark .btn-logout-mini { background: #1a102f; border: 2px solid #e11d48; box-shadow: 0px 4px 0px #9f1239; color: #f43f5e; }
</style>

<aside class="hidden lg:flex flex-col space-y-6 overflow-y-auto custom-scrollbar pl-2 h-full pb-6">
    
    <div class="card-right-clay overflow-hidden relative group shrink-0">
        <div class="h-24 w-full relative {{ $bannerUrl ? 'bg-cover bg-center' : 'bg-gradient-to-r from-purple-500 via-indigo-500 to-pink-500' }}"
             @if($bannerUrl) style="background-image: url('{{ $bannerUrl }}');" @endif>
        </div>
        <div class="px-5 pb-6 text-center -mt-11 relative z-10">
            <img src="{{ $photoUrl }}" class="h-20 w-20 rounded-2xl object-cover mx-auto border-4 border-white dark:border-[#15103a] shadow-md" />
            <h2 class="mt-2.5 font-black text-sm text-purple-950 dark:text-white truncate tracking-tight">{{ $userName }}</h2>
            @if(($user->role ?? 'learner') === 'creator')
                <span class="text-[10px] bg-violet-600 text-white font-bold px-2.5 py-0.5 rounded-full inline-block uppercase mt-1 shadow-sm">{{ ucfirst($user->role) }}</span>
            @else
                <span class="text-[10px] bg-slate-200 text-slate-600 font-bold px-2.5 py-0.5 rounded-full inline-block uppercase mt-1 shadow-sm">{{ ucfirst($user->role ?? 'Learner') }}</span>
            @endif
            <div class="mt-4">
                <a href="/profile" class="w-full text-[10px] font-black uppercase tracking-wider text-white btn-pop-pill py-3 rounded-2xl block text-center">
                    👤 Profile
                </a>
            </div>
        </div>
    </div>

    <div class="card-right-clay p-5 bg-white dark:bg-[#15103a] shrink-0">
        <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-purple-400/40 mb-4">Teman Online</h3>
        <div class="space-y-3.5" id="online-friends-list">
            @forelse($friends as $friend)
                @php
                    $friendPhoto = $friend->photo ? asset($friend->photo) : 'https://ui-avatars.com/api/?name='.urlencode($friend->name).'&background=10b981&color=ffffff&rounded=true';
                @endphp
                <div class="flex items-center justify-between group bg-purple-50/40 dark:bg-[#0d0926] p-2 rounded-2xl border border-purple-100/10">
                    <a href="/profile/{{ $friend->id }}" class="flex items-center gap-2.5 cursor-pointer flex-1">
                        <div class="relative shrink-0 overflow-visible">
                            <img src="{{ $friendPhoto }}" class="h-9 w-9 rounded-xl object-cover border border-slate-100">
                            <div class="absolute -bottom-1 -right-1 h-3.5 w-3.5 rounded-full bg-slate-300 border-2 border-white dark:border-[#15103a]"></div>
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-xs font-black text-purple-950 dark:text-slate-200 truncate group-hover:text-purple-600 transition-colors leading-tight">{{ $friend->name }}</p>
                            <p class="text-[9px] font-bold text-slate-400 truncate">Offline</p>
                        </div>
                    </a>
                </div>
            @empty
                <p class="text-xs text-slate-400 italic text-center py-2">Belum ada teman online.</p>
            @endforelse
        </div>
    </div>

    <div class="card-right-clay p-5 bg-white dark:bg-[#15103a] shrink-0">
        <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-purple-400/40 mb-4">Top Kreator</h3>
        <div class="space-y-3.5" id="recommendation-list">
            @forelse($topCreators as $creator)
                @php
                    $creatorPhoto = $creator->photo ? asset($creator->photo) : 'https://ui-avatars.com/api/?name='.urlencode($creator->name).'&background=3b82f6&color=ffffff&rounded=true';
                @endphp
                <div id="creator-item-{{ $creator->id }}" class="flex items-center justify-between group bg-purple-50/40 dark:bg-[#0d0926] p-2 rounded-2xl border border-purple-100/10 transition-all">
                    <a href="/profile/{{ $creator->id }}" class="flex items-center gap-2.5 cursor-pointer flex-1">
                        <img src="{{ $creatorPhoto }}" class="h-9 w-9 rounded-xl object-cover border border-slate-100">
                        <div class="overflow-hidden">
                            <p class="text-xs font-black text-purple-950 dark:text-slate-200 truncate group-hover:text-purple-600 transition-colors leading-tight">{{ $creator->name }}</p>
                            <p class="text-[9px] font-bold text-purple-400/80 truncate">{{ $creator->posts_count ?? 0 }} Modul</p>
                        </div>
                    </a>
                    @php $isFollowingCreator = $user->isFollowing($creator); @endphp
                    <button id="follow-creator-btn-{{ $creator->id }}" onclick="handleCreatorFollow({{ $creator->id }})" class="text-[9px] uppercase tracking-wider font-black px-4 py-2 rounded-xl shrink-0 transition-all active:scale-95 {{ $isFollowingCreator ? 'bg-slate-200 text-slate-600' : 'text-white btn-pop-pill' }}">{{ $isFollowingCreator ? 'Following' : 'Ikuti' }}</button>
                </div>
            @empty
                <p class="text-xs text-slate-400 italic text-center py-2">Belum ada creator rekomendasi.</p>
            @endforelse
        </div>
    </div>

    <div class="pt-2 shrink-0">
        <form method="POST" action="/logout" class="w-full">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit" class="w-full flex items-center justify-center gap-2 text-xs font-black uppercase tracking-wider text-rose-500 btn-logout-mini py-3.5 rounded-2xl">
                <span>🚪</span> Keluar Akun
            </button>
        </form>
    </div>
</aside>

<script>
    async function handleCreatorFollow(creatorId) {
        const btn = document.getElementById(`follow-creator-btn-${creatorId}`);
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        if (!csrfToken) return;
        btn.disabled = true;
        const prevText = btn.innerText;
        btn.innerText = '...';

        try {
            const response = await fetch(`/profile/${creatorId}/follow`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
            });
            const result = await response.json();

            if (result.success) {
                if (result.is_following) {
                    btn.innerText = 'Following';
                    btn.className = 'text-[9px] uppercase tracking-wider font-black px-4 py-2 rounded-xl shrink-0 transition-all active:scale-95 bg-slate-200 text-slate-600';
                } else {
                    btn.innerText = 'Follow';
                    btn.className = 'text-[9px] uppercase tracking-wider font-black px-4 py-2 rounded-xl shrink-0 transition-all active:scale-95 text-white btn-pop-pill';
                }
            }
        } catch (error) {
            console.error('Follow gagal:', error);
            btn.innerText = prevText;
        } finally {
            btn.disabled = false;
        }
    }
</script>
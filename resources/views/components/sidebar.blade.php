@php
    $user = Auth::user();
    $bannerUrl = $user->banner ? asset($user->banner) : null;
    $photoUrl = $user->photo ? asset($user->photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name ?? 'User').'&background=8b5cf6&color=ffffff&rounded=true';
    $userName = $user->name;
@endphp

<aside class="hidden lg:col-span-3 lg:flex flex-col h-[calc(100vh-7rem)] sticky top-24 bg-white rounded-[32px] border border-slate-200 shadow-xl overflow-hidden p-6">
    
    <nav class="space-y-1">
        <a href="/beranda" class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm transition-all {{ request()->is('beranda*') ? 'bg-violet-50 text-violet-700 font-bold' : 'text-slate-600 font-medium hover:bg-slate-100 hover:text-slate-900' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Beranda
        </a>
        <a href="/contacts" class="group flex items-center justify-between rounded-2xl px-4 py-3 text-sm transition-all {{ request()->is('contacts*') || request()->is('chat*') ? 'bg-violet-50 text-violet-700 font-bold' : 'text-slate-600 font-medium hover:bg-slate-100 hover:text-slate-900' }}">
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                Pesan
            </div>
        </a>
        <a href="/search" class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm transition-all {{ request()->is('search*') ? 'bg-violet-50 text-violet-700 font-bold' : 'text-slate-600 font-medium hover:bg-slate-100 hover:text-slate-900' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            Search
        </a>
        <a href="/notifications" class="group flex items-center justify-between rounded-2xl px-4 py-3 text-sm transition-all {{ request()->is('notifications*') ? 'bg-violet-50 text-violet-700 font-bold' : 'text-slate-600 font-medium hover:bg-slate-100 hover:text-slate-900' }}">
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                Notifikasi
            </div>
        </a>
        <a href="/leaderboard" class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm transition-all {{ request()->is('leaderboard*') ? 'bg-violet-50 text-violet-700 font-bold' : 'text-slate-600 font-medium hover:bg-slate-100 hover:text-slate-900' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
            Leaderboard
        </a>
        <a href="/ai-mentor" class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm transition-all {{ request()->is('ai-mentor*') ? 'bg-violet-50 text-violet-700 font-bold shadow-sm' : 'text-slate-600 font-medium hover:bg-slate-100 hover:text-slate-900' }}">
            <span class="text-lg opacity-70 group-hover:opacity-100">🤖</span>
            Mentor
        </a>
    </nav>

    <div class="flex-grow"></div> <a href="/profile" class="relative group flex items-center w-full h-16 rounded-[18px] overflow-hidden shadow-sm hover:shadow-md border border-slate-200 transition-all mt-6 shrink-0 cursor-pointer">
        
        <div class="absolute inset-0 {{ $bannerUrl ? 'bg-cover bg-center' : 'bg-slate-800' }} transition-transform duration-500 group-hover:scale-105"
            @if($bannerUrl) style="background-image: url('{{ $bannerUrl }}');" @endif>
        </div>
        
        <div class="absolute inset-0 bg-black/40 group-hover:bg-black/50 transition-colors"></div>

        <div class="relative z-10 flex items-center w-full px-3">
            
            <div class="relative shrink-0">
                <img src="{{ $photoUrl }}" class="h-10 w-10 rounded-full object-cover shadow-sm border border-white/20" />
            </div>
            
            <div class="flex flex-col ml-3 flex-1 overflow-hidden">
                <span class="text-sm font-bold text-white truncate leading-tight">{{ $userName }}</span>
            </div>

            <div class="p-1.5 rounded-lg text-white/70 hover:text-white hover:bg-white/20 group-hover:rotate-90 transition-all shrink-0 ml-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" /></svg>
            </div>
        </div>
    </a>
</aside>
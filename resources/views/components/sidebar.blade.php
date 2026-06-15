@php
    $user = Auth::user();
@endphp

<style>
    .btn-nav-flat {
        background: transparent;
        border: 2px solid transparent;
        color: #64748b;
        transition: all 0.2s ease-in-out;
    }
    .btn-nav-flat:hover {
        background: #f1f5f9;
        color: #475569;
    }

    .btn-nav-active {
        background: #ffffff;
        border: 2px solid #e2e8f0;
        box-shadow: 0px 5px 0px #cbd5e1;
        color: #8b5cf6 !important;
        transform: translateY(-2px);
    }

    .dark .btn-nav-flat { color: #94a3b8; }
    .dark .btn-nav-flat:hover { background: rgba(30, 27, 75, 0.4); color: #f1f5f9; }
    
    .dark .btn-nav-active {
        background: #110d33;
        border: 2px solid #2e2773;
        box-shadow: 0px 5px 0px #0d0a2d;
        color: #a78bfa !important;
    }
</style>

<aside class="flex flex-col justify-between py-2 border-r-2 border-dashed border-slate-200 dark:border-slate-800 pr-4 h-full overflow-y-auto custom-scrollbar">
    <div class="space-y-8">
        <a href="/beranda" class="flex items-center px-2 group shrink-0">
            <span class="text-2xl font-black tracking-tight bg-gradient-to-r from-purple-600 via-pink-500 to-amber-500 bg-clip-text text-transparent transform group-hover:scale-105 transition-transform">
                LearnLoop
            </span>
        </a>

        <nav class="space-y-3 font-black text-xs uppercase tracking-wider">
            <a href="/beranda" class="group flex items-center gap-3 rounded-2xl px-4 py-3.5 {{ request()->is('beranda*') ? 'btn-nav-active' : 'btn-nav-flat' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Beranda
            </a>
            
            <a href="/contacts" class="group flex items-center justify-between rounded-2xl px-4 py-3.5 {{ request()->is('contacts*') || request()->is('chat*') ? 'btn-nav-active' : 'btn-nav-flat' }}">
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    Pesan
                </div>
                <span class="bg-gradient-to-r from-pink-500 to-rose-500 text-white text-[9px] px-2 py-0.5 rounded-xl border border-rose-700 shadow-sm font-black">2</span>
            </a>

            <a href="/search" class="group flex items-center gap-3 rounded-2xl px-4 py-3.5 {{ request()->is('search*') ? 'btn-nav-active' : 'btn-nav-flat' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                Search
            </a>

            <a href="/notifications" class="group flex items-center justify-between rounded-2xl px-4 py-3.5 {{ request()->is('notifications*') ? 'btn-nav-active' : 'btn-nav-flat' }}">
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                    Notifikasi
                </div>
                <span class="bg-amber-400 text-purple-950 text-[9px] px-2 py-0.5 rounded-xl border border-amber-600 shadow-sm font-black animate-pulse">3</span>
            </a>

            <a href="/leaderboard" class="group flex items-center gap-3 rounded-2xl px-4 py-3.5 {{ request()->is('leaderboard*') ? 'btn-nav-active' : 'btn-nav-flat' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                Leaderboard
            </a>

            <a href="/ai-mentor" class="group flex items-center gap-3 rounded-2xl px-4 py-3.5 {{ request()->is('ai-mentor*') ? 'btn-nav-active' : 'btn-nav-flat' }}">
                <span class="text-base shrink-0">🤖</span>
                AI Mentor
            </a>
        </nav>
    </div>
</aside>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pesan | LearnLoop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .glass-effect { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.05); }
    </style>
</head>
<body class="min-h-screen text-slate-900">

    <header class="sticky top-0 z-50 border-b border-slate-200 glass-effect">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6">
            <div class="flex flex-1 items-center gap-8">
                <a href="/beranda" class="flex items-center gap-2">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-600 shadow-lg shadow-violet-200">
                        <span class="text-xl font-bold text-white">L</span>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight text-slate-900">LearnLoop</span>
                </a>
            </div>

            <div class="flex items-center gap-3">
                <span class="text-sm font-bold text-slate-700 hidden md:block">{{ Auth::user()->name }}</span>
                <a href="/profile" class="transition-transform hover:scale-110 active:scale-95">
                    <img src="{{ Auth::user()->photo ? asset(Auth::user()->photo) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name ?? 'User').'&background=8b5cf6&color=ffffff&rounded=true' }}" 
                         class="h-9 w-9 rounded-xl object-cover shadow-sm border border-violet-100" />
                </a>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-8 pb-24 sm:px-6">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
            
            <aside class="hidden lg:col-span-3 lg:block">
                <div class="sticky top-28 space-y-4">
                    <nav class="space-y-1">
                        <a href="/beranda" class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium text-slate-600 transition-all hover:bg-slate-100 hover:text-slate-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Beranda
                        </a>
                        <a href="/contacts" class="group flex items-center justify-between rounded-2xl bg-violet-50 px-4 py-3 text-sm font-bold text-violet-700 transition-all">
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                Pesan
                            </div>
                        </a>
                        <a href="/search" class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium text-slate-600 transition-all hover:bg-slate-100 hover:text-slate-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            Search
                        </a>
                        <a href="/notifications" class="group flex items-center justify-between rounded-2xl px-4 py-3 text-sm font-medium text-slate-600 transition-all hover:bg-slate-100 hover:text-slate-900">
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                Notifikasi
                            </div>
                        </a>
                        <a href="/profile" class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium text-slate-600 transition-all hover:bg-slate-100 hover:text-slate-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            Profil
                        </a>
                    </nav>
                </div>
            </aside>

            <section class="lg:col-span-9 space-y-8">
                
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-100 text-violet-600 shadow-sm shadow-violet-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        </div>
                        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Grup Mahasiswa</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($groups as $group)
                            <div class="card-hover flex items-center justify-between p-5 bg-white rounded-[28px] border border-slate-200 shadow-sm">
                                <div class="flex items-center gap-4">
                                    <div class="h-14 w-14 rounded-2xl bg-gradient-to-br from-violet-500 to-violet-700 flex items-center justify-center text-white font-bold text-2xl shadow-lg shadow-violet-100">
                                        #
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-900 line-clamp-1 uppercase tracking-tight">{{ $group->name }}</h3>
                                        <div class="flex items-center gap-1.5 mt-0.5">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Aktif Diskusi</p>
                                        </div>
                                    </div>
                                </div>
                                <a href="/chat/{{ $group->id }}" class="px-5 py-2.5 bg-violet-50 hover:bg-violet-600 text-violet-700 hover:text-white text-xs font-bold rounded-xl transition-all shadow-sm">
                                    Buka
                                </a>
                            </div>
                        @empty
                            <div class="col-span-full p-12 text-center bg-white rounded-[32px] border border-dashed border-slate-300">
                                <p class="text-slate-400 font-medium italic uppercase text-sm">Belum ada grup diskusi aktif, beb.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-600 shadow-sm shadow-blue-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                        </div>
                        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Pesan Pribadi</h2>
                    </div>

                    <div class="grid grid-cols-1 gap-3">
                        @forelse($users as $user)
                            <div class="card-hover flex items-center justify-between p-4 bg-white rounded-[28px] border border-slate-200 shadow-sm">
                                <div class="flex items-center gap-4">
                                    <div class="relative">
                                        <img src="{{ $user->photo ? asset($user->photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=7c3aed&color=ffffff&rounded=true' }}" 
                                             class="h-14 w-14 rounded-full object-cover ring-4 ring-slate-50 shadow-sm" alt="{{ $user->name }}" />
                                        <span class="absolute bottom-0 right-0 h-4 w-4 rounded-full border-4 border-white bg-emerald-500"></span>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-900 text-lg tracking-tight">{{ $user->name }}</h3>
                                        <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest">Mahasiswa PSTI</p>
                                    </div>
                                </div>
                                <a href="/chat/private/{{ $user->id }}" class="px-7 py-3 bg-slate-900 hover:bg-violet-600 text-white text-xs font-bold rounded-2xl shadow-lg shadow-slate-100 transition-all uppercase tracking-wider">
                                    Mulai Chat
                                </a>
                            </div>
                        @empty
                            <div class="p-12 text-center bg-white rounded-[32px] border border-dashed border-slate-300">
                                <p class="text-slate-400 font-medium italic uppercase text-sm">Belum ada teman untuk diajak ghibah materi, beb.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </section>
        </div>
    </main>

</body>
</html>
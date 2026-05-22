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
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="min-h-screen text-slate-900 relative">

    <header class="sticky top-0 z-40 border-b border-slate-200 glass-effect">
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
                        <a href="/beranda" class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm transition-all {{ request()->is('beranda*') ? 'bg-violet-50 text-violet-700 font-bold' : 'text-slate-600 font-medium hover:bg-slate-100 hover:text-slate-900' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->is('beranda*') ? 'opacity-100' : 'opacity-70 group-hover:opacity-100' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Beranda
                        </a>

                        <a href="/contacts" class="group flex items-center justify-between rounded-2xl px-4 py-3 text-sm transition-all {{ request()->is('contacts*') || request()->is('chat*') ? 'bg-violet-50 text-violet-700 font-bold' : 'text-slate-600 font-medium hover:bg-slate-100 hover:text-slate-900' }}">
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->is('contacts*') || request()->is('chat*') ? 'opacity-100' : 'opacity-70 group-hover:opacity-100' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                Pesan
                            </div>
                        </a>

                        <a href="/search" class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm transition-all {{ request()->is('search*') ? 'bg-violet-50 text-violet-700 font-bold' : 'text-slate-600 font-medium hover:bg-slate-100 hover:text-slate-900' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->is('search*') ? 'opacity-100' : 'opacity-70 group-hover:opacity-100' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            Search
                        </a>

                        <a href="/notifications" class="group flex items-center justify-between rounded-2xl px-4 py-3 text-sm transition-all {{ request()->is('notifications*') ? 'bg-violet-50 text-violet-700 font-bold' : 'text-slate-600 font-medium hover:bg-slate-100 hover:text-slate-900' }}">
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->is('notifications*') ? 'opacity-100' : 'opacity-70 group-hover:opacity-100' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                Notifikasi
                            </div>
                            @php $unreadCount = auth()->user()->unreadNotificationsCount(); @endphp
                            @if($unreadCount > 0)
                                <span class="flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-[10px] text-white font-bold shadow-sm">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </a>

                        <a href="/leaderboard" class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm transition-all {{ request()->is('leaderboard*') ? 'bg-violet-50 text-violet-700 font-bold' : 'text-slate-600 font-medium hover:bg-slate-100 hover:text-slate-900' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->is('leaderboard*') ? 'opacity-100' : 'opacity-70 group-hover:opacity-100' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            Leaderboard
                        </a>

                        <a href="/profile" class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm transition-all {{ request()->is('profile*') ? 'bg-violet-50 text-violet-700 font-bold' : 'text-slate-600 font-medium hover:bg-slate-100 hover:text-slate-900' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->is('profile*') ? 'opacity-100' : 'opacity-70 group-hover:opacity-100' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            Profil
                        </a>
                    </nav>
                </div>
            </aside>

            <section class="lg:col-span-9 space-y-8">
                
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 shadow-sm shadow-emerald-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 14v6.5" /></svg>
                        </div>
                        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Ruang Kelas Pembelajaran</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($classrooms as $class)
                            <div class="card-hover flex items-center justify-between p-5 bg-white rounded-[28px] border border-slate-200 shadow-sm">
                                <div class="flex items-center gap-4">
                                    @if($class->photo)
                                        <img src="{{ asset('storage/' . $class->photo) }}" class="h-14 w-14 rounded-2xl object-cover shadow-lg border border-emerald-100" />
                                    @else
                                        <div class="h-14 w-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-700 flex items-center justify-center text-white font-bold text-2xl shadow-lg shadow-emerald-100">
                                            🎓
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="font-bold text-slate-900 line-clamp-1 uppercase tracking-tight">{{ $class->name }}</h3>
                                        <p class="text-[10px] text-emerald-500 font-bold uppercase tracking-wider mt-0.5">Ruang Kelas Aktif</p>
                                    </div>
                                </div>
                                <a href="/chat/{{ $class->id }}" class="px-5 py-2.5 bg-emerald-50 hover:bg-emerald-600 text-emerald-700 hover:text-white text-xs font-bold rounded-xl transition-all shadow-sm">
                                    Masuk
                                </a>
                            </div>
                        @empty
                            <div class="col-span-full p-8 text-center bg-white rounded-[32px] border border-dashed border-slate-300">
                                <p class="text-slate-400 font-medium italic text-sm">Belum ada ruang kelas yang kamu ikutin nih</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-100 text-violet-600 shadow-sm shadow-violet-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            </div>
                            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Grup Mahasiswa</h2>
                        </div>
                        
                        <button onclick="document.getElementById('groupModal').classList.remove('hidden')" class="flex items-center gap-2 bg-slate-900 hover:bg-violet-600 text-white px-5 py-2.5 rounded-xl font-bold text-sm transition-all shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                            Buat Grup
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($groups as $group)
                            <div class="card-hover flex items-center justify-between p-5 bg-white rounded-[28px] border border-slate-200 shadow-sm">
                                <div class="flex items-center gap-4">
                                    @if($group->photo)
                                        <img src="{{ asset('storage/' . $group->photo) }}" class="h-14 w-14 rounded-2xl object-cover shadow-lg border border-violet-100" alt="Group Photo" />
                                    @else
                                        <div class="h-14 w-14 rounded-2xl bg-gradient-to-br from-violet-500 to-violet-700 flex items-center justify-center text-white font-bold text-2xl shadow-lg shadow-violet-100">
                                            #
                                        </div>
                                    @endif
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
                                <p class="text-slate-400 font-medium italic text-sm">Belum ada grup diskusi aktif. Bikin grup bareng mutual lu yuk!</p>
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
                                        <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest">Mahasiswa</p>
                                    </div>
                                </div>
                                <a href="/chat/private/{{ $user->id }}" class="px-7 py-3 bg-slate-900 hover:bg-violet-600 text-white text-xs font-bold rounded-2xl shadow-lg shadow-slate-100 transition-all uppercase tracking-wider">
                                    Mulai Chat
                                </a>
                            </div>
                        @empty
                            <div class="p-12 text-center bg-white rounded-[32px] border border-dashed border-slate-300">
                                <p class="text-slate-400 font-medium italic text-sm">Lu belum follow siapa-siapa, beb. Cari temen di menu Search gih!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </section>
        </div>
    </main>

    <div id="groupModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div class="w-full max-w-md rounded-[32px] bg-white p-8 shadow-2xl">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-extrabold text-slate-900">Buat Grup Baru</h3>
                <button onclick="document.getElementById('groupModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 bg-slate-100 p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            
            <form action="/chat/group/create" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Nama Grup</label>
                    <input type="text" name="name" placeholder="Misal: Tim Mabar RPL..." class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 rounded-2xl px-5 py-3.5 text-sm transition-all outline-none" required>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Tipe Ruangan</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="group" class="peer sr-only" checked>
                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-3 text-center hover:bg-slate-100 peer-checked:border-violet-600 peer-checked:bg-violet-50 peer-checked:text-violet-700 transition-all">
                                <span class="text-sm font-bold">Grup Diskusi</span>
                            </div>
                        </label>
                        
                        @if(auth()->user()->role === 'creator')
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="classroom" class="peer sr-only">
                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-3 text-center hover:bg-slate-100 peer-checked:border-emerald-600 peer-checked:bg-emerald-50 peer-checked:text-emerald-700 transition-all">
                                <span class="text-sm font-bold">Ruang Kelas</span>
                            </div>
                        </label>
                        @endif
                    </div>
                    @if(auth()->user()->role !== 'creator')
                        <p class="text-[10px] text-slate-400 mt-2 ml-1 italic">*Hanya Creator yang bisa membuat Ruang Kelas.</p>
                    @endif
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Pilih Anggota (Mutuals Only)</label>
                    <div class="max-h-48 overflow-y-auto custom-scrollbar space-y-2 pr-2">
                        @forelse($mutuals as $mutual)
                            <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 hover:bg-slate-50 cursor-pointer transition-colors">
                                <input type="checkbox" name="members[]" value="{{ $mutual->id }}" class="w-4 h-4 text-violet-600 rounded focus:ring-violet-500">
                                <img src="{{ $mutual->photo ? asset($mutual->photo) : 'https://ui-avatars.com/api/?name='.urlencode($mutual->name).'&background=f1f5f9&color=64748b' }}" class="w-8 h-8 rounded-full object-cover">
                                <span class="text-sm font-bold text-slate-800">{{ $mutual->name }}</span>
                            </label>
                        @empty
                            <div class="p-4 bg-slate-50 rounded-xl text-center">
                                <p class="text-xs text-slate-500 font-medium">Belum ada mutual. Lu harus saling follow dulu buat bisa masukin ke grup.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <button type="submit" class="w-full bg-violet-600 hover:bg-violet-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-violet-200 transition-transform active:scale-95">
                    Kirim Undangan Grup
                </button>
            </form>
        </div>
    </div>

</body>
</html>
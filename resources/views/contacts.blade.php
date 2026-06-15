<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pesan | LearnLoop</title>
    
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
        /* --- HIGH-CONTRAST POP-UP STYLE (3D SOLID BLOK) --- */
        .btn-pop-white {
            background: #ffffff;
            border: 2px solid #cbd5e1;
            box-shadow: 0px 5px 0px #cbd5e1;
            transition: all 0.15s ease;
        }
        .btn-pop-white:active { transform: translateY(5px); box-shadow: 0px 0px 0px #cbd5e1; }
        .dark .btn-pop-white { background: #161245; border: 2px solid #2e2773; box-shadow: 0px 5px 0px #0d0a2d; color: white; }

        .btn-pop-purple {
            background: #7c3aed;
            border: 2px solid #a78bfa;
            box-shadow: 0px 4px 0px #5b21b6;
            transition: all 0.15s ease;
        }
        .btn-pop-purple:active { transform: translateY(4px); box-shadow: 0px 0px 0px #5b21b6; }
        .dark .btn-pop-purple { background: #7c3aed; border: 2px solid #a78bfa; box-shadow: 0px 4px 0px #4c1d95; }

        .card-pop-solid {
            background: #ffffff;
            border: 2px solid #e2e8f0;
            box-shadow: 0px 4px 0px #e2e8f0;
        }
        .dark .card-pop-solid { background: #161245; border: 2px solid #2e2773; box-shadow: 0px 4px 0px #0d0a2d; }

        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 999px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #2e2773; }
    </style>
</head>
<body class="h-screen w-screen bg-[#f0f2fe] dark:bg-[#060412] text-[#1e1b4b] dark:text-[#f3f1fa] antialiased font-sans p-3 md:p-6 flex items-center justify-center overflow-hidden transition-colors duration-300">

    <!-- BINGKAI UTAMA DASHBOARD MELAYANG (GRID 12 KOLOM) -->
    <div class="w-full max-w-[1440px] h-full bg-[#f8fafc] dark:bg-[#0b0822] rounded-[3.5rem] p-4 md:p-6 border-4 border-slate-200 dark:border-slate-800 shadow-xl grid grid-cols-1 lg:grid-cols-12 gap-6 overflow-hidden relative">
        
        <!-- KOLOM 1: SIDEBAR KIRI (lg:col-span-2) -->
        <div class="lg:col-span-2 h-full overflow-hidden">
            @include('components.sidebar')
        </div>

        <!-- KOLOM 2: MAIN WORKSPACE - SECTIONS LIST RUANGAN CHAT (lg:col-span-10) -->
        <main class="lg:col-span-10 h-full flex flex-col bg-white dark:bg-[#110d35] rounded-[2.5rem] border-2 border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden">
            
            <!-- STICKY HEADER INTERNAL AREA -->
            <header class="p-6 border-b border-slate-100 dark:border-slate-800/80 bg-slate-50/50 dark:bg-[#161245]/30 flex items-center justify-between shrink-0">
                <div>
                    <h1 class="text-base font-black text-purple-950 dark:text-white uppercase tracking-wider">Ruang Obrolan</h1>
                    <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500">Koneksi pembelajaran aktif, kelas virtual, dan pesan privat.</p>
                </div>

                <div class="flex items-center gap-4">
                    <button @click="darkMode = !darkMode; localStorage.setItem('theme', darkMode ? 'dark' : 'light')" class="btn-pop-white p-2.5 rounded-xl text-xs">
                        <span x-show="!darkMode">🌙</span><span x-show="darkMode">☀️</span>
                    </button>
                    
                    <div class="flex items-center gap-3 pl-3 border-l border-slate-200 dark:border-slate-800">
                        <span class="text-xs font-black text-slate-700 dark:text-slate-300 hidden md:block">{{ Auth::user()->name }}</span>
                        <a href="/profile" class="transition-transform hover:scale-105 active:scale-95">
                            <img src="{{ Auth::user()->photo ? asset(Auth::user()->photo) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name ?? 'User').'&background=8b5cf6&color=ffffff&rounded=true' }}" 
                                 class="h-9 w-9 rounded-xl object-cover border-2 border-purple-500" />
                        </a>
                    </div>
                </div>
            </header>

            <!-- CONTAINER TENGAH SCROLLABLE SECARA INDEPENDEN -->
            <div class="flex-1 overflow-y-auto p-6 space-y-10 custom-scrollbar bg-slate-50/20 dark:bg-[#0e0a2f]/10">
                
                <!-- SECTION 1: RUANG KELAS PEMBELAJARAN -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2.5 px-1">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-950/50 text-purple-600 dark:text-purple-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 14v6.5" /></svg>
                        </div>
                        <h2 class="text-xs font-black uppercase tracking-widest text-slate-800 dark:text-slate-200">Ruang Kelas Pembelajaran</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($classrooms as $class)
                            <div class="card-pop-solid flex items-center justify-between p-4 bg-white dark:bg-[#161245] border-2 border-slate-200 dark:border-slate-800 rounded-2xl transition-all hover:translate-x-1">
                                <div class="flex items-center gap-4 min-w-0">
                                    @if($class->photo)
                                        <img src="{{ asset('storage/' . $class->photo) }}" class="h-11 w-11 rounded-xl object-cover border border-slate-100 dark:border-slate-700 shrink-0" />
                                    @else
                                        <div class="h-11 w-11 rounded-xl bg-gradient-to-br from-purple-500 to-purple-700 flex items-center justify-center text-white text-lg shrink-0 shadow-sm">
                                            🎓
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <h3 class="font-black text-xs text-purple-950 dark:text-white truncate uppercase tracking-tight">{{ $class->name }}</h3>
                                        <p class="text-[9px] text-purple-500 dark:text-purple-400 font-bold uppercase tracking-wider mt-0.5">Ruang Kelas Aktif</p>
                                    </div>
                                </div>
                                <a href="/chat/{{ $class->id }}" class="shrink-0 px-4 py-1.5 bg-purple-50 dark:bg-purple-950/40 text-purple-700 dark:text-purple-400 text-[11px] font-black rounded-xl hover:bg-purple-600 dark:hover:bg-purple-600 hover:text-white dark:hover:text-white transition-all">
                                    Masuk
                                </a>
                            </div>
                        @empty
                            <div class="col-span-full p-6 text-center bg-white dark:bg-[#161245] rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-800/80">
                                <p class="text-slate-400 dark:text-slate-500 font-bold text-xs uppercase tracking-wider italic">Belum ada ruang kelas yang kamu ikutin nih</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- SECTION 2: GRUP MAHASISWA -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between px-1">
                        <div class="flex items-center gap-2.5">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-950/50 text-purple-600 dark:text-purple-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            </div>
                            <h2 class="text-xs font-black uppercase tracking-widest text-slate-800 dark:text-slate-200">Grup Mahasiswa</h2>
                        </div>
                        
                        <button onclick="document.getElementById('groupModal').classList.remove('hidden')" class="btn-pop-purple flex items-center gap-1.5 text-white px-3.5 py-2 rounded-xl font-black text-[11px] uppercase tracking-wider bg-purple-600 hover:bg-purple-700 border-purple-400 dark:border-purple-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                            Buat Grup
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($groups as $group)
                            <div class="card-pop-solid flex items-center justify-between p-4 bg-white dark:bg-[#161245] border-2 border-slate-200 dark:border-slate-800 rounded-2xl transition-all hover:translate-x-1">
                                <div class="flex items-center gap-4 min-w-0">
                                    @if($group->photo)
                                        <img src="{{ asset('storage/' . $group->photo) }}" class="h-11 w-11 rounded-xl object-cover border border-slate-100 dark:border-slate-700 shrink-0" alt="Group Photo" />
                                    @else
                                        <div class="h-11 w-11 rounded-xl bg-gradient-to-br from-purple-500 to-purple-700 flex items-center justify-center text-white text-lg font-bold shrink-0 shadow-sm">
                                            #
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <h3 class="font-black text-xs text-purple-950 dark:text-white truncate uppercase tracking-tight">{{ $group->name }}</h3>
                                        <div class="flex items-center gap-1.5 mt-0.5">
                                            <span class="h-1.5 w-1.5 rounded-full bg-purple-500 animate-pulse"></span>
                                            <p class="text-[9px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider">Aktif Diskusi</p>
                                        </div>
                                    </div>
                                </div>
                                <a href="/chat/{{ $group->id }}" class="shrink-0 px-4 py-1.5 bg-purple-50 dark:bg-purple-950/40 text-purple-700 dark:text-purple-400 text-[11px] font-black rounded-xl hover:bg-purple-600 dark:hover:bg-purple-600 hover:text-white dark:hover:text-white transition-all">
                                    Buka
                                </a>
                            </div>
                        @empty
                            <div class="col-span-full p-8 text-center bg-white dark:bg-[#161245] rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-800/80">
                                <p class="text-slate-400 dark:text-slate-500 font-bold text-xs uppercase tracking-wider italic">Belum ada grup diskusi aktif. Bikin grup bareng mutual lu yuk!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- SECTION 3: PESAN PRIBADI -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2.5 px-1">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-950/50 text-blue-600 dark:text-blue-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                        </div>
                        <h2 class="text-xs font-black uppercase tracking-widest text-slate-800 dark:text-slate-200">Pesan Pribadi</h2>
                    </div>

                    <div class="grid grid-cols-1 gap-3">
                        @forelse($users as $user)
                            <div class="card-pop-solid flex items-center justify-between p-3.5 bg-white dark:bg-[#161245] border-2 border-slate-200 dark:border-slate-800 rounded-2xl transition-all hover:translate-x-1">
                                <div class="flex items-center gap-3.5 min-w-0">
                                    <div class="relative shrink-0">
                                        <img src="{{ $user->photo ? asset($user->photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=7c3aed&color=ffffff&rounded=true' }}" 
                                             class="h-11 w-11 rounded-full object-cover border border-slate-100 dark:border-slate-700" alt="{{ $user->name }}" />
                                        <span class="absolute bottom-0 right-0 h-3 w-3 rounded-full border-2 border-white dark:border-[#161245] bg-purple-500"></span>
                                    </div>
                                    <div class="min-w-0">
                                        <h3 class="font-black text-xs text-purple-950 dark:text-white truncate tracking-tight">{{ $user->name }}</h3>
                                        <p class="text-[9px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-widest mt-0.5">Mahasiswa</p>
                                    </div>
                                </div>
                                <a href="/chat/private/{{ $user->id }}" class="shrink-0 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-[10px] font-black rounded-xl transition-all uppercase tracking-wider shadow-sm">
                                    Mulai Chat
                                </a>
                            </div>
                        @empty
                            <div class="p-8 text-center bg-white dark:bg-[#161245] rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-800/80">
                                <p class="text-slate-400 dark:text-slate-500 font-bold text-xs uppercase tracking-wider italic">Lu belum follow siapa-siapa, beb. Cari temen di menu Search gih!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- MODAL POPUP: BUAT GRUP BARU (FIXED OVERLAY) -->
    <div id="groupModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 dark:bg-[#03010a]/80 backdrop-blur-sm">
        <div class="w-full max-w-md bg-white dark:bg-[#110d35] rounded-[2rem] border-4 border-slate-200 dark:border-slate-800 p-6 shadow-2xl relative max-h-[90vh] flex flex-col overflow-hidden">
            
            <div class="flex justify-between items-center pb-4 border-b border-slate-100 dark:border-slate-800/80 shrink-0">
                <h3 class="text-sm font-black uppercase tracking-wider text-purple-950 dark:text-white">Buat Grup Baru</h3>
                <button onclick="document.getElementById('groupModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 dark:hover:text-white bg-slate-100 dark:bg-[#161245] p-1.5 rounded-xl transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            
            <form action="/chat/group/create" method="POST" class="flex-1 flex flex-col overflow-hidden pt-4">
                @csrf
                <div class="flex-1 overflow-y-auto pr-1 space-y-4 custom-scrollbar">
                    
                    <!-- Input Nama Grup -->
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2 ml-1">Nama Grup</label>
                        <input type="text" name="name" placeholder="Misal: Tim Mabar RPL..." class="w-full bg-slate-50 dark:bg-[#0c0926] border border-slate-200 dark:border-slate-800 text-slate-800 dark:text-white font-medium focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 rounded-xl px-4 py-3 text-xs outline-none transition-all" required>
                    </div>

                    <!-- Pilihan Tipe Ruangan -->
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2 ml-1">Tipe Ruangan</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="cursor-pointer">
                                <input type="radio" name="type" value="group" class="peer sr-only" checked>
                                <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-[#0c0926] p-3 text-center hover:bg-slate-100 dark:hover:bg-[#161245] peer-checked:border-purple-600 peer-checked:bg-purple-50 dark:peer-checked:bg-purple-950/30 dark:peer-checked:border-purple-500 text-slate-700 dark:text-slate-300 peer-checked:text-purple-700 dark:peer-checked:text-purple-400 font-bold text-xs transition-all">
                                    Grup Diskusi
                                </div>
                            </label>
                            
                            @if(auth()->user()->role === 'creator')
                            <label class="cursor-pointer">
                                <input type="radio" name="type" value="classroom" class="peer sr-only">
                                <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-[#0c0926] p-3 text-center hover:bg-slate-100 dark:hover:bg-[#161245] peer-checked:border-purple-600 peer-checked:bg-purple-50 dark:peer-checked:bg-purple-950/30 dark:peer-checked:border-purple-500 text-slate-700 dark:text-slate-300 peer-checked:text-purple-700 dark:peer-checked:text-purple-400 font-bold text-xs transition-all">
                                    Ruang Kelas
                                </div>
                            </label>
                            @endif
                        </div>
                        @if(auth()->user()->role !== 'creator')
                            <p class="text-[9px] text-slate-400 dark:text-slate-500 mt-2 ml-1 italic">*Hanya akun Creator yang diizinkan merilis Ruang Kelas baru.</p>
                        @endif
                    </div>

                    <!-- Daftar Anggota Mutual -->
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2 ml-1">Pilih Anggota (Mutuals Only)</label>
                        <div class="max-h-40 overflow-y-auto custom-scrollbar space-y-2 pr-1.5">
                            @forelse($mutuals as $mutual)
                                <label class="flex items-center gap-3 p-2.5 rounded-xl border border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-[#0c0926]/40 hover:bg-slate-50 dark:hover:bg-[#161245] cursor-pointer transition-colors">
                                    <input type="checkbox" name="members[]" value="{{ $mutual->id }}" class="w-3.5 h-3.5 text-purple-600 dark:bg-[#0c0926] rounded border-slate-300 dark:border-slate-800 focus:ring-purple-500">
                                    <img src="{{ $mutual->photo ? asset($mutual->photo) : 'https://ui-avatars.com/api/?name='.urlencode($mutual->name).'&background=f1f5f9&color=64748b' }}" class="w-7 h-7 rounded-full object-cover">
                                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200 truncate">{{ $mutual->name }}</span>
                                </label>
                            @empty
                                <div class="p-4 bg-slate-50 dark:bg-[#0c0926] rounded-xl text-center border border-slate-100 dark:border-slate-800">
                                    <p class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wide">Belum ada mutual.</p>
                                    <p class="text-[9px] text-slate-400 dark:text-slate-500 mt-0.5">Saling follow terlebih dahulu untuk mengundang teman ke dalam grup diskusi.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 dark:border-slate-800/80 shrink-0">
                    <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-black py-3 rounded-xl text-xs uppercase tracking-widest shadow-md transition-all active:scale-[0.98]">
                        Kirim Undangan Grup
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
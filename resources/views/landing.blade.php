<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LearnLoop | Welcome</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; }

        /* Animasi Mengetik Baris 1 */
        .typewriter-1 {
            overflow: hidden;
            border-right: .15em solid #7c3aed;
            white-space: nowrap;
            margin: 0 auto;
            animation: 
                typing 2s steps(20, end),
                blink-caret .75s step-end infinite;
        }

        /* Animasi Mengetik Baris 2 (LearnLoop) */
        .typewriter-2 {
            overflow: hidden;
            white-space: nowrap;
            margin: 0 auto;
            width: 0; /* Mulai dari nol */
            animation: 
                typing 2s steps(20, end) forwards;
            animation-delay: 2s; /* Muncul setelah kata pertama selesai */
        }

        @keyframes typing {
            from { width: 0 }
            to { width: 100% }
        }

        @keyframes blink-caret {
            from, to { border-color: transparent }
            50% { border-color: #7c3aed; }
        }

        /* Animasi Aca Berjalan */
        @keyframes walk-across {
            from { transform: translateX(110vw); }
            to { transform: translateX(-20vw); }
        }
        .aca-walker {
            position: fixed;
            bottom: 40px;
            z-index: 100;
            animation: walk-across 14s linear infinite;
        }

        .aca-hand-wave {
            transform-origin: 35px 65px;
            animation: wave 0.6s ease-in-out infinite;
        }

        @keyframes wave {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(-25deg); }
        }
    </style>
</head>
<body class="min-h-screen bg-[#FDFCFE] text-slate-900">

    <div class="aca-walker">
        <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M30 45C30 30 45 20 60 20C75 20 90 30 90 45V90C90 100 82 108 70 108C65 108 62 105 60 105C58 105 55 108 50 108C38 108 30 100 30 90V45Z" fill="#B197FC"/>
            <circle cx="48" cy="65" r="7" fill="white"/><circle cx="48" cy="65" r="5" fill="#312E81"/>
            <circle cx="72" cy="65" r="7" fill="white"/><circle cx="72" cy="65" r="5" fill="#312E81"/>
            <path d="M55 78H65C65 78 64 84 60 84C56 84 55 78 55 78Z" fill="#F87171"/>
            <g class="aca-hand-wave"><path d="M30 65C25 65 20 70 20 75" stroke="#B197FC" stroke-width="8" stroke-linecap="round"/></g>
            <path d="M25 35L60 18L95 35L60 52L25 35Z" fill="#1E293B"/>
        </svg>
    </div>

    <header class="max-w-7xl mx-auto px-6 py-8 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-violet-600 rounded-xl flex items-center justify-center shadow-lg shadow-violet-200 text-white font-black text-xl">L</div>
            <span class="text-2xl font-black tracking-tight text-slate-800">LearnLoop</span>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('login') }}" class="px-6 py-2.5 font-bold text-slate-600 hover:text-violet-600 transition">Masuk</a>
            <a href="{{ route('register') }}" class="px-6 py-2.5 bg-slate-900 text-white rounded-full font-bold shadow-xl hover:bg-slate-800 transition">Daftar</a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 pt-20 pb-32 text-center">
        <div class="space-y-6">
            <div class="inline-block px-4 py-2 bg-violet-100 text-violet-700 rounded-full text-sm font-bold uppercase tracking-widest mb-4">
                ✨ Teman Belajar Terbaikmu
            </div>
            
            <div class="flex flex-col items-center">
                <h1 class="typewriter-1 text-5xl md:text-7xl font-extrabold text-slate-900 tracking-tight">
                    WELCOME TO
                </h1>
                <h1 class="typewriter-2 text-7xl md:text-9xl font-black text-violet-600 uppercase tracking-tighter mt-2">
                    LEARNLOOP
                </h1>
            </div>

            <p class="text-xl md:text-2xl text-slate-500 max-w-2xl mx-auto leading-relaxed pt-6">
                Gabung dengan ribuan mahasiswa lainnya. Bagikan catatan, diskusi tugas, dan capai impianmu bareng Aca!
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center pt-8">
                <a href="{{ route('register') }}" class="px-10 py-5 bg-violet-600 text-white rounded-2xl font-bold shadow-2xl shadow-violet-200 hover:scale-105 transition text-lg">Mulai Sekarang</a>
                <button class="px-10 py-5 bg-white border-2 border-slate-100 rounded-2xl font-bold hover:bg-slate-50 transition text-lg text-slate-700">Lihat Fitur</button>
            </div>
        </div>
    </main>

    <section class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-8 pb-24">
        <div class="p-10 bg-white rounded-[40px] border border-slate-100 shadow-sm hover:shadow-xl transition-all group text-center">
            <div class="w-16 h-16 bg-violet-50 rounded-2xl flex items-center justify-center text-4xl mb-6 mx-auto group-hover:rotate-12 transition">🤝</div>
            <h3 class="text-2xl font-bold text-slate-800">Kolaborasi</h3>
            <p class="mt-4 text-slate-500">Diskusi materi kuliah dan kerja kelompok jadi lebih seru.</p>
        </div>
        <div class="p-10 bg-white rounded-[40px] border border-slate-100 shadow-sm hover:shadow-xl transition-all group text-center">
            <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center text-4xl mb-6 mx-auto group-hover:rotate-12 transition">📑</div>
            <h3 class="text-2xl font-bold text-slate-800">Modul Lengkap</h3>
            <p class="mt-4 text-slate-500">Akses berbagai referensi materi dari kakak tingkatmu.</p>
        </div>
        <div class="p-10 bg-white rounded-[40px] border border-slate-100 shadow-sm hover:shadow-xl transition-all group text-center">
            <div class="w-16 h-16 bg-orange-50 rounded-2xl flex items-center justify-center text-4xl mb-6 mx-auto group-hover:rotate-12 transition">⚡</div>
            <h3 class="text-2xl font-bold text-slate-800">Cepat & Ringan</h3>
            <p class="mt-4 text-slate-500">Antarmuka modern yang super cepat diakses kapan saja.</p>
        </div>
    </section>

</body>
</html>
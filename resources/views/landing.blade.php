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

        /* Animasi Mengetik */
        .typewriter-1 {
            overflow: hidden;
            border-right: .15em solid #7c3aed;
            white-space: nowrap;
            margin: 0 auto;
            animation: typing 2s steps(20, end), blink-caret .75s step-end infinite;
        }

        .typewriter-2 {
            overflow: hidden;
            white-space: nowrap;
            margin: 0 auto;
            width: 0;
            animation: typing 2s steps(20, end) forwards;
            animation-delay: 2s;
        }

        @keyframes typing { from { width: 0 } to { width: 100% } }
        @keyframes blink-caret { from, to { border-color: transparent } 50% { border-color: #7c3aed; } }

        /* Animasi Aca Berjalan */
        @keyframes walk-across {
            from { transform: translateX(110vw); }
            to { transform: translateX(-30vw); } /* Disesuaikan karena maskot lebih besar */
        }
        .aca-walker {
            position: fixed;
            bottom: 20px; /* Disesuaikan posisi vertikalnya agar pas */
            z-index: 100;
            animation: walk-across 14s linear infinite;
        }

        /* Animasi Lambaian Tangan Kanan - Disesuaikan untuk ukuran besar (180x180) */
        .aca-right-hand-wave {
            /* Titik poros asli di 90,75 pada viewbox 120x120.
               Dikonversi ke viewbox 180x180 menjadi 135, 112.5 */
            transform-origin: 135px 112.5px;
            animation: wave-right 0.6s ease-in-out infinite;
        }

        @keyframes wave-right {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(20deg); }
        }
    </style>
</head>
<body class="min-h-screen bg-[#FDFCFE] text-slate-900">

    <div class="aca-walker">
        <svg width="180" height="180" viewBox="0 0 180 180" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M45 67.5C45 45 67.5 30 90 30C112.5 30 135 45 135 67.5V135C135 150 123 162 105 162C97.5 162 93 157.5 90 157.5C87 157.5 82.5 162 75 162C57 162 45 150 45 135V67.5Z" fill="#B197FC"/>
            
            <g class="eyes">
                <circle cx="72" cy="97.5" r="10.5" fill="white"/>
                <circle cx="72" cy="97.5" r="7.5" fill="#312E81"/>
                <circle cx="69" cy="94.5" r="3" fill="white"/>
                <circle cx="108" cy="97.5" r="10.5" fill="white"/>
                <circle cx="108" cy="97.5" r="7.5" fill="#312E81"/>
                <circle cx="105" cy="94.5" r="3" fill="white"/>
            </g>

            <path d="M81 117C81 117 85.5 123 90 123C94.5 123 99 117 99 117" stroke="#4C1D95" stroke-width="3.75" stroke-linecap="round"/>
            <path d="M82.5 117H97.5C97.5 117 96 126 90 126C84 126 82.5 117 82.5 117Z" fill="#F87171"/>

            <path d="M45 97.5C37.5 97.5 30 105 30 112.5" stroke="#B197FC" stroke-width="12" stroke-linecap="round"/>

            <g class="aca-right-hand-wave">
                <path d="M135 112.5C142.5 112.5 150 105 150 97.5" stroke="#B197FC" stroke-width="12" stroke-linecap="round"/>
                <g transform="translate(142.5, 67.5) rotate(15)">
                    <rect width="12" height="30" fill="#FBBF24" rx="1.5"/>
                    <path d="M0 0L6 -7.5L12 0H0Z" fill="#334155"/>
                </g>
            </g>

            <path d="M37.5 52.5L90 27L142.5 52.5L90 78L37.5 52.5Z" fill="#1E293B"/>
            <path d="M67.5 60V72C67.5 72 75 78 90 78C105 78 112.5 72 112.5 72V60" fill="#1E293B"/>

            <g class="legs-and-shoes">
                <rect x="67" y="157" width="16" height="15" fill="#B197FC"/>
                <path d="M60 170H90V177C90 180 88 182 85 182H65C62 182 60 180 60 177V170Z" fill="white"/>
                <rect x="60" y="177" width="30" height="5" fill="#7c3aed" rx="1"/> <path d="M65 173H85" stroke="#7c3aed" stroke-width="1.5" stroke-linecap="round"/> <rect x="97" y="157" width="16" height="15" fill="#B197FC"/>
                <path d="M90 170H120V177C120 180 118 182 115 182H95C92 182 90 180 90 177V170Z" fill="white"/>
                <rect x="90" y="177" width="30" height="5" fill="#7c3aed" rx="1"/> <path d="M95 173H115" stroke="#7c3aed" stroke-width="1.5" stroke-linecap="round"/> </g>
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
                <h1 class="typewriter-1 text-5xl md:text-7xl font-extrabold text-slate-900 tracking-tight">WELCOME TO</h1>
                <h1 class="typewriter-2 text-7xl md:text-9xl font-black text-violet-600 uppercase tracking-tighter mt-2">LEARNLOOP</h1>
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
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LearnLoop - Komunitas Informatika Unila</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* Efek Gradient Muter-muter (Aura) */
        @keyframes rotate-gradient {
            0% { transform: rotate(0deg) scale(1); }
            50% { transform: rotate(180deg) scale(1.1); }
            100% { transform: rotate(360deg) scale(1); }
        }

        .animate-aura {
            animation: rotate-gradient 12s linear infinite;
            filter: blur(80px);
            opacity: 0.5;
        }

        /* Glassmorphism Effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 8px 32px 0 rgba(124, 58, 237, 0.15);
        }

        /* Animasi Melayang (Floating) */
        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-25px) rotate(8deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }

        .floating {
            animation: float 5s ease-in-out infinite;
            display: inline-block;
            filter: drop-shadow(0 10px 15px rgba(0,0,0,0.1));
        }

        /* Animasi Fade In & Up */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in-up {
            animation: fadeInUp 1.2s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }
    </style>
</head>
<body class="bg-[#fcfaff] text-gray-950 overflow-x-hidden antialiased">

    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute top-[-5%] right-[-5%] w-[650px] h-[650px] bg-gradient-to-br from-purple-400/30 via-indigo-300/30 to-transparent rounded-full animate-aura"></div>
        <div class="absolute bottom-[-5%] left-[-5%] w-[550px] h-[550px] bg-gradient-to-tr from-fuchsia-300/30 via-violet-200/30 to-transparent rounded-full animate-aura" style="animation-duration: 18s; animation-direction: reverse;"></div>

        <div class="absolute left-[6%] top-[15%] text-7xl floating select-none" style="animation-duration: 6s;">📖</div>
        <div class="absolute left-[12%] top-[45%] text-5xl floating select-none" style="animation-delay: 1s; animation-duration: 7s;">💻</div>
        <div class="absolute left-[4%] bottom-[20%] text-6xl floating select-none" style="animation-delay: 2s; animation-duration: 5s;">💡</div>
        <div class="absolute left-[15%] bottom-[8%] text-4xl floating select-none" style="animation-delay: 0.5s;">🎨</div>

        <div class="absolute right-[7%] top-[12%] text-7xl floating select-none" style="animation-delay: 1.5s; animation-duration: 8s;">📚</div>
        <div class="absolute right-[14%] top-[40%] text-5xl floating select-none" style="animation-delay: 0.2s; animation-duration: 6.5s;">{ }</div>
        <div class="absolute right-[5%] bottom-[25%] text-6xl floating select-none" style="animation-delay: 1.2s; animation-duration: 5.5s;">🎓</div>
        <div class="absolute right-[16%] bottom-[10%] text-4xl floating select-none" style="animation-delay: 2.5s;">🚀</div>
    </div>

    <nav class="max-w-7xl mx-auto px-10 py-8 flex justify-between items-center relative z-10">
        <div class="flex items-center gap-2 font-extrabold text-2xl tracking-tighter">
            <span class="text-purple-600">Learn</span>Loop.
        </div>
        <div class="flex gap-4">
            <a href="/feed" class="glass-card px-8 py-3 rounded-2xl text-sm font-bold border-purple-200/50 hover:bg-purple-600 hover:text-white transition-all duration-500">
                Buka Feed
            </a>
        </div>
    </nav>

    <main class="max-w-5xl mx-auto px-8 pt-12 pb-32 flex flex-col items-center text-center relative z-10">
        
        <div class="glass-card p-16 md:p-24 rounded-[50px] fade-in-up relative overflow-hidden border border-white/60">
            
            <div class="absolute -top-24 -left-24 w-48 h-48 bg-purple-300/30 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -right-24 w-48 h-48 bg-indigo-300/30 rounded-full blur-3xl"></div>

            <span class="bg-purple-600 text-white px-5 py-1.5 rounded-full text-[10px] font-black uppercase tracking-[0.2em] mb-10 inline-block shadow-lg shadow-purple-200">
                Informatics Community
            </span>

            <h1 class="text-6xl md:text-8xl font-extrabold leading-[1] tracking-tight mb-8 text-gray-950">
                Welcome to <br> 
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-purple-600 via-violet-600 to-indigo-600">LearnLoop</span>
            </h1>

            <p class="text-gray-600 text-lg md:text-2xl max-w-2xl mx-auto mb-12 leading-relaxed font-medium">
                Wadah kolaborasi dan berbagi portofolio mahasiswa <span class="text-purple-600 font-bold">Informatika Unila</span>. Jadikan setiap progres belajarmu lebih berarti.
            </p>

            <div class="flex flex-col sm:flex-row gap-5 justify-center items-center">
                <a href="/auth" class="bg-purple-600 text-white px-12 py-5 rounded-2xl font-bold text-xl hover:shadow-2xl hover:shadow-purple-300 hover:-translate-y-2 transition-all duration-300 w-full sm:w-auto">
    Mulai Eksplorasi
</a>
                </a>
                <button class="glass-card px-12 py-5 rounded-2xl font-bold text-xl hover:bg-white/80 transition-all w-full sm:w-auto border border-purple-100">
                    Pelajari Fitur
                </button>
            </div>
        </div>

        <div class="mt-16 fade-in-up" style="animation-delay: 0.4s;">
            <p class="text-gray-400 text-sm font-bold tracking-widest uppercase mb-2">Designed & Developed by</p>
            <div class="flex items-center gap-3 justify-center">
                <div class="h-[1px] w-8 bg-gray-200"></div>
                <span class="text-gray-800 font-extrabold text-lg">Yaza Nurzahira</span>
                <div class="h-[1px] w-8 bg-gray-200"></div>
            </div>
        </div>
    </main>

</body>
</html>
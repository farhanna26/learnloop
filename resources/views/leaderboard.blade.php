<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Leaderboard | LearnLoop</title>
    
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
        .card-feed {
            background: #ffffff;
            border-radius: 2.25rem;
            border: 2px solid #e2e8f0;
            box-shadow: 0px 14px 0px #cbd5e1;
            transition: all 0.2s ease-in-out;
        }
        .dark .card-feed { background: #161245; border: 2px solid #2e2773; box-shadow: 0px 14px 0px #0d0a2d; }

        .btn-pop-white {
            background: #ffffff;
            border: 2px solid #cbd5e1;
            box-shadow: 0px 5px 0px #cbd5e1;
            transition: all 0.15s ease;
        }
        .btn-pop-white:active { transform: translateY(5px); box-shadow: 0px 0px 0px #cbd5e1; }
        .dark .btn-pop-white { background: #161245; border: 2px solid #2e2773; box-shadow: 0px 5px 0px #0d0a2d; color: white; }

        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 999px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #2e2773; }

        /* Podium Scale Alignment */
        .podium-1 { transform: scale(1.1); z-index: 10; }
        .podium-2 { margin-bottom: 0px; }
        .podium-3 { margin-bottom: 0px; }
    </style>
</head>
<body class="h-screen w-screen bg-[#f0f2fe] dark:bg-[#060412] text-[#1e1b4b] dark:text-[#f3f1fa] antialiased font-sans p-3 md:p-6 flex items-center justify-center overflow-hidden transition-colors duration-300">

    <div class="w-full max-w-[1440px] h-full bg-[#f8fafc] dark:bg-[#0b0822] rounded-[3.5rem] p-4 md:p-6 border-4 border-slate-200 dark:border-slate-800 shadow-xl grid grid-cols-1 lg:grid-cols-12 gap-6 overflow-hidden">
        
        <div class="lg:col-span-2 h-full overflow-hidden">
            @include('components.sidebar')
        </div>

        <main class="lg:col-span-10 h-full flex flex-col bg-white dark:bg-[#110d35] rounded-[2.5rem] border-2 border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden relative">
            
            <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between bg-slate-50/50 dark:bg-[#161245]/30 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-xl flex items-center justify-center text-xl shadow-md">
                        🏆
                    </div>
                    <div>
                        <h1 class="text-base font-black text-purple-950 dark:text-white uppercase tracking-wider">Papan Peringkat</h1>
                        <p class="text-[9px] font-bold text-slate-400 dark:text-slate-500">Siapa yang paling ambis hari ini?</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    <button @click="darkMode = !darkMode; localStorage.setItem('theme', darkMode ? 'dark' : 'light')" class="btn-pop-white p-2.5 rounded-xl text-xs">
                        <span x-show="!darkMode">🌙</span><span x-show="darkMode">☀️</span>
                    </button>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto p-6 space-y-6 custom-scrollbar bg-slate-50/30 dark:bg-[#0e0a2f]/20">
                
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-100/80 dark:bg-[#0d0926] p-3 rounded-2xl border border-slate-200/50 dark:border-slate-800/60">
                    <div class="flex gap-2 flex-1">
                        <button onclick="changeCategory('pembelajaran')" id="tab-pembelajaran" class="cat-tab flex-1 py-2.5 px-4 text-xs font-black rounded-xl border-2 border-purple-600 bg-purple-600 text-white transition-all uppercase tracking-wider">
                            📚 Poin Tugas
                        </button>
                        <button onclick="changeCategory('portofolio')" id="tab-portofolio" class="cat-tab flex-1 py-2.5 px-4 text-xs font-black rounded-xl border-2 border-transparent text-slate-500 dark:text-purple-300/60 hover:text-purple-600 transition-all uppercase tracking-wider">
                            🎨 Poin Postingan
                        </button>
                    </div>
                    
                    <div class="flex bg-slate-200/70 dark:bg-[#161245] p-1 rounded-xl shrink-0">
                        <button onclick="changeTime('today')" id="btn-today" class="time-btn px-3 py-1.5 text-[11px] font-black rounded-lg transition-all text-slate-500 dark:text-slate-400 hover:text-slate-900">Hari Ini</button>
                        <button onclick="changeTime('week')" id="btn-week" class="time-btn px-3 py-1.5 text-[11px] font-black rounded-lg transition-all text-slate-500 dark:text-slate-400 hover:text-slate-900">Minggu Ini</button>
                        <button onclick="changeTime('month')" id="btn-month" class="time-btn px-3 py-1.5 text-[11px] font-black rounded-lg transition-all bg-white dark:bg-[#0d0926] shadow-sm text-slate-900 dark:text-white">Bulan Ini</button>
                    </div>
                </div>

                <div id="loading" class="hidden py-16 w-full text-center">
                    <svg class="animate-spin h-8 w-8 text-purple-600 mx-auto mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <p class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Menghitung skor terbaru...</p>
                </div>

                <div id="leaderboard-content" class="transition-opacity duration-300 space-y-8">
                    
                    <div id="podium-container" class="flex justify-center items-end gap-2 sm:gap-8 pt-6 pb-2 min-h-[180px]"></div>

                    <div class="bg-slate-50 dark:bg-[#0d0926]/50 rounded-3xl p-4 md:p-6 border border-slate-200/60 dark:border-slate-800">
                        <div class="flex px-4 pb-3 border-b border-slate-200 dark:border-slate-800 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-4">
                            <div class="w-14">Rank</div>
                            <div class="flex-1">Mahasiswa</div>
                            <div class="text-right pr-2">Skor Total</div>
                        </div>
                        
                        <div id="list-container" class="space-y-2.5"></div>
                    </div>

                </div>

            </div>
        </main>

    </div>

    <script>
        let currentCategory = 'pembelajaran';
        let currentTime = 'month';

        async function fetchLeaderboard() {
            document.getElementById('loading').classList.remove('hidden');
            document.getElementById('leaderboard-content').style.opacity = '0';

            try {
                const response = await fetch(`/leaderboard/data?category=${currentCategory}&time=${currentTime}&_=${new Date().getTime()}`);
                const result = await response.json();
                
                if (result.success) {
                    renderUI(result.data);
                }
            } catch (error) {
                console.error("Error fetching data:", error);
            } finally {
                document.getElementById('loading').classList.add('hidden');
                document.getElementById('leaderboard-content').style.opacity = '1';
            }
        }

        function renderUI(data) {
            const podiumContainer = document.getElementById('podium-container');
            const listContainer = document.getElementById('list-container');
            
            podiumContainer.innerHTML = '';
            listContainer.innerHTML = '';

            if (data.length === 0) {
                podiumContainer.innerHTML = `<div class="text-center w-full py-10 text-slate-400 dark:text-slate-500 font-bold text-xs uppercase tracking-wide">Belum ada skor yang tercatat. Ayo jadi yang pertama!</div>`;
                return;
            }

            const getPhoto = (name, photo) => {
                if (!photo) return `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=8b5cf6&color=ffffff&bold=true`;
                return photo.startsWith('http') ? photo : (photo.startsWith('profile-photos') ? `/${photo}` : `/storage/${photo}`);
            };

            const top3 = [data[1], data[0], data[2]]; 
            const podiumOrder = [2, 1, 3];
            const medalColors = [
                'bg-slate-200 text-slate-700 ring-slate-300', 
                'bg-amber-400 text-white ring-amber-400', 
                'bg-orange-300 text-white ring-orange-300'
            ];

            top3.forEach((user, index) => {
                if (!user) return; 
                
                const rank = podiumOrder[index];
                const ringColor = rank === 1 ? 'border-amber-400' : (rank === 2 ? 'border-slate-300' : 'border-orange-300');
                
                const html = `
                    <div class="flex flex-col items-center podium-${rank} w-24 sm:w-32 animate-card">
                        <div class="relative mb-3">
                            <img src="${getPhoto(user.name, user.photo)}" class="w-14 h-14 sm:w-16 sm:h-16 rounded-full object-cover border-4 ${ringColor} shadow-md bg-white dark:bg-[#161245]">
                            <div class="absolute -bottom-2 left-1/2 -translate-x-1/2 w-6 h-6 rounded-full ${medalColors[index].split(' ')[0]} ${medalColors[index].split(' ')[1]} flex items-center justify-center text-[10px] font-black shadow border border-white dark:border-slate-900 z-10">
                                ${rank}
                            </div>
                            ${rank === 1 ? '<div class="absolute -top-5 left-1/2 -translate-x-1/2 text-xl">👑</div>' : ''}
                        </div>
                        <h3 class="font-black text-purple-950 dark:text-white text-[11px] sm:text-xs text-center truncate w-full px-1">${user.name}</h3>
                        <p class="text-[10px] font-black text-purple-600 dark:text-purple-400 mt-0.5 bg-purple-50 dark:bg-purple-950/40 px-2 py-0.5 rounded-full">${user.score} Pts</p>
                    </div>
                `;
                podiumContainer.innerHTML += html;
            });

            const restOfUsers = data.slice(3);
            if(restOfUsers.length === 0 && data.length <= 3) {
                listContainer.innerHTML = `<div class="text-center py-4 text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase">Hanya ada ${data.length} peringkat saat ini.</div>`;
            }

            restOfUsers.forEach((user, index) => {
                const rank = index + 4;
                const html = `
                    <div class="flex items-center bg-white dark:bg-[#161245] p-3 rounded-2xl border border-slate-200/50 dark:border-slate-800/80 transition-all hover:translate-x-1">
                        <div class="w-14 text-center font-black text-slate-400 dark:text-slate-500 text-xs">#${rank}</div>
                        <div class="flex-1 flex items-center gap-3 min-w-0">
                            <img src="${getPhoto(user.name, user.photo)}" class="w-9 h-9 rounded-full object-cover border border-slate-100 dark:border-slate-800">
                            <span class="font-bold text-purple-950 dark:text-slate-200 text-xs truncate pr-2">${user.name}</span>
                        </div>
                        <div class="font-black text-purple-600 dark:text-purple-400 text-xs pr-2 bg-purple-50 dark:bg-purple-950/30 px-3 py-1.5 rounded-xl">${user.score} Pts</div>
                    </div>
                `;
                listContainer.innerHTML += html;
            });
        }

        function changeTime(time) {
            currentTime = time;
            document.querySelectorAll('.time-btn').forEach(btn => {
                btn.className = 'time-btn px-3 py-1.5 text-[11px] font-black rounded-lg transition-all text-slate-500 dark:text-slate-400 hover:text-slate-900';
            });
            document.getElementById(`btn-${time}`).className = 'time-btn px-3 py-1.5 text-[11px] font-black rounded-lg transition-all bg-white dark:bg-[#0d0926] shadow-sm text-slate-900 dark:text-white';
            fetchLeaderboard();
        }

        function changeCategory(cat) {
            currentCategory = cat;
            document.querySelectorAll('.cat-tab').forEach(tab => {
                tab.className = 'cat-tab flex-1 py-2.5 px-4 text-xs font-black rounded-xl border-2 border-transparent text-slate-500 dark:text-purple-300/60 hover:text-purple-600 transition-all uppercase tracking-wider';
            });
            const activeTab = document.getElementById(`tab-${cat}`);
            activeTab.className = `cat-tab flex-1 py-2.5 px-4 text-xs font-black rounded-xl border-2 border-purple-600 bg-purple-600 text-white transition-all uppercase tracking-wider`;
            fetchLeaderboard();
        }

        document.addEventListener("DOMContentLoaded", fetchLeaderboard);
    </script>
</body>
</html>
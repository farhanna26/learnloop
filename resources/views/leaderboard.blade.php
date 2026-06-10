<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Leaderboard | LearnLoop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .glass-effect { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        .podium-1 { transform: scale(1.15); z-index: 10; margin-bottom: 2rem; }
        .podium-2 { margin-bottom: 0.5rem; }
        .podium-3 { margin-bottom: -0.5rem; }
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
            @include('components.sidebar')
            
            <section class="lg:col-span-9 space-y-8">
                <div class="bg-white rounded-[32px] border border-slate-200 p-8 shadow-sm min-h-[70vh]">
                    
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
                        <div>
                            <h1 class="text-3xl font-extrabold text-slate-900">Papan Peringkat 🏆</h1>
                            <p class="text-sm text-slate-500 mt-1">Siapa yang paling ambis hari ini?</p>
                        </div>

                        <div class="flex bg-slate-100 p-1 rounded-2xl shrink-0">
                            <button onclick="changeTime('today')" id="btn-today" class="time-btn px-4 py-2 text-xs font-bold rounded-xl transition-all text-slate-500 hover:text-slate-900">Hari Ini</button>
                            <button onclick="changeTime('week')" id="btn-week" class="time-btn px-4 py-2 text-xs font-bold rounded-xl transition-all text-slate-500 hover:text-slate-900">Minggu Ini</button>
                            <button onclick="changeTime('month')" id="btn-month" class="time-btn px-4 py-2 text-xs font-bold rounded-xl transition-all bg-white shadow-sm text-slate-900">Bulan Ini</button>
                        </div>
                    </div>

                    <div class="flex border-b border-slate-200 mb-12">
                        <button onclick="changeCategory('pembelajaran')" id="tab-pembelajaran" class="cat-tab flex-1 py-4 text-sm font-bold border-b-4 border-violet-600 text-violet-700 transition-colors">
                            📚 Poin Pembelajaran (Tugas)
                        </button>
                        <button onclick="changeCategory('portofolio')" id="tab-portofolio" class="cat-tab flex-1 py-4 text-sm font-bold border-b-4 border-transparent text-slate-500 hover:text-slate-900 transition-colors">
                            🎨 Poin Portofolio (Postingan)
                        </button>
                    </div>

                    <div id="loading" class="hidden py-20 w-full text-center">
                        <svg class="animate-spin h-10 w-10 text-violet-600 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <p class="text-sm font-bold text-slate-400">Menghitung skor...</p>
                    </div>

                    <div id="leaderboard-content" class="transition-opacity duration-300">
                        <div id="podium-container" class="flex justify-center items-end gap-2 sm:gap-6 mb-12 min-h-[200px]"></div>

                        <div class="bg-slate-50 rounded-3xl p-6 border border-slate-100">
                            <div class="flex px-4 pb-4 border-b border-slate-200 text-xs font-extrabold text-slate-400 uppercase tracking-wider mb-4">
                                <div class="w-16">Rank</div>
                                <div class="flex-1">Mahasiswa</div>
                                <div class="text-right">Skor Total</div>
                            </div>
                            <div id="list-container" class="space-y-3"></div>
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </main>

    <script>
        let currentCategory = 'pembelajaran';
        let currentTime = 'month';

        async function fetchLeaderboard() {
            document.getElementById('loading').classList.remove('hidden');
            document.getElementById('leaderboard-content').style.opacity = '0';

            try {
                // JURUS ANTI CACHE BROWSER BIAR GA NYANGKUT LAGI
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
                podiumContainer.innerHTML = `<div class="text-center w-full py-10 text-slate-400 font-medium">Belum ada skor yang tercatat. Ayo jadi yang pertama!</div>`;
                return;
            }

            const getPhoto = (name, photo) => {
                if (!photo) return `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=f1f5f9&color=64748b&bold=true`;
                return photo.startsWith('http') ? photo : (photo.startsWith('profile-photos') ? `/${photo}` : `/storage/${photo}`);
            };

            const top3 = [data[1], data[0], data[2]]; 
            const podiumOrder = [2, 1, 3];
            const medals = ['🥈', '👑', '🥉'];
            const medalColors = ['bg-slate-200 text-slate-700', 'bg-amber-400 text-white', 'bg-orange-300 text-white'];

            top3.forEach((user, index) => {
                if (!user) return; 
                
                const rank = podiumOrder[index];
                const html = `
                    <div class="flex flex-col items-center podium-${rank} w-24 sm:w-32">
                        <div class="relative mb-3">
                            <img src="${getPhoto(user.name, user.photo)}" class="w-16 h-16 sm:w-20 sm:h-20 rounded-full object-cover ring-4 ${rank === 1 ? 'ring-amber-400' : (rank === 2 ? 'ring-slate-300' : 'ring-orange-300')} shadow-lg">
                            <div class="absolute -bottom-3 left-1/2 -translate-x-1/2 w-8 h-8 rounded-full ${medalColors[index]} flex items-center justify-center text-sm font-extrabold shadow-md border-2 border-white z-10">
                                ${rank}
                            </div>
                            ${rank === 1 ? '<div class="absolute -top-6 left-1/2 -translate-x-1/2 text-3xl">👑</div>' : ''}
                        </div>
                        <h3 class="font-extrabold text-slate-900 text-xs sm:text-sm text-center line-clamp-1 w-full px-1">${user.name}</h3>
                        <p class="text-[10px] sm:text-xs font-bold text-violet-600 mt-0.5">${user.score} Pts</p>
                    </div>
                `;
                podiumContainer.innerHTML += html;
            });

            const restOfUsers = data.slice(3);
            if(restOfUsers.length === 0 && data.length <= 3) {
                listContainer.innerHTML = `<div class="text-center py-4 text-xs font-bold text-slate-400">Hanya ada ${data.length} peringkat saat ini.</div>`;
            }

            restOfUsers.forEach((user, index) => {
                const rank = index + 4;
                const html = `
                    <div class="flex items-center bg-white p-3 rounded-2xl shadow-sm border border-slate-100 transition-transform hover:-translate-y-1">
                        <div class="w-16 text-center font-extrabold text-slate-400 text-sm">#${rank}</div>
                        <div class="flex-1 flex items-center gap-3">
                            <img src="${getPhoto(user.name, user.photo)}" class="w-10 h-10 rounded-full object-cover ring-2 ring-slate-50">
                            <span class="font-bold text-slate-900 text-sm">${user.name}</span>
                        </div>
                        <div class="font-extrabold text-violet-600 text-sm pr-4">${user.score}</div>
                    </div>
                `;
                listContainer.innerHTML += html;
            });
        }

        function changeTime(time) {
            currentTime = time;
            document.querySelectorAll('.time-btn').forEach(btn => {
                btn.className = 'time-btn px-4 py-2 text-xs font-bold rounded-xl transition-all text-slate-500 hover:text-slate-900';
            });
            document.getElementById(`btn-${time}`).className = 'time-btn px-4 py-2 text-xs font-bold rounded-xl transition-all bg-white shadow-sm text-slate-900';
            fetchLeaderboard();
        }

        function changeCategory(cat) {
            currentCategory = cat;
            document.querySelectorAll('.cat-tab').forEach(tab => {
                tab.className = 'cat-tab flex-1 py-4 text-sm font-bold border-b-4 border-transparent text-slate-500 hover:text-slate-900 transition-colors';
            });
            const activeTab = document.getElementById(`tab-${cat}`);
            activeTab.className = `cat-tab flex-1 py-4 text-sm font-bold border-b-4 border-violet-600 text-violet-700 transition-colors`;
            fetchLeaderboard();
        }

        document.addEventListener("DOMContentLoaded", fetchLeaderboard);

    </script>
</body>
</html>
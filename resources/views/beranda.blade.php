<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LearnLoop | Platform Kolaborasi Mahasiswa</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: { brand: '#7c3aed' }
                }
            }
        }
    </script>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #475569; }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    </style>
</head>
<body class="min-h-screen bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 antialiased transition-colors duration-300">

    <header class="sticky top-0 z-50 border-b border-slate-200/80 dark:border-slate-800/80 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md shadow-sm">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
            <div class="flex items-center gap-6 flex-1">
                <a href="#" class="flex items-center gap-2.5 group shrink-0">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand shadow-md shadow-brand/20 transition-transform group-hover:scale-105">
                        <span class="text-lg font-black text-white">L</span>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight bg-gradient-to-r from-brand to-violet-500 bg-clip-text text-transparent">LearnLoop</span>
                </a>
                
                <div class="relative hidden md:block w-full max-w-md">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">🔍</span>
                    <input type="text" placeholder="Cari portfolio, riset, atau teman..." class="w-full pl-9 pr-4 py-2 text-xs font-medium rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-brand/40 transition-all">
                </div>
            </div>

            <div class="flex items-center gap-4">
                <input type="file" id="fileInput" class="hidden" accept="image/*,video/*,.pdf">
                <button id="uploadBtn" class="items-center gap-1.5 rounded-xl bg-brand px-4 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-brand/90 transition-all active:scale-95 flex">
                    ➕ Upload Karya
                </button>

                <button @click="darkMode = !darkMode; localStorage.setItem('theme', darkMode ? 'dark' : 'light')" class="p-2 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all text-sm">
                    <span x-show="!darkMode">🌙</span>
                    <span x-show="darkMode">☀️</span>
                </button>
                
                <a href="/profile" class="transition-transform hover:scale-105 block shrink-0">
                    <img src="{{ Auth::user()->photo ? asset(Auth::user()->photo) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name ?? 'User').'&background=7c3aed&color=ffffff&rounded=true' }}" class="h-8 w-8 rounded-full object-cover ring-2 ring-brand/20 shadow-sm" />
                </a>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-12 items-start">
            
            <aside class="lg:col-span-3 space-y-5 sticky top-24">
                <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800/50 bg-white dark:bg-slate-900 p-5 shadow-sm text-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=7c3aed&color=ffffff" class="h-16 w-16 rounded-2xl object-cover mx-auto ring-4 ring-brand/10 border border-slate-200 dark:border-slate-800" />
                    <h2 class="mt-3 font-bold text-sm tracking-tight text-slate-900 dark:text-slate-100">{{ Auth::user()->name ?? 'Nama Pengguna' }}</h2>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-0.5">{{ Auth::user()->role ?? 'Learner' }}</p>
                </div>

                <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800/50 bg-white dark:bg-slate-900 p-3 shadow-sm space-y-1 text-xs font-bold">
                    <a href="#" class="flex items-center justify-between px-4 py-3 rounded-xl bg-brand text-white transition-all">
                        <div class="flex items-center gap-3"><span>🏠</span> Beranda</div>
                    </a>
                    <a href="/messages" class="flex items-center justify-between px-4 py-3 rounded-xl text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                        <div class="flex items-center gap-3"><span>💬</span> Ruang Pesan</div>
                        <span class="bg-brand text-white text-[9px] px-2 py-0.5 rounded-full font-black">2</span>
                    </a>
                    
                    <div x-data="{ open: false }" class="w-full">
                        <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                            <div class="flex items-center gap-3"><span>🔔</span> Notifikasi</div>
                            <span class="bg-rose-500 text-white text-[9px] px-2 py-0.5 rounded-full font-black animate-pulse">3</span>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" x-transition class="mt-2 p-2 bg-slate-50 dark:bg-slate-950 rounded-xl border border-slate-200 dark:border-slate-800 space-y-1.5 max-h-48 overflow-y-auto custom-scrollbar">
                            <div class="p-2 bg-white dark:bg-slate-900 rounded-lg border border-slate-100 dark:border-slate-800 text-[11px] font-medium text-slate-500 dark:text-slate-400">
                                <b class="text-slate-800 dark:text-slate-200">Siti Aminah</b> menyukai portofoliomu.
                            </div>
                            <div class="p-2 bg-white dark:bg-slate-900 rounded-lg border border-slate-100 dark:border-slate-800 text-[11px] font-medium text-slate-500 dark:text-slate-400">
                                Ada unggahan diskusi baru di <b class="text-brand">Kelas UI/UX</b>.
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            <section id="feedContainer" class="lg:col-span-6 space-y-4">
                @if(session('success'))
                    <div class="animate-fade-in flex items-center gap-2.5 rounded-xl border border-emerald-200 bg-emerald-50 dark:bg-emerald-950/30 p-3.5 text-xs font-bold text-emerald-800 dark:text-emerald-400 shadow-sm">
                        <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        {{ session('success') }}
                    </div>
                @endif
                
                <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800/50 bg-white dark:bg-slate-900 p-6 shadow-sm">
                    <h1 class="text-xl font-extrabold text-slate-900 dark:text-slate-100 tracking-tight">Selamat datang di Beranda Akademik! 👋</h1>
                    <p class="text-xs text-slate-400 mt-1 font-medium">Temukan riset, portofolio, dan ruang kelas kolaboratif mahasiswa hari ini.</p>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-2">
                    <div class="flex items-center gap-1 border-b border-slate-200 dark:border-slate-800 w-full sm:w-auto">
                        <button id="tab-portfolio" onclick="switchFeedType('portfolio')" class="px-4 py-2.5 text-xs font-bold text-brand border-b-2 border-brand transition-all uppercase tracking-wider">
                            💼 Portofolio
                        </button>
                        <button id="tab-learning" onclick="switchFeedType('learning')" class="px-4 py-2.5 text-xs font-bold text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 border-b-2 border-transparent transition-all uppercase tracking-wider">
                            📘 Pembelajaran
                        </button>
                    </div>

                    @if(auth()->user()->role === 'creator')
                        <button onclick="document.getElementById('learningUploadModal').classList.remove('hidden')" class="flex items-center gap-1.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-50 px-4 py-2 rounded-xl font-bold text-xs shadow-sm transition-all active:scale-95 shrink-0">
                            Bagikan Materi Pembelajaran
                        </button>
                    @endif
                </div>

                <div id="postsWrapper" class="space-y-4"></div>

                <div id="loadingIndicator" class="hidden space-y-3 p-5 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm animate-pulse">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-slate-200 dark:bg-slate-800 rounded-full"></div>
                        <div class="space-y-1.5">
                            <div class="w-20 h-2.5 bg-slate-200 dark:bg-slate-800 rounded"></div>
                            <div class="w-14 h-2 bg-slate-100 dark:bg-slate-800/50 rounded"></div>
                        </div>
                    </div>
                    <div class="w-full h-3 bg-slate-200 dark:bg-slate-800 rounded"></div>
                </div>

                <div id="noMorePosts" class="hidden text-center py-8">
                    <p class="text-slate-400 dark:text-slate-500 text-[10px] uppercase tracking-wider font-bold bg-slate-100 dark:bg-slate-900 px-4 py-2 rounded-full inline-block border border-slate-200 dark:border-slate-800">📌 Semua materi telah dimuat</p>
                </div>
            </section>

            <aside class="lg:col-span-3 space-y-5 sticky top-24">
                
                <div class="rounded-2xl border border-brand/20 bg-gradient-to-br from-violet-600 to-indigo-700 text-white p-5 shadow-lg shadow-brand/10 overflow-hidden relative">
                    <div class="absolute -right-6 -bottom-6 opacity-10 text-8xl">🤖</div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2.5">
                            <div class="h-8 w-8 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center text-base">✨</div>
                            <div>
                                <h3 class="font-bold text-xs tracking-tight">Loopy Mentor AI</h3>
                                <span class="inline-block text-[8px] bg-emerald-500 text-white font-extrabold px-1.5 rounded-full mt-0.5 uppercase">Aktif</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-[11px] text-violet-100 leading-relaxed font-medium mb-3">"Halo! Ada kendala rancangan web atau *logic* backend Laravel-mu hari ini? Yuk konsultasi!"</p>
                    
                    <div class="flex gap-1.5">
                        <input type="text" placeholder="Tanya Loopy..." class="w-full bg-white/10 placeholder-violet-200 border border-white/10 text-xs rounded-xl px-3 py-2 focus:outline-none focus:bg-white focus:text-slate-900 transition-all">
                        <button class="bg-white text-brand px-3 rounded-xl hover:bg-slate-100 transition-all text-xs">🚀</button>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800/50 bg-white dark:bg-slate-900 p-5 shadow-sm">
                    <h3 class="font-bold text-xs text-slate-800 dark:text-slate-200 uppercase tracking-wider mb-4 flex items-center gap-2">🏆 Peringkat Akademik</h3>
                    
                    <div class="space-y-2.5">
                        <div class="flex items-center justify-between p-2 rounded-xl bg-amber-500/5 border border-amber-500/10 text-xs font-medium">
                            <div class="flex items-center gap-2.5">
                                <span class="font-bold text-amber-500 w-3">1</span>
                                <img src="https://ui-avatars.com/api/?name=Siti+Aminah&background=f59e0b&color=fff" class="h-6 w-6 rounded-lg object-cover">
                                <span class="font-bold text-slate-800 dark:text-slate-200 truncate max-w-[100px]">Siti Aminah</span>
                            </div>
                            <span class="text-[10px] font-black text-amber-600">2,850 Pts</span>
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-xl text-xs font-medium">
                            <div class="flex items-center gap-2.5">
                                <span class="font-bold text-slate-400 w-3">2</span>
                                <img src="https://ui-avatars.com/api/?name=Rian+Adi&background=94a3b8&color=fff" class="h-6 w-6 rounded-lg object-cover">
                                <span class="font-bold text-slate-700 dark:text-slate-300 truncate max-w-[100px]">Rian Adi</span>
                            </div>
                            <span class="text-[10px] font-black text-slate-500">1,910 Pts</span>
                        </div>
                    </div>
                </div>
            </aside>
            
        </div>
    </main>

    <div id="editPostModal" class="fixed inset-0 z-[80] hidden flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm transition-all">
        <div class="w-full max-w-md rounded-2xl bg-white dark:bg-slate-900 p-6 shadow-xl border border-slate-200 dark:border-slate-800" id="editModalContent">
            <h3 class="text-sm font-bold mb-3">Perbarui Teks Postingan</h3>
            <input type="hidden" id="editPostId">
            <textarea id="editCaptionText" rows="4" class="w-full rounded-xl border border-slate-200 dark:border-slate-800 p-3.5 text-xs font-medium bg-slate-50 dark:bg-slate-950 focus:outline-none focus:border-brand transition-all custom-scrollbar"></textarea>
            <div class="mt-4 flex gap-2.5 text-xs font-bold">
                <button onclick="closeEditModal()" class="w-full rounded-xl bg-slate-100 dark:bg-slate-800 py-2.5">Batal</button>
                <button onclick="saveEditPost()" id="btnSaveEdit" class="w-full rounded-xl bg-brand text-white py-2.5">Simpan</button>
            </div>
        </div>
    </div>

    <div id="commentModal" class="fixed inset-0 z-[70] hidden flex items-end justify-center sm:items-center p-4 bg-slate-900/40 backdrop-blur-sm">
        <div class="w-full max-w-md rounded-2xl bg-white dark:bg-slate-900 flex flex-col shadow-xl overflow-hidden max-h-[75vh] border border-slate-200 dark:border-slate-800 animate-fade-in">
            <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-white dark:bg-slate-900">
                <h3 class="font-bold text-xs text-slate-800 dark:text-slate-200 uppercase tracking-wide">💬 Ruang Diskusi</h3>
                <button id="closeCommentModal" class="text-sm p-1">✕</button>
            </div>
            <div id="commentsList" class="p-5 overflow-y-auto custom-scrollbar flex-1 space-y-4 bg-slate-50 dark:bg-slate-950"></div>
            <div class="p-3 bg-white dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800">
                <form id="commentForm" class="flex items-center gap-2">
                    <input type="text" id="commentInput" placeholder="Tulis komentar akademis..." class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 focus:outline-none focus:border-brand rounded-xl px-4 py-2.5 text-xs transition-all">
                    <button type="submit" class="bg-brand text-white rounded-xl h-9 w-9 flex items-center justify-center shrink-0">🚀</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Modifikasi kecil di fungsi renderPost agar mendukung kelas Dark Mode Tailwind
        function renderPost(post) {
            globalPostsData[post.id] = post;
            const article = document.createElement('article');
            article.className = 'border border-slate-200/80 dark:border-slate-800/50 bg-white dark:bg-slate-900 overflow-hidden rounded-2xl mb-4 relative animate-fade-in shadow-sm';
            article.id = `post-${post.id}`;
            
            const userName = post.user?.name || 'User';
            const filePath = post.image ? `/storage/${post.image}` : null; 

            let roleBadge = post.user?.role === 'creator' 
                ? `<span class="bg-violet-50 dark:bg-violet-950/40 text-brand text-[9px] font-bold px-2 py-0.5 rounded-md border border-brand/20 align-middle ml-1.5">Creator</span>`
                : `<span class="bg-slate-100 dark:bg-slate-800 text-slate-500 text-[9px] font-bold px-2 py-0.5 rounded-md border border-slate-200 dark:border-slate-700 align-middle ml-1.5">Learner</span>`;

            const userPhoto = post.user?.photo 
                ? `/${post.user.photo}` 
                : `https://ui-avatars.com/api/?name=${encodeURIComponent(userName)}&background=7c3aed&color=ffffff`;
            
            const isVideo = post.image?.match(/\.(mp4|webm|ogg|mov)$/i);
            const isPDF = post.image?.match(/\.(pdf)$/i);
            const isImage = post.image?.match(/\.(jpg|jpeg|png|gif|webp)$/i);

            const likeColorClass = post.is_liked 
                ? 'text-red-600 bg-red-50 dark:bg-red-950/20 border-red-200 dark:border-red-900/50' 
                : 'text-slate-500 dark:text-slate-400 border-slate-200 dark:border-slate-800 hover:bg-slate-50';

            article.innerHTML = `
                <div class="flex items-start justify-between p-4 pb-2">
                    <div class="flex items-center gap-3">
                        <img src="${userPhoto}" class="h-9 w-9 rounded-xl object-cover border border-slate-100 dark:border-slate-800" />
                        <div>
                            <div class="flex items-center gap-1 flex-wrap">
                                <span class="text-xs font-bold tracking-tight">${userName}</span> ${roleBadge}
                            </div>
                            <p class="text-[10px] text-slate-400 font-medium mt-0.5">${formatTimeAgo(post.created_at)}</p>
                        </div>
                    </div>
                </div>
                <div class="px-4 pb-3 text-xs text-slate-600 dark:text-slate-300 leading-relaxed font-medium tracking-wide">${post.content}</div>
                <div class="border-t border-slate-100 dark:border-slate-800/80 px-4 py-2 bg-slate-50/50 dark:bg-slate-900/50 flex gap-2 text-xs font-bold">
                    <button onclick="handleLike(${post.id})" id="like-btn-${post.id}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl border transition-all ${likeColorClass}">👍 <span>${post.likes_count || 0}</span></button>
                    <button onclick="openCommentModal(${post.id})" class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-slate-200 dark:border-slate-800 text-slate-500 hover:text-brand transition-all">💬 <span>${post.comments_count || 0}</span></button>
                </div>`;
            return article;
        }

        // Jalankan sisa core script AJAX bawaanmu di sini tanpa perubahan logic...
        let currentFeedType = 'portfolio';
        const postsWrapper = document.getElementById('postsWrapper');
        const loadingIndicator = document.getElementById('loadingIndicator');
        const noMorePosts = document.getElementById('noMorePosts');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const currentUserId = {{ Auth::id() }};
        let globalPostsData = {};

        function formatTimeAgo(date) {
            return 'Baru saja';
        }

        async function fetchPosts(offset, limit) {
            loadingIndicator.classList.remove('hidden');
            setTimeout(() => {
                loadingIndicator.classList.add('hidden');
                // Mocking rendering untuk preview frontend mockup
                if(postsWrapper.children.length === 0) {
                    postsWrapper.appendChild(renderPost({id: 1, content: 'Berhasil membuat modul integrasi sistem AI Mentor menggunakan arsitektur Laravel Engine.', created_at: new Date(), likes_count: 12, comments_count: 2, user: {name: 'Alex Joshua', role: 'creator'}}));
                }
            }, 600);
        }
        fetchPosts(0, 5);
    </script>
</body>
</html>
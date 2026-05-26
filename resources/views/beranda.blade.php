<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LearnLoop | Platform Kolaborasi Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .glass-effect { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.05); }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
        
        /* Custom Scrollbar untuk Modal Komentar */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="min-h-screen text-slate-900">

    <header class="sticky top-0 z-50 border-b border-slate-200 glass-effect">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6">
            <div class="flex flex-1 items-center gap-8">
                <a href="#" class="flex items-center gap-2">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-600 shadow-lg shadow-violet-200">
                        <span class="text-xl font-bold text-white">L</span>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight text-slate-900">LearnLoop</span>
                </a>
            </div>

            <div class="flex items-center gap-3">
                <input type="file" id="fileInput" class="hidden" accept="image/*,video/*,.pdf">
                <button id="uploadBtn" class="items-center gap-2 rounded-2xl bg-violet-600 px-5 py-2.5 text-sm font-bold text-white shadow-md transition-all hover:bg-violet-700 md:flex">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14m7-7H5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Upload
                </button>
                
                <a href="/profile" class="transition-transform hover:scale-110 active:scale-95">
                    <img src="{{ Auth::user()->photo ? asset(Auth::user()->photo) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name ?? 'User').'&background=8b5cf6&color=ffffff&rounded=true' }}" class="h-9 w-9 rounded-xl object-cover shadow-sm border border-violet-100" title="Lihat Profil" />
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
                <section id="feedContainer" class="lg:col-span-6 space-y-8">
                    
                    @if(session('success'))
                        <div class="animate-fade-in flex items-center gap-3 rounded-[24px] border border-emerald-100 bg-emerald-50 p-4 text-sm font-bold text-emerald-700 shadow-sm">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-200/50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="relative overflow-hidden rounded-[32px] bg-white border border-slate-200 p-8 shadow-sm">
                        <h1 class="text-2xl font-extrabold text-slate-900">Halo, Mahasiswa Kreatif! 👋</h1>
                        <p class="text-sm text-slate-500 mt-1">Bagikan materi atau hasil karyamu hari ini.</p>
                    </div>

                    <div class="my-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 animate-fade-in">
                        <div class="flex items-center gap-2 bg-white p-1.5 rounded-2xl border border-slate-200 shadow-sm w-fit">
                            <button id="tab-portfolio" onclick="switchFeedType('portfolio')" class="px-5 py-2 rounded-xl text-sm font-bold bg-slate-900 text-white transition-all shadow-sm">
                                Portofolio
                            </button>
                            <button id="tab-learning" onclick="switchFeedType('learning')" class="px-5 py-2 rounded-xl text-sm font-bold text-slate-500 hover:text-slate-900 hover:bg-slate-50 transition-all">
                                Pembelajaran
                            </button>
                        </div>

                        @if(auth()->user()->role === 'creator')
                            <button onclick="document.getElementById('learningUploadModal').classList.remove('hidden')" class="flex items-center gap-2 bg-violet-600 hover:bg-violet-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm transition-all shadow-md shadow-violet-200 active:scale-95">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                                Upload Materi Pembelajaran
                            </button>
                        @endif
                    </div>

                    <div id="postsWrapper" class="space-y-6"></div>

                <div id="loadingIndicator" class="hidden text-center py-6">
                    <div class="inline-block animate-spin">
                        <svg class="h-6 w-6 text-violet-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>

                <div id="noMorePosts" class="hidden text-center py-8">
                    <p class="text-slate-500 text-sm italic font-medium">✨ Sudah di penghujung materi ✨</p>
                </div>
            </section>

            <aside class="hidden lg:col-span-3 lg:block"></aside>
        </div>
    </main>

    <div id="uploadModal" class="fixed inset-0 z-[60] hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div class="w-full max-w-lg rounded-[32px] bg-white p-8 shadow-2xl">
            <h3 class="text-xl font-bold mb-6">Posting Konten Baru</h3>
            <div id="previewArea" class="mb-4 rounded-2xl bg-slate-50 border-2 border-dashed border-slate-200 min-h-[150px] flex items-center justify-center overflow-hidden"></div>
            <textarea id="captionText" rows="3" class="w-full rounded-2xl border border-slate-200 p-4 text-sm outline-none focus:border-violet-500 transition-all" placeholder="Tulis deskripsi postingan..."></textarea>
            <button id="submitUpload" class="mt-6 w-full rounded-2xl bg-violet-600 py-4 text-sm font-bold text-white hover:bg-violet-700 transition-all">Posting Sekarang</button>
            <button id="closeModal" class="w-full mt-2 text-sm text-slate-400 font-medium py-2 hover:text-slate-600">Batal</button>
        </div>
    </div>

    <div id="commentModal" class="fixed inset-0 z-[70] hidden flex items-end justify-center sm:items-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all">
        <div class="w-full max-w-lg rounded-t-[32px] sm:rounded-[32px] bg-white flex flex-col shadow-2xl overflow-hidden max-h-[80vh]">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-white shrink-0">
                <h3 class="font-bold text-lg text-slate-900">Komentar</h3>
                <button id="closeCommentModal" class="text-slate-400 hover:text-slate-600 p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            
            <div id="commentsList" class="p-6 overflow-y-auto custom-scrollbar flex-1 space-y-5 bg-slate-50">
                </div>

            <div id="replyInfo" class="hidden px-5 py-2 bg-violet-50 border-x border-t border-slate-100 flex justify-between items-center shrink-0">
                <p class="text-[10px] font-bold text-violet-600">Membalas: <span id="replyTargetName"></span></p>
                <button type="button" onclick="cancelReply()" class="text-[10px] text-red-400 hover:text-red-600">Batal</button>
            </div>

            <div class="p-4 bg-white border-t border-slate-100 shrink-0">
                <form id="commentForm" class="flex items-center gap-3">
                    <input type="text" id="commentInput" placeholder="Tulis komentar..." class="w-full bg-slate-100 border-transparent focus:bg-white focus:border-violet-500 focus:ring-2 focus:ring-violet-200 rounded-full pl-5 pr-4 py-3 text-sm transition-all outline-none" required autocomplete="off">
                    <button type="submit" class="bg-violet-600 hover:bg-violet-700 text-white rounded-2xl h-12 w-12 flex items-center justify-center transition-all hover:scale-105 active:scale-95 shadow-lg shadow-violet-200 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div id="learningUploadModal" class="fixed inset-0 z-[60] hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div class="w-full max-w-lg rounded-[32px] bg-white p-8 shadow-2xl">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-extrabold text-slate-900">Upload Materi Baru</h3>
                <button onclick="document.getElementById('learningUploadModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 bg-slate-50 hover:bg-slate-100 p-2 rounded-full transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            @php $categories = \App\Models\Category::all(); @endphp

            <form id="learningUploadForm" onsubmit="submitLearningPost(event)">
                <div class="mb-4">
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Kategori Materi</label>
                    <select id="learningCategory" class="w-full rounded-2xl border border-slate-200 p-3.5 text-sm font-medium outline-none focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 transition-all bg-slate-50 cursor-pointer" required>
                        <option value="" disabled selected>Pilih Kategori Pembelajaran...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Judul / Deskripsi Materi</label>
                    <textarea id="learningCaption" rows="3" class="w-full rounded-2xl border border-slate-200 p-4 text-sm outline-none focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 transition-all bg-slate-50" placeholder="Jelaskan isi materi ini..." required></textarea>
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">File Materi (PDF/Video/Gambar)</label>
                    <input type="file" id="learningFile" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100 transition-colors cursor-pointer" accept="image/*,video/*,.pdf" required>
                </div>

                <div class="mb-6 p-4 border border-violet-100 bg-violet-50 rounded-2xl">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" id="checkBuatKelas" name="create_class" value="true" class="w-5 h-5 text-violet-600 rounded focus:ring-violet-500" onchange="document.getElementById('areaNamaKelas').classList.toggle('hidden')">
                        <span class="text-sm font-bold text-violet-900">Sekaligus buat Ruang Kelas Pembelajaran?</span>
                    </label>
                    <div id="areaNamaKelas" class="hidden mt-3 pt-3 border-t border-violet-100">
                        <label class="text-xs font-bold text-violet-700 mb-1 block">Nama Kelas</label>
                        <input type="text" id="inputClassName" name="class_name" placeholder="Misal: Masterclass Laravel Basic..." class="w-full bg-white border border-violet-200 focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 rounded-xl px-4 py-2.5 text-sm outline-none transition-all">
                    </div>
                </div>

                <button type="submit" id="btnSubmitLearning" class="w-full rounded-2xl bg-violet-600 py-4 text-sm font-bold text-white hover:bg-violet-700 transition-all shadow-lg shadow-violet-200 active:scale-95">Upload Materi Sekarang</button>
            </form>
        </div>
    </div>
    <script>
        // Variabel global buat nentuin lagi di tab mana
        let currentFeedType = 'portfolio';

        function switchFeedType(type) {
            currentFeedType = type;
            
            const btnPorto = document.getElementById('tab-portfolio');
            const btnLearn = document.getElementById('tab-learning');

            // Reset styling
            btnPorto.className = "px-5 py-2 rounded-xl text-sm font-bold text-slate-500 hover:text-slate-900 hover:bg-slate-50 transition-all";
            btnLearn.className = "px-5 py-2 rounded-xl text-sm font-bold text-slate-500 hover:text-slate-900 hover:bg-slate-50 transition-all";

            if(type === 'portfolio') {
                btnPorto.className = "px-5 py-2 rounded-xl text-sm font-bold bg-slate-900 text-white transition-all shadow-sm";
            } else {
                btnLearn.className = "px-5 py-2 rounded-xl text-sm font-bold bg-slate-900 text-white transition-all shadow-sm";
            }

            // JURUS RESET FEED
            postsWrapper.innerHTML = ''; // Kosongin postingan yang lagi nampil
            currentOffset = 0; // Balikin hitungan ke nol
            allPostsLoaded = false; 
            noMorePosts.classList.add('hidden'); // Sembunyiin teks "Sudah di penghujung"
            
            // Tarik data ulang dengan tipe yang baru!
            fetchPosts(0, 5);
        }

        const uploadBtn = document.getElementById('uploadBtn');
        const fileInput = document.getElementById('fileInput');
        const uploadModal = document.getElementById('uploadModal');
        const closeModal = document.getElementById('closeModal');
        const submitUpload = document.getElementById('submitUpload');
        const previewArea = document.getElementById('previewArea');
        const postsWrapper = document.getElementById('postsWrapper');
        const captionText = document.getElementById('captionText');
        const loadingIndicator = document.getElementById('loadingIndicator');
        const noMorePosts = document.getElementById('noMorePosts');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const currentUserId = {{ Auth::id() }};

        // Variabel Komentar Modal
        const commentModal = document.getElementById('commentModal');
        const closeCommentModal = document.getElementById('closeCommentModal');
        const commentsList = document.getElementById('commentsList');
        const commentForm = document.getElementById('commentForm');
        const commentInput = document.getElementById('commentInput');
        let currentActivePostId = null; 
        let globalPostsData = {}; // Buat nyimpen data post sementara di memory
        let currentParentId = null; // Tambahin ini buat nyimpen ID target balesan

        let selectedFileUrl = "";
        let currentOffset = 0;
        let isLoading = false;
        let allPostsLoaded = false;

        function formatTimeAgo(date) {
            const now = new Date();
            const postDate = new Date(date);
            const seconds = Math.floor((now - postDate) / 1000);
            if (seconds < 60) return 'Baru saja';
            if (seconds < 3600) return Math.floor(seconds / 60) + ' menit lalu';
            if (seconds < 86400) return Math.floor(seconds / 3600) + ' jam lalu';
            return Math.floor(seconds / 86400) + ' hari lalu';
        }

        // --- FUNGSI RENDER UTAMA ---
        function renderPost(post) {
            globalPostsData[post.id] = post;
            const article = document.createElement('article');
            article.className = 'card-hover overflow-hidden rounded-[32px] border border-slate-200 bg-white mb-6';
            article.id = `post-${post.id}`;
            
            const userName = post.user?.name || 'User';
            const filePath = post.image ? `/storage/${post.image}` : null; 

            // Bikin Pill Badge buat Postingan
            let roleBadge = '';
            if (post.user?.role === 'creator') {
                roleBadge = `<span class="bg-violet-600 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full ml-2 align-middle shadow-sm">Creator</span>`;
            } else {
                roleBadge = `<span class="bg-slate-200 text-slate-600 text-[10px] font-bold px-2.5 py-0.5 rounded-full ml-2 align-middle shadow-sm">Learner</span>`;
            }

            const userPhoto = post.user?.photo 
                ? `/${post.user.photo}` 
                : `https://ui-avatars.com/api/?name=${encodeURIComponent(userName)}&background=7c3aed&color=ffffff&rounded=true`;
            
            const isVideo = post.image?.match(/\.(mp4|webm|ogg|mov)$/i);
            const isPDF = post.image?.match(/\.(pdf)$/i);
            const isImage = post.image?.match(/\.(jpg|jpeg|png|gif|webp)$/i);

            const likeColorClass = post.is_liked ? 'text-red-500' : 'text-slate-600 hover:text-red-500';

            // Logika Banner Gabung Kelas
            let roomBannerHtml = '';
            if (post.room_id && post.room) {
                // Cek apakah user udah gabung kelas ini
                let isJoined = false;
                if (post.user_id === currentUserId) {
                    isJoined = true; // Kalo dia yang upload, pasti dia yang punya kelas
                } else if (post.room.users) {
                    // Cek apakah id user ada di daftar member kelas
                    isJoined = post.room.users.some(u => u.id === currentUserId);
                }

                // Bikin Tombol Sesuai Status
                let buttonHtml = '';
                if (isJoined) {
                    buttonHtml = `
                        <a href="/chat/${post.room_id}" class="w-full sm:w-auto bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-2.5 rounded-xl text-xs font-extrabold transition-all text-center block">
                            Buka Kelas
                        </a>
                    `;
                } else {
                    buttonHtml = `
                        <form action="/chat/join/${post.room_id}" method="POST" class="w-full sm:w-auto shrink-0">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-xl text-xs font-extrabold shadow-lg shadow-emerald-200 transition-all active:scale-95">
                                Gabung Kelas
                            </button>
                        </form>
                    `;
                }

                roomBannerHtml = `
                    <div class="mx-5 mb-5 p-4 bg-emerald-50 rounded-2xl border border-emerald-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 shrink-0 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 14v6.5" /></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-extrabold text-emerald-600 uppercase tracking-wider mb-0.5">Ruang Kelas Tersedia</p>
                                <p class="text-sm font-bold text-slate-900 line-clamp-1">${post.room.name}</p>
                            </div>
                        </div>
                        ${buttonHtml}
                    </div>
                `;
            }

            article.innerHTML = `
                <div class="flex items-center gap-3 p-5">
                    <a href="/profile/${post.user?.id}" class="shrink-0 transition-transform hover:scale-105">
                        <img src="${userPhoto}" class="h-11 w-11 rounded-full ring-2 ring-violet-50" />
                    </a>
                    <div>
                        <div class="flex items-center gap-2">
                            <a href="/profile/${post.user?.id}" class="text-sm font-bold text-slate-900 hover:text-violet-600 hover:underline transition-colors">${userName}</a> ${roleBadge}
                            ${post.type === 'learning' && post.category ? `<span class="bg-violet-100 text-violet-700 text-[9px] font-extrabold px-2 py-0.5 rounded-full uppercase tracking-wider ml-1">${post.category.name}</span>` : ''}
                        </div>
                        <a href="/profile/${post.user?.id}" class="text-sm font-bold text-slate-900 hover:text-violet-600 hover:underline transition-colors">${userName}</a> ${roleBadge}
                    </div>
                </div>

                <div class="px-5 pb-4 text-sm text-slate-700 leading-relaxed">${post.content}</div>

                ${roomBannerHtml}

                <div class="mx-5 mb-5 overflow-hidden rounded-2xl bg-slate-100 flex items-center justify-center">
                    ${isImage && filePath ? `<img src="${filePath}" class="w-full h-auto object-cover max-h-[500px]">` : ''}
                    ${isVideo && filePath ? `<video src="${filePath}" controls class="w-full h-auto max-h-[500px] bg-black"></video>` : ''}
                    ${isPDF && filePath ? `
                        <div class="w-full flex items-center justify-between p-6 bg-violet-50 border border-violet-100 rounded-2xl">
                            <div class="flex items-center gap-4">
                                <div class="h-12 w-12 flex items-center justify-center bg-white rounded-xl shadow-sm text-red-500 font-bold text-[10px]">PDF</div>
                                <p class="text-sm font-bold text-slate-900 truncate max-w-[150px]">Dokumen Materi</p>
                            </div>
                            <a href="${filePath}" target="_blank" class="rounded-xl bg-violet-600 px-4 py-2 text-xs font-bold text-white hover:bg-violet-700 shadow-lg shadow-violet-100">Buka File</a>
                        </div>
                    ` : ''}
                </div>

                <div class="border-t border-slate-50 px-6 py-4 flex gap-6 text-sm font-bold">
                    <button onclick="handleLike(${post.id})" id="like-btn-${post.id}" class="flex items-center gap-1.5 transition-colors ${likeColorClass}">
                        ❤️ <span id="like-count-${post.id}">${post.likes_count || 0}</span>
                    </button>
                    <button onclick="openCommentModal(${post.id})" class="flex items-center gap-1.5 text-slate-600 hover:text-violet-600 transition-colors">
                        💬 <span id="comment-count-${post.id}">${post.comments_count || 0}</span>
                    </button>
                </div>
            `;
            return article;
        }

        // --- FUNGSI LIKE ---
        async function handleLike(postId) {
            const btnElement = document.getElementById(`like-btn-${postId}`);
            const countElement = document.getElementById(`like-count-${postId}`);
            
            try {
                const response = await fetch(`/posts/${postId}/like`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                });
                const result = await response.json();
                
                let currentCount = parseInt(countElement.innerText);

                if (result.status === 'liked') {
                    btnElement.classList.remove('text-slate-600', 'hover:text-red-500');
                    btnElement.classList.add('text-red-500');
                    countElement.innerText = currentCount + 1;
                    globalPostsData[postId].is_liked = true;
                } else {
                    btnElement.classList.remove('text-red-500');
                    btnElement.classList.add('text-slate-600', 'hover:text-red-500');
                    countElement.innerText = currentCount - 1;
                    globalPostsData[postId].is_liked = false;
                }
            } catch (error) {
                console.error("Gagal melakukan like:", error);
            }
        }

        // --- FUNGSI KOMENTAR FLOATING MODAL ---
        function openCommentModal(postId) {
            currentActivePostId = postId;
            const post = globalPostsData[postId];
            
            commentsList.innerHTML = ''; // Bersihin isi modal lama
            
            if (!post.comments || post.comments.length === 0) {
                commentsList.innerHTML = `<p class="text-center text-sm text-slate-400 mt-10">Belum ada komentar. Jadilah yang pertama!</p>`;
            } else {
                // LOGIKA BARU: Pisahin mana Komentar Utama, mana Balasan
                const parentComments = post.comments.filter(c => !c.parent_id || c.parent_id == 0 || c.parent_id == "null");
                const childComments = post.comments.filter(c => c.parent_id && c.parent_id != 0);

                // Render Bapaknya dulu, baru Anak-anaknya yang ngikutin bapaknya
                parentComments.forEach(parent => {
                    appendCommentToUI(parent, false); // Ini Bapak
                    
                    // Pake == (dua sama dengan) biar string "1" dan angka 1 dianggap sama
                    childComments.filter(child => child.parent_id == parent.id).forEach(child => {
                        appendCommentToUI(child, true);
                    });
                });
            }
            commentModal.classList.remove('hidden');
        }

        closeCommentModal.addEventListener('click', () => {
            commentModal.classList.add('hidden');
            currentActivePostId = null;
        });

        function appendCommentToUI(comment, isReply = false) {
            console.log("CEK DATA KOMENTAR:", comment);
            const userName = comment.user?.name || 'User';

            // Bikin Pill Badge buat Komentar
            let roleBadgeComment = '';
            if (comment.user?.role === 'creator') {
                roleBadgeComment = `<span class="bg-violet-600 text-white text-[8px] font-bold px-2 py-0.5 rounded-full ml-1.5 align-middle shadow-sm">Creator</span>`;
            } else {
                roleBadgeComment = `<span class="bg-slate-200 text-slate-600 text-[8px] font-bold px-2 py-0.5 rounded-full ml-1.5 align-middle shadow-sm">Learner</span>`;
            }

            const commenterPhoto = comment.user?.photo 
                ? `${window.location.origin}/${comment.user.photo}` 
                : `https://ui-avatars.com/api/?name=${encodeURIComponent(userName)}&background=e2e8f0&color=475569`;

            const noDataHtml = commentsList.querySelector('p.text-slate-400');
            if (noDataHtml) noDataHtml.remove();

            const commentDiv = document.createElement('div');
            commentDiv.className = `flex gap-3 ${isReply ? 'ml-10 mt-2' : 'mt-5'}`;
            
            commentDiv.innerHTML = `
                <img src="${commenterPhoto}" class="h-8 w-8 rounded-full shrink-0">
                <div class="bg-white border border-slate-200 rounded-2xl rounded-tl-sm px-4 py-3 shadow-sm flex-1">
                    <div class="flex justify-between items-center mb-0.5">
                        <p class="text-[11px] font-bold text-slate-500">${userName} ${roleBadgeComment}</p>
                        ${!isReply ? `<button onclick="setReply(${comment.id}, '${userName}')" class="text-[10px] text-violet-500 hover:underline">Balas</button>` : ''}
                    </div>
                    <p class="text-sm text-slate-800">${comment.body}</p>
                </div>
            `;
            commentsList.appendChild(commentDiv);
            commentsList.scrollTop = commentsList.scrollHeight; 
        }

        // Tambahin dua fungsi ini tepat di bawahnya
        function setReply(commentId, name) {
            currentParentId = commentId;
            document.getElementById('replyTargetName').innerText = name;
            document.getElementById('replyInfo').classList.remove('hidden');
            document.getElementById('commentInput').focus();
        }

        function cancelReply() {
            currentParentId = null;
            document.getElementById('replyInfo').classList.add('hidden');
        }

        // Submit Form Komentar
        commentForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const text = commentInput.value.trim();
            if (!text || !currentActivePostId) return;

            const submitBtn = commentForm.querySelector('button');
            submitBtn.disabled = true;

            try {
                const response = await fetch(`/posts/${currentActivePostId}/comment`, {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken, 
                        'Accept': 'application/json' 
                    },
                    body: JSON.stringify({ 
                        body: text,
                        parent_id: currentParentId // Kirim target balesannya ke backend
                    })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // Update Memory Data
                    globalPostsData[currentActivePostId].comments.push(result.data);
                    
                    // JURUS RENDER ULANG MODAL (Biar urutannya otomatis bener)
                    openCommentModal(currentActivePostId); 
                    
                    commentInput.value = '';
                    cancelReply(); 
                    
                    const countSpan = document.getElementById(`comment-count-${currentActivePostId}`);
                    countSpan.innerText = parseInt(countSpan.innerText) + 1;
                }
            } catch (error) {
                alert("Gagal mengirim komentar!");
            } finally {
                submitBtn.disabled = false;
            }
        });

        // --- FETCH POSTS ---
        async function fetchPosts(offset, limit) {
            // Tambahin || allPostsLoaded di sini biar kalau udah mentok dia beneran stop
            if (isLoading || allPostsLoaded) return; 
            isLoading = true;
            loadingIndicator.classList.remove('hidden');

            try {
                const response = await fetch(`/posts/fetch?offset=${offset}&limit=${limit}&type=${currentFeedType}`);
                const result = await response.json();

                if (result.success) {
                    if (result.data.length > 0) {
                        result.data.forEach(post => {
                            postsWrapper.appendChild(renderPost(post));
                        });
                        currentOffset += result.data.length;
                        
                        // Kalau jumlah yang ditarik kurang dari limit, berarti udah ujungnya
                        if (result.data.length < limit) {
                            allPostsLoaded = true;
                            noMorePosts.classList.remove('hidden');
                        }
                    } else {
                        // JIKA BALIKANNYA KOSONG (0), entah di awal atau pas scroll bawah
                        allPostsLoaded = true;
                        noMorePosts.classList.remove('hidden');
                    }
                }
            } catch (error) {
                console.error('Fetch Error:', error);
            } finally {
                isLoading = false;
                loadingIndicator.classList.add('hidden'); // Matiin spinnernya
            }
        }

        // Infinite Scroll
        window.addEventListener('scroll', () => {
            if (allPostsLoaded || isLoading) return;
            if (window.innerHeight + window.scrollY >= document.documentElement.scrollHeight - 500) {
                fetchPosts(currentOffset, 3);
            }
        });

        // Initial Load
        fetchPosts(0, 5);

        // Upload Preview logic ... (Tetap Sama)
        uploadBtn.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                selectedFileUrl = URL.createObjectURL(file);
                previewArea.innerHTML = ""; 

                if (file.type.startsWith('image/')) {
                    previewArea.innerHTML = `<img src="${selectedFileUrl}" class="max-h-[300px] w-full object-contain">`;
                } else if (file.type.startsWith('video/')) {
                    previewArea.innerHTML = `<video src="${selectedFileUrl}" class="max-h-[300px] w-full" controls autoplay muted></video>`;
                } else if (file.type === 'application/pdf') {
                    previewArea.innerHTML = `
                        <div class="flex flex-col items-center gap-3 p-6 text-center">
                            <div class="w-16 h-16 bg-red-50 rounded-2xl flex items-center justify-center text-red-500 font-bold">PDF</div>
                            <div>
                                <p class="text-sm font-bold text-slate-700">${file.name}</p>
                                <p class="text-[10px] text-slate-400">Siap untuk diunggah</p>
                            </div>
                        </div>`;
                }
                uploadModal.classList.remove('hidden');
            }
        });

        submitUpload.addEventListener('click', async () => {
            const caption = captionText.value.trim();
            const file = fileInput.files[0];

            if (!caption || !file) return alert("Caption dan file harus diisi!");

            submitUpload.innerText = "Sedang Mengirim...";
            submitUpload.disabled = true;

            const formData = new FormData();
            formData.append('content', caption);
            formData.append('image', file);

            try {
                const response = await fetch('/posts', {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                });

                const result = await response.json();
                if (result.success) {
                    const newPost = renderPost(result.data);
                    newPost.classList.add('animate-fade-in');
                    postsWrapper.insertBefore(newPost, postsWrapper.children[0]);
                    
                    // Reset
                    uploadModal.classList.add('hidden');
                    captionText.value = "";
                    fileInput.value = "";
                    previewArea.innerHTML = "";
                    newPost.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            } catch (error) {
                alert("Upload gagal!");
            } finally {
                submitUpload.innerText = "Posting Sekarang";
                submitUpload.disabled = false;
            }
        });

        closeModal.addEventListener('click', () => uploadModal.classList.add('hidden'));

        // Fungsi Eksekusi Upload Materi
        async function submitLearningPost(e) {
            e.preventDefault();
            const caption = document.getElementById('learningCaption').value;
            const categoryId = document.getElementById('learningCategory').value;
            const file = document.getElementById('learningFile').files[0];
            const btn = document.getElementById('btnSubmitLearning');

            // Tangkep isian Checkbox Bikin Kelas
            const isCreateClass = document.getElementById('checkBuatKelas').checked;
            const className = document.getElementById('inputClassName').value;

            if (!caption || !file || !categoryId) return alert("Semua kolom wajib diisi, beb!");
            if (isCreateClass && !className) return alert("Nama kelas harus diisi kalau mau bikin kelas!");

            btn.innerText = "Mengunggah Materi...";
            btn.disabled = true;

            const formData = new FormData();
            formData.append('content', caption);
            formData.append('image', file);
            formData.append('type', 'learning'); // Otomatis nembak tipe learning
            formData.append('category_id', categoryId); // Kirim ID kategori

            // Masukin data kelas kalau dicentang
            if (isCreateClass) {
                formData.append('create_class', 'true');
                formData.append('class_name', className);
            }

            try {
                const response = await fetch('/posts', {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                });
                const result = await response.json();

                if (result.success) {
                    alert('Materi sukses mendarat!');
                    document.getElementById('learningUploadModal').classList.add('hidden');
                    document.getElementById('learningUploadForm').reset();
                    
                    // REFRESH TAB PEMBELAJARAN BIAR POSTINGAN BARU LANGSUNG MUNCUL
                    switchFeedType('learning');
                }
            } catch (error) {
                alert("Waduh, upload gagal!");
            } finally {
                btn.innerText = "Upload Materi Sekarang";
                btn.disabled = false;
            }
        }
    </script>
</body>
</html>

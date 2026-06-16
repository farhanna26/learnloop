<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: localStorage.getItem('theme') === 'dark', editProfileOpen: false, selectedPost: null }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LearnLoop | Platform Kolaborasi Mahasiswa</title>
    
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
        /* --- TENGAH: HIGH-CONTRAST POP-UP STYLE (3D SOLID BLOK) --- */
        .card-feed {
            background: #ffffff;
            border-radius: 2.25rem;
            border: 2px solid #e2e8f0;
            box-shadow: 0px 14px 0px #cbd5e1;
            transition: all 0.2s ease-in-out;
        }
        .card-feed:hover {
            transform: translateY(4px);
            box-shadow: 0px 8px 0px #cbd5e1;
        }

        .btn-pop-purple {
            background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
            border: 2px solid #4c1d95;
            box-shadow: 0px 6px 0px #4c1d95;
            transition: all 0.15s ease;
        }
        .btn-pop-purple:active { transform: translateY(6px); box-shadow: 0px 0px 0px #4c1d95; }

        .btn-pop-white {
            background: #ffffff;
            border: 2px solid #cbd5e1;
            box-shadow: 0px 5px 0px #cbd5e1;
            transition: all 0.15s ease;
        }
        .btn-pop-white:active { transform: translateY(5px); box-shadow: 0px 0px 0px #cbd5e1; }

        .custom-input {
            background: #ffffff;
            border: 2px solid #cbd5e1;
            border-radius: 1.5rem;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.06);
        }

        /* --- SINKRONISASI PER KONTEN SIDEBAR KANAN (3D UNGU & BORDER SAMAR) --- */
        /* Hanya menargetkan elemen div pembungkus modul konten (bukan membungkus seluruh aside/logout) */
        .lg\:col-span-3 aside > div:not(.pt-2) {
            border: 1px solid rgba(124, 58, 237, 0.2) !important; /* Border samar ungu halus awal */
            box-shadow: 0px 0px 0px transparent !important;
            transform: translateY(0);
            transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
        }
        
        /* Efek melayang 3D Ungu solid saat PER KOTAK KONTEN (Teman/Kreator) disorot kursor */
        .lg\:col-span-3 aside > div:not(.pt-2):hover {
            transform: translateY(-6px) !important;
            border-color: #c084fc !important; /* Border ungu cerah saat hover */
            box-shadow: 0px 10px 0px #7c3aed !important; /* Bayangan 3D Blok Ungu solid */
        }

        /* Flat item list di dalam kontainer modul sidebar */
        .item-user-clean {
            background: rgba(248, 250, 252, 0.6);
            transition: background 0.2s ease;
        }
        .lg\:col-span-3 aside > div:hover .item-user-clean {
            background: #ffffff;
        }

        /* Tombol Keluar Akun Mini 3D Merah Bawaan */
        .btn-logout-mini {
            background: #ffffff;
            border: 2px solid #fecaca;
            box-shadow: 0px 4px 0px #fca5a5;
            transition: all 0.15s ease-in-out;
        }
        .btn-logout-mini:hover {
            transform: translateY(2px);
            box-shadow: 0px 2px 0px #fca5a5;
            background: #fff5f5;
        }
        .btn-logout-mini:active { transform: translateY(4px); box-shadow: 0px 0px 0px #fca5a5; }

        /* Dark Mode Styling */
        .dark .card-feed { background: #161245; border: 2px solid #2e2773; box-shadow: 0px 14px 0px #0d0a2d; }
        .dark .card-feed:hover { box-shadow: 0px 8px 0px #0d0a2d; }
        .dark .btn-pop-white { background: #161245; border: 2px solid #2e2773; box-shadow: 0px 5px 0px #0d0a2d; color: white; }
        .dark .custom-input { background: #0d0926; border: 2px solid #2e2773; color: #ffffff; }

        /* Dark Mode Per Konten Modul Sidebar */
        .dark .lg\:col-span-3 aside > div:not(.pt-2) { 
            border: 1px solid rgba(139, 92, 246, 0.15) !important; 
        }
        .dark .lg\:col-span-3 aside > div:not(.pt-2):hover { 
            border-color: #4c1d95 !important; 
            box-shadow: 0px 10px 0px #4c1d95 !important; 
        }
        .dark .item-user-clean { background: rgba(13, 9, 38, 0.4); }
        .dark .btn-logout-mini { background: #1a102f; border: 2px solid #e11d48; box-shadow: 0px 4px 0px #9f1239; color: #f43f5e; }

        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 999px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #2e2773; }
        @keyframes cardPop { from { opacity: 0; transform: scale(0.95) translateY(15px); } to { opacity: 1; transform: scale(1) translateY(0); } }
        .animate-card { animation: cardPop 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }
    </style>
</head>
<body class="h-screen w-screen bg-[#f0f2fe] dark:bg-[#060412] text-[#1e1b4b] dark:text-[#f3f1fa] antialiased font-sans p-3 md:p-6 flex items-center justify-center overflow-hidden transition-colors duration-300">

    <div class="w-full max-w-[1440px] h-full bg-[#f8fafc] dark:bg-[#0b0822] rounded-[3.5rem] p-4 md:p-6 border-4 border-slate-200 dark:border-slate-800 shadow-xl grid grid-cols-1 lg:grid-cols-12 gap-6 overflow-hidden">
        
        <div class="lg:col-span-2 h-full overflow-hidden">
            @include('components.sidebar')
        </div>

        <main id="mainScroll" class="lg:col-span-7 h-full flex flex-col space-y-6 overflow-y-auto custom-scrollbar pr-2 pb-4">
            
            <div class="flex items-center justify-between gap-4 pt-1 shrink-0">
                <div class="relative w-full max-w-md">
                    <span class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-purple-600 text-xs z-10">🔍</span>
                    <input type="text" placeholder="Cari portfolio, riset, atau teman..." class="w-full custom-input pl-11 pr-4 py-3.5 text-xs font-black placeholder-slate-400 focus:outline-none">
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <input type="file" id="fileInput" class="hidden" accept="image/*,video/*,.pdf">
                    <button id="uploadBtn" class="btn-pop-purple text-white px-6 py-3.5 text-xs font-black rounded-2xl uppercase tracking-wider inline-block text-center cursor-pointer">
                    ➕ Upload Karya
                    </button>
                    
                    @if(auth()->user()->role === 'creator')
                        <button onclick="document.getElementById('learningUploadModal').classList.remove('hidden')" class="btn-pop-white text-purple-700 px-6 py-3.5 text-xs font-black rounded-2xl uppercase tracking-wider inline-block text-center cursor-pointer">
                        📘 Upload Materi
                        </button>
                    @endif

                    <button @click="darkMode = !darkMode; localStorage.setItem('theme', darkMode ? 'dark' : 'light')" class="btn-pop-white p-3.5 rounded-2xl text-xs">
                        <span x-show="!darkMode">🌙</span><span x-show="darkMode">☀️</span>
                    </button>
                </div>
            </div>

            <div class="p-7 relative overflow-hidden flex flex-col md:flex-row items-center justify-between bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 text-white rounded-[2.5rem] border-2 border-purple-700 shadow-xl shrink-0">
                <div class="space-y-2 max-w-full md:max-w-[70%] text-center md:text-left z-10">
                    <h1 class="text-xl md:text-2xl font-black mt-1">Selamat datang di Beranda Academic! 👋</h1>
                    <p class="text-xs text-purple-100 font-semibold leading-relaxed">Temukan riset, portofolio, dan ruang kelas kolaboratif mahasiswa hari ini.</p>
                </div>
                <div class="hidden md:flex items-center justify-center pr-4 z-10">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-3xl transform rotate-12 border-2 border-white/30 shadow-lg">📚</div>
                </div>
            </div>

            <div class="space-y-4 shrink-0">
                <div class="flex gap-2 bg-slate-200/60 dark:bg-[#0d0926] p-1.5 rounded-2xl w-max border border-slate-300/40">
                    <button id="tab-portfolio" onclick="switchFeedType('portfolio')" class="px-5 py-2.5 text-xs font-black bg-purple-600 text-white rounded-xl shadow-md uppercase tracking-wider transition-all">💼 Portofolio</button>
                    <button id="tab-learning" onclick="switchFeedType('learning')" class="px-5 py-2.5 text-xs font-black text-slate-600 dark:text-purple-300/70 hover:text-purple-600 uppercase tracking-wider transition-all">📘 Pembelajaran</button>
                </div>
            </div>

            <div id="postsWrapper" class="space-y-6"></div>

            <div id="loadingIndicator" class="hidden text-center py-6">
                <div class="inline-block animate-spin">
                    <svg class="h-6 w-6 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>

            <div id="noMorePosts" class="hidden text-center py-8">
                <p class="text-slate-500 dark:text-slate-400 text-sm italic font-black uppercase tracking-widest">✨ Sudah di penghujung materi ✨</p>
            </div>
        </main>

        <div class="lg:col-span-3 h-full overflow-hidden">
            @include('components.right-sidebar')
        </div>

    </div>

    <div x-show="selectedPost" x-transition class="fixed inset-0 z-[150] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" style="display: none;">
        <div class="w-full max-w-lg card-feed p-6 dark:bg-[#1d1545]" @click.away="selectedPost = null">
            <div class="flex justify-between items-center mb-4 pb-2 border-b border-purple-100/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-purple-500 to-indigo-500 flex items-center justify-center text-white font-black text-sm" x-text="selectedPost ? selectedPost.user.name[0] : ''"></div>
                    <div>
                        <h4 class="font-black text-xs text-purple-950 dark:text-white" x-text="selectedPost ? selectedPost.user.name : ''"></h4>
                        <p class="text-[9px] text-slate-400 font-bold">Detail Post</p>
                    </div>
                </div>
                <button @click="selectedPost = null" class="text-slate-400 bg-slate-100 dark:bg-purple-950/40 p-2 rounded-xl text-xs">✕</button>
            </div>
            <p class="text-xs md:text-sm font-semibold text-slate-700 dark:text-slate-200 leading-relaxed bg-purple-50/40 dark:bg-[#0d0926] p-4 rounded-2xl" x-text="selectedPost ? selectedPost.content : ''"></p>
        </div>
    </div>

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

    <div id="editPostModal" class="fixed inset-0 z-[80] hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all">
        <div class="w-full max-w-lg rounded-[32px] bg-white p-8 shadow-2xl transform transition-all scale-95 opacity-0 duration-200" id="editModalContent">
            <h3 class="text-xl font-bold mb-6 text-slate-900">Edit Caption Postingan</h3>
            
            <input type="hidden" id="editPostId">
            
            <textarea id="editCaptionText" rows="4" class="w-full rounded-2xl border border-slate-200 p-4 text-sm outline-none focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 transition-all bg-slate-50 custom-scrollbar" placeholder="Tulis ulang caption lu di sini..."></textarea>
            
            <div class="mt-6 flex gap-3">
                <button onclick="closeEditModal()" class="w-full rounded-2xl bg-slate-100 py-3.5 text-sm font-bold text-slate-600 hover:bg-slate-200 transition-all">Batal</button>
                <button onclick="saveEditPost()" id="btnSaveEdit" class="w-full rounded-2xl bg-violet-600 py-3.5 text-sm font-bold text-white hover:bg-violet-700 transition-all shadow-lg shadow-violet-200 active:scale-95">Simpan Perubahan</button>
            </div>
        </div>
    </div>
    <script>
        // Variabel global buat nentuin lagi di tab mana
        let currentFeedType = 'portfolio';

        // --- Switch Feed Style Baru ---
        function switchFeedType(type) {
            currentFeedType = type;
            
            const btnPorto = document.getElementById('tab-portfolio');
            const btnLearn = document.getElementById('tab-learning');

            // Class UI Baru: Ungu untuk Aktif, Abu-abu untuk Non-Aktif
            const activeClass = "px-5 py-2.5 text-xs font-black bg-purple-600 text-white rounded-xl shadow-md uppercase tracking-wider transition-all";
            const inactiveClass = "px-5 py-2.5 text-xs font-black text-slate-600 dark:text-purple-300/70 hover:text-purple-600 uppercase tracking-wider transition-all";

            if(type === 'portfolio') {
                btnPorto.className = activeClass;
                btnLearn.className = inactiveClass;
            } else {
                btnPorto.className = inactiveClass;
                btnLearn.className = activeClass;
            }

            // Reset Feed
            postsWrapper.innerHTML = ''; 
            currentOffset = 0; 
            allPostsLoaded = false; 
            document.getElementById('noMorePosts').classList.add('hidden');
            
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
            article.className = 'card-feed p-6 relative animate-card mb-6'; // Hapus cursor-pointer bawaan kawan lu
            article.id = `post-${post.id}`;
            
            const userName = post.user?.name || 'User';
            const filePath = post.image ? `/storage/${post.image}` : null; 

            let roleBadge = post.user?.role === 'creator' 
                ? `<span class="bg-violet-600 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full ml-2 align-middle shadow-sm uppercase tracking-wider">Creator</span>` 
                : `<span class="bg-slate-200 text-slate-600 text-[10px] font-bold px-2.5 py-0.5 rounded-full ml-2 align-middle shadow-sm uppercase tracking-wider">Learner</span>`;

            const userPhoto = post.user?.photo ? `/${post.user.photo}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(userName)}&background=7c3aed&color=ffffff&rounded=true`;
            
            const isVideo = post.image?.match(/\.(mp4|webm|ogg|mov)$/i);
            const isPDF = post.image?.match(/\.(pdf)$/i);
            const isImage = post.image?.match(/\.(jpg|jpeg|png|gif|webp)$/i);
            const likeColorClass = post.is_liked ? 'text-pink-500 bg-pink-50 border-pink-200' : 'text-slate-500 bg-slate-50 border-slate-200 hover:text-pink-500';

            const safePostData = JSON.stringify(post).replace(/"/g, '&quot;');

            let roomBannerHtml = '';
            if (post.room_id && post.room) {
                let isJoined = false;
                if (post.user_id === currentUserId) isJoined = true; 
                else if (post.room.users) isJoined = post.room.users.some(u => u.id === currentUserId);

                let buttonHtml = isJoined 
                    ? `<a href="/chat/${post.room_id}" class="w-full sm:w-auto bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-2.5 rounded-xl text-xs font-extrabold transition-all text-center block">Buka Kelas</a>` 
                    : `<form action="/chat/join/${post.room_id}" method="POST" class="w-full sm:w-auto shrink-0"><input type="hidden" name="_token" value="${csrfToken}"><button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-xl text-xs font-extrabold shadow-lg shadow-emerald-200 transition-all active:scale-95">Gabung Kelas</button></form>`;

                roomBannerHtml = `<div class="mx-5 mb-5 p-4 bg-emerald-50 rounded-2xl border border-emerald-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 relative z-20" onclick="event.stopPropagation();"><div class="flex items-center gap-3"><div class="h-10 w-10 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 shrink-0 shadow-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 14v6.5" /></svg></div><div><p class="text-[10px] font-extrabold text-emerald-600 uppercase tracking-wider mb-0.5">Ruang Kelas Tersedia</p><p class="text-sm font-bold text-slate-900 line-clamp-1">${post.room.name}</p></div></div>${buttonHtml}</div>`;
            }

            article.innerHTML = `
                <div class="flex items-start justify-between p-5">
                    <div class="flex items-center gap-3">
                        <a href="/profile/${post.user?.id}" class="shrink-0 transition-transform hover:scale-105 relative z-20" onclick="event.stopPropagation();">
                            <img src="${userPhoto}" class="h-11 w-11 rounded-full ring-2 ring-violet-50 object-cover" />
                        </a>
                        <div class="flex-1 relative z-20" onclick="event.stopPropagation();">
                            <div class="flex items-center gap-2">
                                <a href="/profile/${post.user?.id}" class="text-sm font-bold text-slate-900 hover:text-violet-600 hover:underline transition-colors">${userName}</a> ${roleBadge}
                                ${post.type === 'learning' && post.category ? `<span class="bg-violet-100 text-violet-700 text-[9px] font-extrabold px-2 py-0.5 rounded-full uppercase tracking-wider ml-1">${post.category.name}</span>` : ''}
                            </div>
                            <p class="text-[11px] text-slate-400 uppercase font-medium">${formatTimeAgo(post.created_at)}</p>
                        </div>
                    </div>

                    ${post.user_id === currentUserId ? `
                    <div class="relative shrink-0 ml-4 z-30" onclick="event.stopPropagation();">
                        <button onclick="togglePostMenu(${post.id})" class="p-2 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-full transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" /></svg>
                        </button>
                        <div id="post-menu-${post.id}" class="hidden absolute right-0 mt-1 w-36 bg-white rounded-2xl shadow-xl border border-slate-100 z-50 overflow-hidden py-1">
                            <button onclick="editPost(${post.id})" class="w-full text-left px-4 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50 hover:text-violet-600 transition-colors flex items-center gap-2"><span>✏️</span> Edit</button>
                            <button onclick="deletePost(${post.id})" class="w-full text-left px-4 py-2.5 text-sm font-bold text-red-600 hover:bg-red-50 transition-colors flex items-center gap-2 border-t border-slate-50"><span>🗑️</span> Hapus</button>
                        </div>
                    </div>
                    ` : ''} 
                </div>

                <div class="px-5 pb-4 text-sm text-slate-700 leading-relaxed cursor-pointer relative z-10" x-on:click="selectedPost = ${safePostData}">${post.content}</div>

                ${roomBannerHtml}

                <div class="mx-5 mb-5 overflow-hidden rounded-2xl bg-slate-100 flex items-center justify-center relative z-10" onclick="event.stopPropagation();">
                    ${isImage && filePath ? `<img src="${filePath}" class="w-full h-auto object-cover max-h-[500px]">` : ''}
                    ${isVideo && filePath ? `<video src="${filePath}" controls class="w-full h-auto max-h-[500px] bg-black"></video>` : ''}
                    ${isPDF && filePath ? `<div class="w-full flex items-center justify-between p-6 bg-violet-50 border border-violet-100 rounded-2xl"><div class="flex items-center gap-4"><div class="h-12 w-12 flex items-center justify-center bg-white rounded-xl shadow-sm text-red-500 font-bold text-[10px]">PDF</div><p class="text-sm font-bold text-slate-900 truncate max-w-[150px]">Dokumen Materi</p></div><a href="${filePath}" target="_blank" class="rounded-xl bg-violet-600 px-4 py-2 text-xs font-bold text-white hover:bg-violet-700 shadow-lg shadow-violet-100">Buka File</a></div>` : ''}
                </div>

                <div class="pt-3 border-t-2 border-dashed border-slate-100 dark:border-slate-800/60 flex gap-2 text-[11px] font-bold relative z-20" onclick="event.stopPropagation();">
                    <button onclick="handleLike(${post.id})" id="like-btn-${post.id}" class="flex items-center gap-1.5 px-4 py-2 rounded-xl transition-transform active:scale-95 border ${likeColorClass}">
                        👍 <span id="like-count-${post.id}">${post.likes_count || 0}</span>
                    </button>
                    <button onclick="openCommentModal(${post.id})" class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-slate-500 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 transition-all active:scale-95">
                        💬 <span id="comment-count-${post.id}">${post.comments_count || 0}</span>
                    </button>
                </div>
            `;
            return article;
        }

        // --- FUNGSI LIKE (VERSI UPDATE UI) ---
        async function handleLike(postId) {
            const btnElement = document.getElementById(`like-btn-${postId}`);
            const countElement = document.getElementById(`like-count-${postId}`);
            
            try {
                const response = await fetch(`/posts/${postId}/like`, {
                    method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                });
                const result = await response.json();
                let currentCount = parseInt(countElement.innerText);

                if (result.status === 'liked') {
                    btnElement.className = 'flex items-center gap-1.5 px-4 py-2 rounded-xl transition-transform active:scale-95 border text-pink-500 bg-pink-50 border-pink-200';
                    countElement.innerText = currentCount + 1;
                    globalPostsData[postId].is_liked = true;
                } else {
                    btnElement.className = 'flex items-center gap-1.5 px-4 py-2 rounded-xl transition-transform active:scale-95 border text-slate-500 bg-slate-50 border-slate-200 hover:text-pink-500';
                    countElement.innerText = currentCount - 1;
                    globalPostsData[postId].is_liked = false;
                }
            } catch (error) { console.error("Gagal melakukan like:", error); }
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
                roleBadgeComment = `<span class="bg-violet-600 text-white text-[8px] font-bold px-2 py-0.5 rounded-full ml-1.5 align-middle shadow-sm uppercase tracking-wider">Creator</span>`;
            } else {
                roleBadgeComment = `<span class="bg-slate-200 text-slate-600 text-[8px] font-bold px-2 py-0.5 rounded-full ml-1.5 align-middle shadow-sm uppercase tracking-wider">Learner</span>`;
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
        const mainScrollArea = document.getElementById('mainScroll');
        mainScrollArea.addEventListener('scroll', () => {
            if (allPostsLoaded || isLoading) return;
            // Deteksi mentok bawah khusus untuk kontainer <main>
            if (mainScrollArea.scrollTop + mainScrollArea.clientHeight >= mainScrollArea.scrollHeight - 500) {
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

        // Buka/Tutup Dropdown Menu Titik Tiga
        function togglePostMenu(id) {
            const menu = document.getElementById(`post-menu-${id}`);
            menu.classList.toggle('hidden');
        }

        // Kalau sembarang tempat diklik, menu titik tiganya otomatis ketutup
        document.addEventListener('click', function(event) {
            const isClickInsideMenu = event.target.closest('[id^="post-menu-"]');
            const isClickOnButton = event.target.closest('button[onclick^="togglePostMenu"]');
            
            if (!isClickInsideMenu && !isClickOnButton) {
                document.querySelectorAll('[id^="post-menu-"]').forEach(menu => {
                    menu.classList.add('hidden');
                });
            }
        });

        // Fitur Hapus Postingan (AJAX, Mulus tanpa Reload)
        async function deletePost(id) {
            if(!confirm('Beneran mau hapus postingan ini, beb? Nggak bisa di-undo lho.')) return;
            
            try {
                const response = await fetch(`/posts/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                
                const result = await response.json();
                if(result.success) {
                    // Hapus kartu postingan dari layar!
                    const postCard = document.getElementById(`post-${id}`);
                    postCard.style.transform = 'scale(0.9)';
                    postCard.style.opacity = '0';
                    setTimeout(() => postCard.remove(), 300);
                } else {
                    alert('Gagal hapus: ' + result.message);
                }
            } catch(e) {
                alert('Gagal kontak server, beb.');
            }
        }

        // --- FITUR EDIT POSTINGAN ---
        
        // 1. Buka Modal & Isi Teks Lama
        function editPost(id) {
            const post = globalPostsData[id];
            if(!post) return alert('Waduh, data postingan ilang dari memori beb!');

            // Masukin data ke form modal
            document.getElementById('editPostId').value = id;
            document.getElementById('editCaptionText').value = post.content;
            
            // Munculin modal pake animasi
            const modal = document.getElementById('editPostModal');
            const modalContent = document.getElementById('editModalContent');
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
            
            // Tutup dropdown titik 3-nya
            togglePostMenu(id);
        }

        // 2. Tutup Modal
        function closeEditModal() {
            const modal = document.getElementById('editPostModal');
            const modalContent = document.getElementById('editModalContent');
            
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }

        // 3. Tembak AJAX buat nyimpen Edit
        async function saveEditPost() {
            const id = document.getElementById('editPostId').value;
            const newContent = document.getElementById('editCaptionText').value.trim();
            const btn = document.getElementById('btnSaveEdit');

            if(!newContent) return alert('Caption nggak boleh kosong dong beb, masa sepi amat!');

            btn.innerText = 'Menyimpan...';
            btn.disabled = true;

            try {
                const response = await fetch(`/posts/${id}`, {
                    method: 'PUT', // Pake metode PUT buat update data
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ content: newContent })
                });

                const result = await response.json();
                
                if(result.success) {
                    globalPostsData[id].content = newContent;
                
                    const postCard = document.getElementById(`post-${id}`);
                    const contentDiv = postCard.querySelector('.px-5.pb-4.text-sm.text-slate-700.leading-relaxed');
                    if(contentDiv) {
                        contentDiv.innerText = newContent;
                        contentDiv.classList.add('bg-yellow-100', 'transition-colors', 'duration-500');
                        setTimeout(() => contentDiv.classList.remove('bg-yellow-100'), 500);
                    }

                    closeEditModal();
                } else {
                    alert('Gagal update: ' + result.message);
                }
            } catch(e) {
                alert('Gagal terhubung ke server nih.');
            } finally {
                btn.innerText = 'Simpan Perubahan';
                btn.disabled = false;
            }
        }
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LearnLoop | Platform Kolaborasi Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .glass-effect { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.05); }
    </style>
</head>
<body class="min-h-screen text-slate-900">

    <!-- HEADER -->
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
                <button id="uploadBtn" class="hidden items-center gap-2 rounded-2xl bg-violet-600 px-5 py-2.5 text-sm font-bold text-white shadow-md transition-all hover:bg-violet-700 md:flex">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14m7-7H5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Upload
                </button>
                <img src="https://ui-avatars.com/api/?name=Yaza&background=8b5cf6&color=ffffff&rounded=true" class="h-9 w-9 rounded-xl shadow-sm" />
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-8 pb-24 sm:px-6">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
            
            <!-- ASIDE KIRI -->
            <aside class="hidden lg:col-span-3 lg:block">
                <div class="sticky top-28 space-y-4">
                    <nav class="space-y-1">
                        <!-- Beranda -->
                        <a href="#" class="group flex items-center gap-3 rounded-2xl bg-violet-50 px-4 py-3 text-sm font-bold text-violet-700 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Beranda
                        </a>

                        <!-- Direct Message -->
                        <a href="#" class="group flex items-center justify-between rounded-2xl px-4 py-3 text-sm font-medium text-slate-600 transition-all hover:bg-slate-100 hover:text-slate-900">
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                Pesan
                            </div>
                            <span class="flex h-2 w-2 rounded-full bg-red-500"></span>
                        </a>

                        <!-- Profil Saya -->
                        <a href="#" class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium text-slate-600 transition-all hover:bg-slate-100 hover:text-slate-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Profil Saya
                        </a>
                    </nav>

                    <div class="mx-4 h-px bg-slate-200"></div>

                    <div class="px-4 pt-2">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Komunitas Kamu</p>
                        <div class="mt-4 space-y-4">
                            <a href="#" class="flex items-center gap-3 group">
                                <div class="h-8 w-8 rounded-lg bg-orange-100 flex items-center justify-center text-orange-600 font-bold text-xs group-hover:scale-110 transition-transform">AI</div>
                                <span class="text-xs font-bold text-slate-600 group-hover:text-slate-900">AI Research</span>
                            </a>
                            <a href="#" class="flex items-center gap-3 group">
                                <div class="h-8 w-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs group-hover:scale-110 transition-transform">UI</div>
                                <span class="text-xs font-bold text-slate-600 group-hover:text-slate-900">UI/UX Design</span>
                            </a>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- FEED UTAMA -->
            <section id="feedContainer" class="lg:col-span-6 space-y-8">
                <!-- Welcome Card -->
                <div class="relative overflow-hidden rounded-[32px] bg-white border border-slate-200 p-8 shadow-sm">
                    <h1 class="text-2xl font-extrabold text-slate-900">Halo, {{ Auth::user()->name ?? 'Pengguna' }}! 👋</h1>
                    <p class="text-sm text-slate-500 mt-1">Bagikan ilmu kamu hari ini.</p>
                </div>

                <!-- Posts Container -->
                <div id="postsWrapper"></div>

                <!-- Loading Indicator -->
                <div id="loadingIndicator" class="hidden text-center py-6">
                    <div class="inline-block animate-spin">
                        <svg class="h-6 w-6 text-violet-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                    <p class="text-slate-500 text-sm mt-2">Memuat postingan...</p>
                </div>

                <!-- No More Posts -->
                <div id="noMorePosts" class="hidden text-center py-8">
                    <p class="text-slate-500 text-sm">Tidak ada postingan lagi</p>
                </div>
            </section>

            <!-- ASIDE KANAN -->
            <aside class="hidden lg:col-span-3 lg:block"></aside>
        </div>
    </main>

    <!-- MODAL UPLOAD -->
    <div id="uploadModal" class="fixed inset-0 z-[60] hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div class="w-full max-w-lg rounded-[32px] bg-white p-8 shadow-2xl">
            <h3 class="text-xl font-bold mb-6">Posting Konten Baru</h3>
            <div id="previewArea" class="mb-4 rounded-2xl bg-slate-50 border-2 border-dashed border-slate-200 min-h-[150px] flex items-center justify-center overflow-hidden"></div>
            <textarea id="captionText" rows="3" class="w-full rounded-2xl border border-slate-200 p-4 text-sm outline-none focus:border-violet-500" placeholder="Tulis caption..."></textarea>
            <button id="submitUpload" class="mt-6 w-full rounded-2xl bg-violet-600 py-4 text-sm font-bold text-white hover:bg-violet-700 transition-all">Posting Sekarang</button>
            <button id="closeModal" class="w-full mt-2 text-sm text-slate-400 font-medium py-2">Batal</button>
        </div>
    </div>

    <script>
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

        let selectedFileUrl = "";
        let currentOffset = 0;
        let isLoading = false;
        let allPostsLoaded = false;
        const INITIAL_LOAD = 5;
        const LOAD_PER_SCROLL = 3;

        // Format waktu relatif
        function formatTimeAgo(date) {
            const now = new Date();
            const postDate = new Date(date);
            const seconds = Math.floor((now - postDate) / 1000);
            
            if (seconds < 60) return 'Baru saja';
            if (seconds < 3600) return Math.floor(seconds / 60) + ' menit lalu';
            if (seconds < 86400) return Math.floor(seconds / 3600) + ' jam lalu';
            return Math.floor(seconds / 86400) + ' hari lalu';
        }

        // Render post
        function renderPost(post) {
            const article = document.createElement('article');
            article.className = 'card-hover overflow-hidden rounded-[32px] border border-slate-200 bg-white';
            
            const userInitials = post.user?.name ? post.user.name.split(' ').map(n => n[0]).join('').toUpperCase() : 'U';
            const userName = post.user?.name || 'User';
            
            article.innerHTML = `
                <div class="flex items-center gap-3 p-5">
                    <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(userName)}&background=7c3aed&color=ffffff&rounded=true" class="h-11 w-11 rounded-full ring-2 ring-violet-50" />
                    <div>
                        <p class="text-sm font-bold text-slate-900">${userName}</p>
                        <p class="text-[11px] text-slate-400 uppercase font-medium">${formatTimeAgo(post.created_at)}</p>
                    </div>
                </div>
                <div class="px-5 pb-4 text-sm text-slate-700">${post.content}</div>
                ${post.image ? `
                    <div class="mx-5 mb-5 h-64 overflow-hidden rounded-2xl bg-slate-100">
                        <img src="/storage/${post.image}" class="h-full w-full object-cover" onerror="this.style.display='none'" />
                    </div>
                ` : ''}
                <div class="border-t border-slate-50 px-6 py-4 flex gap-6 text-sm font-bold text-slate-600">
                    <span>❤️ ${post.likes_count || 0}</span>
                    <span>💬 ${post.comments_count || post.comments?.length || 0}</span>
                </div>
            `;
            
            return article;
        }

        // Fetch posts
        async function fetchPosts(offset, limit) {
            if (isLoading) return;
            
            isLoading = true;
            loadingIndicator.classList.remove('hidden');

            try {
                const response = await fetch(`/api/posts/fetch?offset=${offset}&limit=${limit}`);
                const result = await response.json();

                if (result.success && result.data.length > 0) {
                    result.data.forEach(post => {
                        const postElement = renderPost(post);
                        postsWrapper.appendChild(postElement);
                    });
                    
                    currentOffset += result.data.length;

                    if (result.data.length < limit) {
                        allPostsLoaded = true;
                        noMorePosts.classList.remove('hidden');
                    }
                } else if (offset === 0) {
                    noMorePosts.classList.remove('hidden');
                    allPostsLoaded = true;
                }
            } catch (error) {
                console.error('Error fetching posts:', error);
            } finally {
                isLoading = false;
                loadingIndicator.classList.add('hidden');
            }
        }

        // Infinite scroll
        window.addEventListener('scroll', () => {
            if (allPostsLoaded || isLoading) return;

            const scrollPosition = window.innerHeight + window.scrollY;
            const threshold = document.documentElement.scrollHeight - 500;

            if (scrollPosition >= threshold) {
                fetchPosts(currentOffset, LOAD_PER_SCROLL);
            }
        });

        // Initial load
        fetchPosts(0, INITIAL_LOAD);

        // Upload functionality
        uploadBtn.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                selectedFileUrl = URL.createObjectURL(file);
                if (file.type.startsWith('image/')) {
                    previewArea.innerHTML = `<img src="${selectedFileUrl}" class="w-full h-full object-cover">`;
                } else if (file.type.startsWith('video/')) {
                    previewArea.innerHTML = `<video src="${selectedFileUrl}" class="w-full h-full object-cover" autoplay muted loop></video>`;
                } else {
                    previewArea.innerHTML = `<div class="p-4 text-violet-600 font-bold underline">${file.name}</div>`;
                }
                uploadModal.classList.remove('hidden');
            }
        });

        submitUpload.addEventListener('click', () => {
            const caption = captionText.value;
            if(!caption.trim()) return alert("Isi caption dulu!");

            submitUpload.innerText = "Mengunggah...";
            submitUpload.disabled = true;

            setTimeout(() => {
                const newPost = document.createElement('article');
                newPost.className = "card-hover overflow-hidden rounded-[32px] border border-slate-200 bg-white animate-fade-in";
                
                newPost.innerHTML = `
                    <div class="flex items-center gap-3 p-5">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=8b5cf6&color=ffffff&rounded=true" class="h-11 w-11 rounded-full ring-2 ring-violet-50" />
                        <div>
                            <p class="text-sm font-bold text-slate-900">{{ Auth::user()->name ?? 'Anda' }}</p>
                            <p class="text-[11px] text-slate-400 uppercase font-medium">Baru saja</p>
                        </div>
                    </div>
                    <div class="px-5 pb-4 text-sm text-slate-700">${caption}</div>
                    <div class="mx-5 mb-5 h-80 overflow-hidden rounded-2xl bg-slate-100 flex items-center justify-center">
                        ${fileInput.files[0].type.startsWith('image/') 
                            ? `<img src="${selectedFileUrl}" class="h-full w-full object-cover">` 
                            : `<video src="${selectedFileUrl}" controls class="w-full h-full object-cover"></video>`
                        }
                    </div>
                    <div class="border-t border-slate-50 px-6 py-4 flex gap-6 text-sm font-bold text-slate-600">
                         <span>❤️ 0</span> <span>💬 0</span>
                    </div>
                `;

                postsWrapper.insertBefore(newPost, postsWrapper.children[0]);

                uploadModal.classList.add('hidden');
                submitUpload.innerText = "Posting Sekarang";
                submitUpload.disabled = false;
                captionText.value = "";
                fileInput.value = "";
                newPost.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 1000);
        });

        closeModal.addEventListener('click', () => uploadModal.classList.add('hidden'));
    </script>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
    </style>

</body>
</html>
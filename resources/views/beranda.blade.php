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
                <img src="https://ui-avatars.com/api/?name=Yaza&background=8b5cf6&color=ffffff&rounded=true" class="h-9 w-9 rounded-xl shadow-sm" />
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-8 pb-24 sm:px-6">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
            
            <aside class="hidden lg:col-span-3 lg:block">
                <div class="sticky top-28 space-y-4">
                    <nav class="space-y-1">
                        <a href="#" class="group flex items-center gap-3 rounded-2xl bg-violet-50 px-4 py-3 text-sm font-bold text-violet-700 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Beranda
                        </a>
                        <a href="#" class="group flex items-center justify-between rounded-2xl px-4 py-3 text-sm font-medium text-slate-600 transition-all hover:bg-slate-100 hover:text-slate-900">
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                Pesan
                            </div>
                            <span class="flex h-2 w-2 rounded-full bg-red-500"></span>
                        </a>
                    </nav>
                </div>
            </aside>

            <section id="feedContainer" class="lg:col-span-6 space-y-8">
                <div class="relative overflow-hidden rounded-[32px] bg-white border border-slate-200 p-8 shadow-sm">
                    <h1 class="text-2xl font-extrabold text-slate-900">Halo, Mahasiswa Kreatif! 👋</h1>
                    <p class="text-sm text-slate-500 mt-1">Bagikan materi atau hasil karyamu hari ini.</p>
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
            <div id="previewArea" class="mb-4 rounded-2xl bg-slate-50 border-2 border-dashed border-slate-200 min-h-[150px] flex items-center justify-center overflow-hidden">
                </div>
            <textarea id="captionText" rows="3" class="w-full rounded-2xl border border-slate-200 p-4 text-sm outline-none focus:border-violet-500 transition-all" placeholder="Tulis deskripsi postingan..."></textarea>
            <button id="submitUpload" class="mt-6 w-full rounded-2xl bg-violet-600 py-4 text-sm font-bold text-white hover:bg-violet-700 transition-all">Posting Sekarang</button>
            <button id="closeModal" class="w-full mt-2 text-sm text-slate-400 font-medium py-2 hover:text-slate-600">Batal</button>
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
            const article = document.createElement('article');
            article.className = 'card-hover overflow-hidden rounded-[32px] border border-slate-200 bg-white mb-6';
            
            const userName = post.user?.name || 'User';
            const filePath = `/storage/${post.image}`; 
            
            // Cek Tipe File
            const isVideo = post.image?.match(/\.(mp4|webm|ogg|mov)$/i);
            const isPDF = post.image?.match(/\.(pdf)$/i);
            const isImage = post.image?.match(/\.(jpg|jpeg|png|gif|webp)$/i);

            article.innerHTML = `
                <div class="flex items-center gap-3 p-5">
                    <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(userName)}&background=7c3aed&color=ffffff&rounded=true" class="h-11 w-11 rounded-full ring-2 ring-violet-50" />
                    <div>
                        <p class="text-sm font-bold text-slate-900">${userName}</p>
                        <p class="text-[11px] text-slate-400 uppercase font-medium">${formatTimeAgo(post.created_at)}</p>
                    </div>
                </div>
                <div class="px-5 pb-4 text-sm text-slate-700 leading-relaxed">${post.content}</div>
                
                <div class="mx-5 mb-5 overflow-hidden rounded-2xl bg-slate-100 flex items-center justify-center">
                    ${isImage ? `
                        <img src="${filePath}" class="w-full h-auto object-cover max-h-[500px]" onerror="this.parentElement.innerHTML='<p class=\"p-4 text-xs text-slate-400\">Gambar tidak dapat dimuat</p>'">
                    ` : ''}

                    ${isVideo ? `
                        <video src="${filePath}" controls class="w-full h-auto max-h-[500px] bg-black"></video>
                    ` : ''}

                    ${isPDF ? `
                        <div class="w-full flex items-center justify-between p-6 bg-violet-50 border border-violet-100 rounded-2xl">
                            <div class="flex items-center gap-4">
                                <div class="h-12 w-12 flex items-center justify-center bg-white rounded-xl shadow-sm text-red-500 font-bold text-[10px]">PDF</div>
                                <div class="overflow-hidden">
                                    <p class="text-sm font-bold text-slate-900 truncate max-w-[150px]">Dokumen Materi</p>
                                    <p class="text-[10px] text-slate-500 italic">Klik untuk membaca</p>
                                </div>
                            </div>
                            <a href="${filePath}" target="_blank" class="rounded-xl bg-violet-600 px-4 py-2 text-xs font-bold text-white hover:bg-violet-700 shadow-lg shadow-violet-100">Buka File</a>
                        </div>
                    ` : ''}
                </div>

                <div class="border-t border-slate-50 px-6 py-4 flex gap-6 text-sm font-bold text-slate-600">
                    <button class="flex items-center gap-1.5 hover:text-red-500 transition-colors">❤️ ${post.likes_count || 0}</button>
                    <button class="flex items-center gap-1.5 hover:text-violet-600 transition-colors">💬 ${post.comments_count || 0}</button>
                </div>
            `;
            
            return article;
        }

        async function fetchPosts(offset, limit) {
            if (isLoading) return;
            isLoading = true;
            loadingIndicator.classList.remove('hidden');

            try {
                const response = await fetch(`/api/posts/fetch?offset=${offset}&limit=${limit}`);
                const result = await response.json();

                if (result.success && result.data.length > 0) {
                    result.data.forEach(post => {
                        postsWrapper.appendChild(renderPost(post));
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
                console.error('Fetch Error:', error);
            } finally {
                isLoading = false;
                loadingIndicator.classList.add('hidden');
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

        // Upload Preview
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

        // Submit Form
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
                const response = await fetch('/api/posts', {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '' }
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
    </script>
</body>
</html>
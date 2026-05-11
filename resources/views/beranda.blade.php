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
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=8b5cf6&color=ffffff&rounded=true" class="h-9 w-9 rounded-xl shadow-sm border border-violet-100" title="Lihat Profil" />
                </a>

            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-8 pb-24 sm:px-6">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
            
            <aside class="hidden lg:col-span-3 lg:block">
                <div class="sticky top-28 space-y-4">
                    <nav class="space-y-1">
                        <a href="/beranda" class="group flex items-center gap-3 rounded-2xl bg-violet-50 px-4 py-3 text-sm font-bold text-violet-700 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Beranda
                        </a>
                        <a href="/contacts" class="group flex items-center justify-between rounded-2xl px-4 py-3 text-sm font-medium text-slate-600 transition-all hover:bg-slate-100 hover:text-slate-900">
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                Pesan
                            </div>
                        </a>
                        <a href="/profile" class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium text-slate-600 transition-all hover:bg-slate-100 hover:text-slate-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
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
                    <button type="submit" class="bg-violet-600 hover:bg-violet-700 text-white rounded-full h-11 w-11 flex items-center justify-center transition-transform hover:scale-105 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                    </button>
                </form>
            </div>
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
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

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
            globalPostsData[post.id] = post; // Simpan di global variabel

            const article = document.createElement('article');
            article.className = 'card-hover overflow-hidden rounded-[32px] border border-slate-200 bg-white mb-6';
            article.id = `post-${post.id}`;
            
            const userName = post.user?.name || 'User';
            const filePath = post.image ? `/storage/${post.image}` : null; 
            
            const isVideo = post.image?.match(/\.(mp4|webm|ogg|mov)$/i);
            const isPDF = post.image?.match(/\.(pdf)$/i);
            const isImage = post.image?.match(/\.(jpg|jpeg|png|gif|webp)$/i);

            // Cek Status Like (Merah kalau is_liked true)
            const likeColorClass = post.is_liked ? 'text-red-500' : 'text-slate-600 hover:text-red-500';

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
                    ${isImage && filePath ? `<img src="${filePath}" class="w-full h-auto object-cover max-h-[500px]">` : ''}
                    ${isVideo && filePath ? `<video src="${filePath}" controls class="w-full h-auto max-h-[500px] bg-black"></video>` : ''}
                    ${isPDF && filePath ? `
                        <div class="w-full flex items-center justify-between p-6 bg-violet-50 border border-violet-100 rounded-2xl">
                            <div class="flex items-center gap-4">
                                <div class="h-12 w-12 flex items-center justify-center bg-white rounded-xl shadow-sm text-red-500 font-bold text-[10px]">PDF</div>
                                <div class="overflow-hidden">
                                    <p class="text-sm font-bold text-slate-900 truncate max-w-[150px]">Dokumen Materi</p>
                                </div>
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
            console.log(`DEBUG -> User: ${comment.user?.name}, ID: ${comment.id}, Parent: ${comment.parent_id}, IsReply: ${isReply}`);
            const userName = comment.user?.name || 'User';
            const noDataHtml = commentsList.querySelector('p.text-slate-400');
            if (noDataHtml) noDataHtml.remove();

            const commentDiv = document.createElement('div');
            // Kalau isReply = true, kasih margin kiri biar menjorok
            commentDiv.className = `flex gap-3 ${isReply ? 'ml-10 mt-2' : 'mt-5'}`;
    
            commentDiv.innerHTML = `
                <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(userName)}&background=e2e8f0&color=475569" class="h-8 w-8 rounded-full shrink-0">
                <div class="bg-white border border-slate-200 rounded-2xl rounded-tl-sm px-4 py-3 shadow-sm flex-1">
                    <div class="flex justify-between items-center mb-0.5">
                        <p class="text-[11px] font-bold text-slate-500">${userName}</p>
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
            if (isLoading) return;
            isLoading = true;
            loadingIndicator.classList.remove('hidden');

            try {
                const response = await fetch(`/posts/fetch?offset=${offset}&limit=${limit}`);
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
    </script>
</body>
</html>
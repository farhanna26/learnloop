<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $user->name }} | LearnLoop Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .glass-effect { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        .tab-active { border-bottom: 4px solid #7c3aed; color: #1e293b; font-weight: 700; }
        .tab-inactive { color: #64748b; font-weight: 500; }
        .tab-inactive:hover { background-color: #f1f5f9; }
    </style>
</head>
<body class="min-h-screen text-slate-900">

    <header class="sticky top-0 z-50 border-b border-slate-200 glass-effect">
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
                <a href="/profile" class="transition-transform hover:scale-110 active:scale-95">
                    <img src="{{ Auth::user()->photo ? asset(Auth::user()->photo) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name ?? 'User').'&background=8b5cf6&color=ffffff&rounded=true' }}" 
                        class="h-9 w-9 rounded-xl object-cover shadow-sm border border-violet-100" />
                </a>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-8 pb-24 sm:px-6">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
            
            <aside class="hidden lg:col-span-3 lg:block">
                <div class="sticky top-28 space-y-4">
                    <nav class="space-y-1">
                        <a href="/beranda" class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium text-slate-600 transition-all hover:bg-slate-100 hover:text-slate-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Beranda
                        </a>
                        <a href="/contacts" class="group flex items-center justify-between rounded-2xl px-4 py-3 text-sm font-medium text-slate-600 transition-all hover:bg-slate-100 hover:text-slate-900">
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                Pesan
                            </div>
                        </a>
                        <a href="/search" class="group flex items-center justify-between rounded-2xl px-4 py-3 text-sm font-medium text-slate-600 transition-all hover:bg-slate-100 hover:text-slate-900">
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Search
                            </div>
                        </a>
                        <a href="/notifications" class="group flex items-center justify-between rounded-2xl px-4 py-3 text-sm font-medium text-slate-600 transition-all hover:bg-slate-100 hover:text-slate-900 {{ request()->is('notifications') ? 'bg-violet-50 text-violet-700 font-bold' : '' }}">
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                Notifikasi
                            </div>
                            
                            @php $unreadCount = auth()->user()->notifications()->where('is_read', false)->count(); @endphp
                            @if($unreadCount > 0)
                                <span class="flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-[10px] text-white">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </a>
                        <a href="/profile" class="group flex items-center gap-3 rounded-2xl bg-violet-50 px-4 py-3 text-sm font-bold text-violet-700 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profil
                        </a>
                    </nav>
                </div>
            </aside>

            <section class="lg:col-span-6 space-y-6">
                
                @if(session('success'))
                    <div class="flex items-center gap-3 rounded-2xl border border-emerald-100 bg-emerald-50 p-4 text-sm font-bold text-emerald-700 shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-hidden rounded-[32px] border border-slate-200 bg-white shadow-sm mb-8">
                    
                    <div class="h-40 w-full bg-slate-200 overflow-hidden">
                        @if($user->banner)
                            <img src="{{ asset($user->banner) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-r from-violet-400 to-fuchsia-400"></div>
                        @endif
                    </div>
                    
                    <div class="px-6 flex justify-between items-start -mt-16 relative">
                        
                        <div class="rounded-full p-1.5 bg-white">
                            <img src="{{ $user->photo ? asset($user->photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=8b5cf6&color=ffffff&rounded=true' }}" 
                                 class="h-28 w-28 rounded-full object-cover shadow-md border-4 border-white bg-white" />
                        </div>
                        
                        <div class="mt-20 flex items-center gap-3">
                            @if(Auth::id() == $user->id)
                                <a href="/profile/edit" class="rounded-full border border-slate-300 px-5 py-2 text-sm font-bold text-slate-700 transition hover:bg-slate-50">
                                    Edit Profil
                                </a>
                            @else
                                <button id="follow-btn" onclick="handleFollow({{ $user->id }})" class="rounded-full px-5 py-2 text-sm font-bold shadow-lg transition active:scale-95 flex items-center gap-2 {{ $isFollowing ? 'bg-slate-200 text-slate-800 shadow-slate-200 hover:bg-red-100 hover:text-red-600' : 'bg-violet-600 text-white shadow-violet-200 hover:bg-violet-700' }}">
                                    <svg id="follow-icon" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ $isFollowing ? 'hidden' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                    <span id="follow-text">{{ $isFollowing ? 'Following' : 'Follow' }}</span>
                                </button>

                                <a href="/chat/private/{{ $user->id }}" id="chat-btn" class="rounded-full h-9 w-9 flex items-center justify-center bg-white text-slate-600 hover:bg-violet-100 hover:text-violet-600 transition-colors shadow-sm border border-slate-200 {{ $isFollowing ? '' : 'hidden' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="px-6 mt-3 pb-8">
                        <h1 class="text-2xl font-extrabold text-slate-900">{{ $user->name }}</h1>
                        <p class="text-sm font-medium text-slate-500">{{ $user->email }}</p>
                        
                        <div class="mt-4 text-sm text-slate-800 leading-relaxed">
                            {{ $user->description ?? 'Belum ada deskripsi profil. Klik Edit Profil untuk menambahkan.' }}
                        </div>

                        <div class="mt-5 flex gap-6 text-sm">
                            <div class="flex gap-1.5 items-center">
                                <span class="font-extrabold text-slate-900">{{ $user->followings_count ?? 0 }}</span>
                                <span class="font-medium text-slate-500">Mengikuti</span>
                            </div>
                            <div class="flex gap-1.5 items-center">
                                <span class="font-extrabold text-slate-900" id="follower-count">{{ $user->followers_count ?? 0 }}</span>
                                <span class="font-medium text-slate-500">Pengikut</span>
                            </div>
                            <div class="flex gap-1.5 items-center">
                                <span class="font-extrabold text-slate-900">{{ $user->posts_count ?? 0 }}</span>
                                <span class="font-medium text-slate-500">Postingan</span>
                            </div>
                        </div>

                        <div class="mt-4 flex flex-wrap gap-4 text-sm text-slate-500">
                            <div class="flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                Indonesia
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                Bergabung {{ $user->created_at->format('M Y') }}
                            </div>
                        </div>
                    </div>
                </div>

                <div id="postsWrapper" class="space-y-6">
                    <div class="text-center py-10 bg-white rounded-[32px] border border-slate-200">
                        <p class="text-slate-500 font-medium">Postingan lu bakal muncul di sini.</p>
                    </div>
                </div>

            </section>

            <aside class="hidden lg:col-span-3 lg:block">
                </aside>
            
        </div>
    </main>

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
    // Ambil ID user yang lagi dilihat profilnya
    const profileUserId = "{{ $user->id }}"; 
    
    const postsWrapper = document.getElementById('postsWrapper');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const commentModal = document.getElementById('commentModal');
    const closeCommentModal = document.getElementById('closeCommentModal');
    const commentsList = document.getElementById('commentsList');
    const commentForm = document.getElementById('commentForm');
    const commentInput = document.getElementById('commentInput');
    let currentActivePostId = null; 
    let globalPostsData = {}; 
    let currentParentId = null;

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

    // Fungsi Render Card Postingan (Sama Persis Kaya Beranda)
    function renderPost(post) {
        // 1. TAMBAHIN BARIS INI DI PALING ATAS FUNGSI:
        globalPostsData[post.id] = post;
        const article = document.createElement('article');
        article.className = 'card-hover overflow-hidden rounded-[32px] border border-slate-200 bg-white mb-6';
        article.id = `post-${post.id}`;
        
        const userName = post.user?.name || 'User';
        const filePath = post.image ? `/storage/${post.image}` : null; 

        // --- TAMBAHAN BARU: Cek foto profil si pembuat post ---
        const userPhoto = post.user?.photo 
            ? `/${post.user.photo}` 
            : `https://ui-avatars.com/api/?name=${encodeURIComponent(userName)}&background=7c3aed&color=ffffff&rounded=true`;
        
        const isVideo = post.image?.match(/\.(mp4|webm|ogg|mov)$/i);
        const isPDF = post.image?.match(/\.(pdf)$/i);
        const isImage = post.image?.match(/\.(jpg|jpeg|png|gif|webp)$/i);

        const likeColorClass = post.is_liked ? 'text-red-500' : 'text-slate-600 hover:text-red-500';

        article.innerHTML = `
            <div class="flex items-center gap-3 p-5">
                <img src="${userPhoto}" class="h-11 w-11 rounded-full ring-2 ring-violet-50" />
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

    // Fungsi Fetch Postingan
    async function fetchUserPosts(offset, limit) {
        if (isLoading || allPostsLoaded) return;
        isLoading = true;

        try {
            // PERHATIKAN INI: Kita tambahin parameter user_id di URL
            const response = await fetch(`/posts/fetch?offset=${offset}&limit=${limit}&user_id=${profileUserId}`);
            const result = await response.json();

            if (result.success) {
                // Kalau ini load pertama kali, bersihin placeholder-nya dulu
                if (offset === 0) {
                    postsWrapper.innerHTML = ''; 
                }

                if (result.data.length > 0) {
                    result.data.forEach(post => {
                        postsWrapper.appendChild(renderPost(post));
                    });
                    currentOffset += result.data.length;
                    
                    if (result.data.length < limit) {
                        allPostsLoaded = true;
                    }
                } else if (offset === 0) {
                    // Kalau emang user ini belum pernah posting sama sekali
                    postsWrapper.innerHTML = `
                        <div class="text-center py-10 bg-white rounded-[32px] border border-slate-200">
                            <p class="text-slate-500 font-medium">Belum ada postingan.</p>
                        </div>
                    `;
                    allPostsLoaded = true;
                }
            }
        } catch (error) {
            console.error('Fetch Error:', error);
        } finally {
            isLoading = false;
        }
    }

    // Panggil fungsi saat halaman pertama kali dibuka
    fetchUserPosts(0, 5);

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

           // --- TAMBAHAN BARU: Cek foto profil si pengomen ---
            const commenterPhoto = comment.user?.photo 
                ? `${window.location.origin}/${comment.user.photo}` 
                : `https://ui-avatars.com/api/?name=${encodeURIComponent(userName)}&background=e2e8f0&color=475569`;

            const noDataHtml = commentsList.querySelector('p.text-slate-400');
            if (noDataHtml) noDataHtml.remove();

            const commentDiv = document.createElement('div');
            // Kalau isReply = true, kasih margin kiri biar menjorok
            commentDiv.className = `flex gap-3 ${isReply ? 'ml-10 mt-2' : 'mt-5'}`;
    
            commentDiv.innerHTML = `
                <img src="${commenterPhoto}" class="h-8 w-8 rounded-full shrink-0">
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

        // === FUNGSI AJAX BUAT FOLLOW/UNFOLLOW ===
        async function handleFollow(targetId) {
            const followBtn = document.getElementById('follow-btn');
            const followText = document.getElementById('follow-text');
            const followIcon = document.getElementById('follow-icon');
            const followerCountSpan = document.getElementById('follower-count'); // Yang tadi kita kasih ID
            const chatBtn = document.getElementById('chat-btn'); // Tangkap tombol chatnya
            
            // Disable tombol sementara biar gak dispam klik
            followBtn.disabled = true;

            try {
                const response = await fetch(`/profile/${targetId}/follow`, {
                    method: 'POST',
                    headers: { 
                        'X-CSRF-TOKEN': csrfToken, 
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });
                const result = await response.json();

                if (result.success) {
                    let currentFollowers = parseInt(followerCountSpan.innerText);

                    if (result.is_following) {
                        // Kalau berhasil Follow: Ganti abu-abu
                        followBtn.className = "rounded-full px-5 py-2 text-sm font-bold shadow-lg transition active:scale-95 flex items-center gap-2 bg-slate-200 text-slate-800 shadow-slate-200 hover:bg-red-100 hover:text-red-600";
                        followText.innerText = "Following";
                        followIcon.classList.add('hidden');
                        followerCountSpan.innerText = currentFollowers + 1; // Angka nambah 1
                        if(chatBtn) chatBtn.classList.remove('hidden');
                    } else {
                        // Kalau di-Unfollow: Balik ungu
                        followBtn.className = "rounded-full px-5 py-2 text-sm font-bold shadow-lg transition active:scale-95 flex items-center gap-2 bg-violet-600 text-white shadow-violet-200 hover:bg-violet-700";
                        followText.innerText = "Follow";
                        followIcon.classList.remove('hidden');
                        followerCountSpan.innerText = currentFollowers - 1; // Angka kurang 1
                        if(chatBtn) chatBtn.classList.add('hidden');
                    }
                }
            } catch (error) {
                console.error("Gagal melakukan follow:", error);
            } finally {
                followBtn.disabled = false;
            }
        }
</script>
</body>
</html>
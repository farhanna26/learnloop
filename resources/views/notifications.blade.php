<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Notifikasi | LearnLoop</title>
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
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
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
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                Search
                            </div>
                        </a>
                        <a href="/notifications" class="group flex items-center justify-between rounded-2xl bg-violet-50 px-4 py-3 text-sm font-bold text-violet-700 transition-all">
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                                Notifikasi
                            </div>
                            @php $unreadCount = auth()->user()->notifications()->where('is_read', false)->count(); @endphp
                            @if($unreadCount > 0)
                                <span class="flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-[10px] text-white">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </a>
                        <a href="/profile" class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium text-slate-600 transition-all hover:bg-slate-100 hover:text-slate-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            Profil
                        </a>
                    </nav>
                </div>
            </aside>

            <section class="lg:col-span-8 max-w-4xl space-y-6">
                <div class="relative overflow-hidden rounded-[32px] bg-white border border-slate-200 p-8 shadow-sm">
                    <h1 class="text-2xl font-extrabold text-slate-900">Pusat Notifikasi 🔔</h1>
                    <p class="text-sm text-slate-500 mt-1">Lihat siapa saja yang berinteraksi dengan karyamu.</p>
                </div>

                <div class="space-y-4">
                    @forelse($notifications as $notification)
                        <div class="card-hover flex items-center gap-4 p-5 rounded-[28px] border border-slate-200 bg-white shadow-sm animate-fade-in {{ !$notification->is_read ? 'bg-violet-50/50 border-violet-100' : '' }}">
                            <div class="relative">
                                <img src="{{ $notification->sender->photo ? asset($notification->sender->photo) : 'https://ui-avatars.com/api/?name='.urlencode($notification->sender->name).'&background=f1f5f9&color=64748b' }}" 
                                     class="h-12 w-12 rounded-full object-cover ring-2 ring-slate-50" />
                                
                                <div class="absolute -bottom-1 -right-1 flex h-6 w-6 items-center justify-center rounded-full border-2 border-white 
                                    {{ $notification->type == 'follow' ? 'bg-violet-600' : ($notification->type == 'like' ? 'bg-rose-500' : ($notification->type == 'comment' ? 'bg-blue-500' : (in_array($notification->type, ['new_assignment', 'submit_assignment']) ? 'bg-emerald-500' : 'bg-slate-800'))) }}">
                                    
                                    @if($notification->type == 'follow')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                                    @elseif($notification->type == 'like')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" /></svg>
                                    @elseif($notification->type == 'comment')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                                    @elseif(in_array($notification->type, ['new_assignment', 'submit_assignment']))
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="flex-1">
                                <p class="text-sm">
                                    <span class="font-extrabold text-slate-900">{{ $notification->sender->name }}</span> 
                                    @if($notification->type == 'follow')
                                        mulai mengikuti Anda.
                                    @elseif($notification->type == 'like')
                                        menyukai postingan Anda.
                                    @elseif($notification->type == 'comment')
                                        mengomentari postingan Anda.
                                    @elseif($notification->type == 'group_invite')
                                        mengundang mu bergabung ke grup diskusi.
                                    @elseif($notification->type == 'new_assignment')
                                        ada tugas baru: <span class="font-bold text-emerald-600">{{ $notification->reference?->title ?? 'Tugas Baru' }}</span>
                                    @elseif($notification->type == 'submit_assignment')
                                        mengumpulkan jawaban untuk tugas: <span class="font-bold text-emerald-600">{{ $notification->reference?->title ?? 'Tugas' }}</span>
                                    @endif
                                </p>
                                <p class="text-[10px] font-bold text-slate-400 mt-0.5 uppercase tracking-wider">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>

                            <div class="flex-1">
                                </div>

                            <div>
                                @if($notification->type == 'follow')
                                    <a href="/profile/{{ $notification->sender_id }}" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-50 text-slate-700 text-xs font-bold hover:bg-slate-100 transition shadow-sm">
                                        Profil
                                    </a>
                                @elseif(in_array($notification->type, ['like', 'comment']))
                                    <button onclick="openPostModal({{ $notification->reference_id }})" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-violet-50 text-violet-700 text-xs font-bold hover:bg-violet-600 hover:text-white transition shadow-sm">
                                        Lihat
                                    </button>
                                @elseif($notification->type == 'group_invite')
                                    <div class="flex items-center gap-2">
                                        <form action="/chat/group/accept/{{ $notification->id }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-4 py-2 rounded-xl bg-violet-600 text-white text-xs font-bold hover:bg-violet-700 transition shadow-sm">Terima</button>
                                        </form>
                                        <form action="/chat/group/reject/{{ $notification->id }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-600 text-xs font-bold hover:bg-slate-200 transition shadow-sm">Tolak</button>
                                        </form>
                                    </div>
                                @elseif($notification->type == 'new_assignment')
                                    <a href="/chat/{{ $notification->reference?->room_id }}" 
                                        onclick="sessionStorage.setItem('openTab', 'tugas')"
                                        class="flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-50 text-emerald-700 text-xs font-bold hover:bg-emerald-600 hover:text-white transition shadow-sm">
                                        Lihat Tugas
                                    </a>
                                @elseif($notification->type == 'submit_assignment')
                                    <a href="/chat/{{ $notification->reference?->room_id }}" 
                                        onclick="sessionStorage.setItem('openTab', 'tugas')"
                                        class="flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-50 text-emerald-700 text-xs font-bold hover:bg-emerald-600 hover:text-white transition shadow-sm">
                                        Periksa
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-20 bg-white rounded-[32px] border border-slate-200">
                            <div class="flex justify-center mb-4 text-slate-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                            </div>
                            <p class="text-slate-500 font-medium italic">Belum ada aktivitas baru nih.</p>
                        </div>
                    @endforelse
                </div>
            </section>

        </div>
    </main>

    <div id="postModal" class="fixed inset-0 z-[60] hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-opacity">
        <div class="w-full max-w-2xl bg-white rounded-[32px] shadow-2xl flex flex-col max-h-[90vh] overflow-hidden relative">
            
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50 sticky top-0 z-10">
                <h3 class="font-extrabold text-slate-900">Detail Postingan</h3>
                <button onclick="closePostModal()" class="text-slate-400 hover:bg-slate-200 hover:text-slate-600 p-2 rounded-full transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <div id="postModalContent" class="p-6 overflow-y-auto custom-scrollbar flex-1 relative">
                <div id="postModalLoading" class="flex flex-col items-center justify-center h-40">
                    <svg class="animate-spin h-8 w-8 text-violet-600 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <p class="text-sm font-bold text-slate-400 animate-pulse">Memuat postingan...</p>
                </div>
                <div id="postModalData" class="hidden space-y-6">
                    <div id="modalPostBody"></div>
                    
                    <hr class="border-slate-100">
                    
                    <div>
                        <h4 class="font-extrabold text-slate-900 mb-4">Komentar</h4>
                        <div id="modalCommentsList" class="space-y-4"></div>
                    </div>
                </div>
            </div>
            
            <div class="p-4 border-t border-slate-100 bg-white sticky bottom-0 z-10">
                <form id="modalCommentForm" onsubmit="submitModalComment(event)" class="flex items-center gap-3">
                    <input type="hidden" id="modalPostId">
                    <input type="text" id="modalCommentInput" placeholder="Tulis balasan lu..." class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 rounded-2xl px-4 py-3 text-sm outline-none transition-all" required autocomplete="off">
                    <button type="submit" class="bg-violet-600 hover:bg-violet-700 text-white rounded-2xl p-3 shadow-lg shadow-violet-200 transition-transform active:scale-95 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Logika Javascript untuk Modal Floating Postingan
        const postModal = document.getElementById('postModal');
        const modalLoading = document.getElementById('postModalLoading');
        const modalData = document.getElementById('postModalData');
        
        function openPostModal(postId) {
            postModal.classList.remove('hidden');
            modalLoading.classList.remove('hidden');
            modalData.classList.add('hidden');
            document.body.style.overflow = 'hidden'; // Kunci scroll background

            // Fetch data postingan & komentar
            fetch(`/api/posts/${postId}`) // ASUMSI RUTE INI SUDAH ADA, JIKA BELUM HARUS DIBIKIN DI CONTROLLER
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        renderModalPost(data.data);
                        modalLoading.classList.add('hidden');
                        modalData.classList.remove('hidden');
                    }
                })
                .catch(err => {
                    alert('Gagal memuat postingan');
                    closePostModal();
                });
        }

        function closePostModal() {
            postModal.classList.add('hidden');
            document.body.style.overflow = 'auto'; // Buka scroll background
        }

        function renderModalPost(post) {
            document.getElementById('modalPostId').value = post.id;
            
            // Helper 1: Bikin URL UI-Avatars
            const getFallbackAvatar = (name, bg, color) => {
                return `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=${bg}&color=${color}&bold=true`;
            };

            // Helper 2: Bikin URL Foto Asli (Udah disesuaikan dengan folder profile-photos)
            const getAvatarUrl = (photo) => {
                if (!photo) return null;
                if (photo.startsWith('http')) return photo;
                
                const cleanPhoto = photo.replace(/^\/+/, '');
                
                // Kalau disimpen di folder public (kayak profile-photos), langsung return aja pake / di depan
                if (cleanPhoto.startsWith('profile-photos')) {
                    return `/${cleanPhoto}`;
                }
                
                // Kalau disimpen di storage (kayak postingan)
                return cleanPhoto.startsWith('storage') ? `/${cleanPhoto}` : `/storage/${cleanPhoto}`;
            };

            const fallbackUser = getFallbackAvatar(post.user.name, '8b5cf6', 'ffffff');
            const userPhoto = getAvatarUrl(post.user.photo) || fallbackUser;
            
            // Render Badan Postingan (Pake atribut onerror)
            let postHtml = `
                <div class="flex items-center gap-3 mb-4">
                    <img src="${userPhoto}" onerror="this.onerror=null; this.src='${fallbackUser}';" class="h-10 w-10 rounded-full object-cover ring-2 ring-violet-50">
                    <div>
                        <p class="text-sm font-bold text-slate-900">${post.user.name}</p>
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider">Diposting sebelumnya</p>
                    </div>
                </div>
                <p class="text-sm text-slate-700 leading-relaxed mb-4">${post.content}</p>
            `;

            // Render Gambar Postingan
            if(post.image) {
                const imgPath = post.image.startsWith('storage') ? `/${post.image}` : `/storage/${post.image}`;
                postHtml += `<img src="${imgPath}" class="w-full rounded-2xl border border-slate-100 shadow-sm mb-4">`;
            }
            
            document.getElementById('modalPostBody').innerHTML = postHtml;

            // Render Komentar (Pake atribut onerror juga)
            let commentsHtml = '';
            if(post.comments && post.comments.length > 0) {
                post.comments.forEach(comment => {
                    const fallbackC = getFallbackAvatar(comment.user.name, 'f1f5f9', '64748b');
                    const cPhoto = getAvatarUrl(comment.user.photo) || fallbackC;
                    
                    commentsHtml += `
                        <div class="flex gap-3">
                            <img src="${cPhoto}" onerror="this.onerror=null; this.src='${fallbackC}';" class="h-8 w-8 rounded-full mt-1 object-cover">
                            <div class="bg-slate-50 p-3 rounded-2xl rounded-tl-sm border border-slate-100 flex-1">
                                <p class="text-xs font-bold text-slate-900 mb-1">${comment.user.name}</p>
                                <p class="text-sm text-slate-600 leading-relaxed">${comment.body}</p>
                            </div>
                        </div>
                    `;
                });
            } else {
                commentsHtml = `<p class="text-xs text-center text-slate-400 italic">Belum ada komentar.</p>`;
            }
            
            document.getElementById('modalCommentsList').innerHTML = commentsHtml;
        }

        function submitModalComment(e) {
            e.preventDefault();
            const input = document.getElementById('modalCommentInput');
            const postId = document.getElementById('modalPostId').value;
            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            if(!input.value.trim()) return;

            fetch(`/posts/${postId}/comment`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ body: input.value })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    input.value = '';
                    // Reload modal data biar komen baru muncul
                    openPostModal(postId); 
                }
            });
        }
    </script>
</body>
</html>
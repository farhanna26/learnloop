<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Notifikasi | LearnLoop</title>
    
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

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeIn 0.4s ease-out forwards; }
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
                    <div class="h-10 w-10 bg-gradient-to-br from-violet-500 to-fuchsia-500 rounded-xl flex items-center justify-center text-xl shadow-md">
                        🔔
                    </div>
                    <div>
                        <h1 class="text-base font-black text-purple-950 dark:text-white uppercase tracking-wider">Pusat Notifikasi</h1>
                        <p class="text-[9px] font-bold text-slate-400 dark:text-slate-500">Lihat siapa saja yang berinteraksi dengan karyamu.</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    <button @click="darkMode = !darkMode; localStorage.setItem('theme', darkMode ? 'dark' : 'light')" class="btn-pop-white p-2.5 rounded-xl text-xs">
                        <span x-show="!darkMode">🌙</span><span x-show="darkMode">☀️</span>
                    </button>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto p-6 space-y-3 custom-scrollbar bg-slate-50/30 dark:bg-[#0e0a2f]/20">
                
                @forelse($notifications as $notification)
                    <div class="animate-fade-in flex items-center justify-between gap-4 p-4 rounded-2xl border transition-all hover:translate-x-1
                        {{ !$notification->is_read 
                            ? 'bg-violet-50/70 border-violet-200 dark:bg-purple-950/30 dark:border-purple-800/60 shadow-sm' 
                            : 'bg-white border-slate-100 dark:bg-[#161245] dark:border-slate-800/80' 
                        }}">
                        
                        <div class="flex items-center gap-4 min-w-0 flex-1">
                            <div class="relative shrink-0">
                                <img src="{{ $notification->sender->photo ? asset($notification->sender->photo) : 'https://ui-avatars.com/api/?name='.urlencode($notification->sender->name).'&background=f1f5f9&color=64748b' }}" 
                                     class="h-11 w-11 rounded-full object-cover border border-slate-200/60 dark:border-slate-700" />
                                
                                <div class="absolute -bottom-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full border border-white dark:border-[#110d35]
                                    {{ $notification->type == 'follow' ? 'bg-violet-600' : ($notification->type == 'like' ? 'bg-rose-500' : ($notification->type == 'comment' ? 'bg-blue-500' : (in_array($notification->type, ['new_assignment', 'submit_assignment']) ? 'bg-emerald-500' : 'bg-slate-800'))) }}">
                                    
                                    @if($notification->type == 'follow')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-2.5 w-2.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                                    @elseif($notification->type == 'like')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-2.5 w-2.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" /></svg>
                                    @elseif($notification->type == 'comment')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-2.5 w-2.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                                    @elseif(in_array($notification->type, ['new_assignment', 'submit_assignment']))
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-2.5 w-2.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="min-w-0 flex-1">
                                <p class="text-xs text-slate-700 dark:text-slate-300 leading-relaxed">
                                    <span class="font-black text-purple-950 dark:text-white">{{ $notification->sender->name }}</span> 
                                    @if($notification->type == 'follow')
                                        mulai mengikuti Anda.
                                    @elseif($notification->type == 'like')
                                        menyukai postingan Anda.
                                    @elseif($notification->type == 'comment')
                                        mengomentari postingan Anda.
                                    @elseif($notification->type == 'group_invite')
                                        mengundang mu bergabung ke grup diskusi.
                                    @elseif($notification->type == 'new_assignment')
                                        ada tugas baru: <span class="font-extrabold text-emerald-600 dark:text-emerald-400">{{ $notification->reference?->title ?? 'Tugas Baru' }}</span>
                                    @elseif($notification->type == 'submit_assignment')
                                        mengumpulkan jawaban untuk tugas: <span class="font-extrabold text-emerald-600 dark:text-emerald-400">{{ $notification->reference?->title ?? 'Tugas' }}</span>
                                    @endif
                                </p>
                                <p class="text-[9px] font-bold text-slate-400 dark:text-slate-500 mt-0.5 uppercase tracking-wider">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                        </div>

                        <div class="shrink-0 pl-2">
                            @if($notification->type == 'follow')
                                <a href="/profile/{{ $notification->sender_id }}" class="px-3.5 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-[11px] font-black hover:bg-slate-200 transition shadow-sm border border-slate-200/40 dark:border-slate-700">
                                    Profil
                                </a>
                            @elseif(in_array($notification->type, ['like', 'comment']))
                                <button onclick="openPostModal({{ $notification->reference_id }})" class="px-3.5 py-1.5 rounded-xl bg-purple-50 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300 text-[11px] font-black hover:bg-purple-600 hover:text-white transition shadow-sm border border-purple-200/40 dark:border-purple-900">
                                    Lihat
                                </button>
                            @elseif($notification->type == 'group_invite')
                                <div class="flex items-center gap-1.5">
                                    <form action="/chat/group/accept/{{ $notification->id }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-purple-600 text-white text-[11px] font-black hover:bg-purple-700 transition shadow-sm">Terima</button>
                                    </form>
                                    <form action="/chat/group/reject/{{ $notification->id }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-[11px] font-black hover:bg-slate-200 transition shadow-sm">Tolak</button>
                                    </form>
                                </div>
                            @elseif($notification->type == 'new_assignment')
                                <a href="/chat/{{ $notification->reference?->room_id }}" 
                                   onclick="sessionStorage.setItem('openTab', 'tugas')"
                                   class="px-3.5 py-1.5 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 text-[11px] font-black hover:bg-emerald-600 hover:text-white transition shadow-sm border border-emerald-200/40 dark:border-emerald-900">
                                    Lihat Tugas
                                </a>
                            @elseif($notification->type == 'submit_assignment')
                                <a href="/chat/{{ $notification->reference?->room_id }}" 
                                   onclick="sessionStorage.setItem('openTab', 'tugas')"
                                   class="px-3.5 py-1.5 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 text-[11px] font-black hover:bg-emerald-600 hover:text-white transition shadow-sm border border-emerald-200/40 dark:border-emerald-900">
                                    Periksa
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20 bg-white dark:bg-[#161245] rounded-3xl border border-slate-100 dark:border-slate-800">
                        <div class="flex justify-center mb-4 text-slate-200 dark:text-slate-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                        </div>
                        <p class="text-slate-400 dark:text-slate-500 font-bold text-xs uppercase tracking-wider italic">Belum ada aktivitas baru nih.</p>
                    </div>
                @endforelse
            </div>
        </main>

    </div>

    <div id="postModal" class="fixed inset-0 z-[60] hidden flex items-center justify-center p-4 bg-slate-900/60 dark:bg-black/70 backdrop-blur-sm transition-opacity">
        <div class="w-full max-w-2xl bg-white dark:bg-[#110d35] rounded-[2.5rem] border-2 border-slate-300 dark:border-slate-800 shadow-2xl flex flex-col max-h-[85vh] overflow-hidden relative">
            
            <div class="p-5 border-b border-slate-100 dark:border-slate-800/80 flex justify-between items-center bg-slate-50/80 dark:bg-[#161245]/50 sticky top-0 z-10">
                <h3 class="font-black text-xs text-purple-950 dark:text-white uppercase tracking-widest">Detail Postingan</h3>
                <button onclick="closePostModal()" class="text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 hover:text-slate-600 dark:hover:text-slate-200 p-2 rounded-xl transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <div id="postModalContent" class="p-6 overflow-y-auto custom-scrollbar flex-1 relative bg-white dark:bg-[#110d35]">
                <div id="postModalLoading" class="flex flex-col items-center justify-center h-40">
                    <svg class="animate-spin h-7 w-7 text-purple-600 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest animate-pulse">Memuat data...</p>
                </div>
                
                <div id="postModalData" class="hidden space-y-6">
                    <div id="modalPostBody"></div>
                    <hr class="border-slate-100 dark:border-slate-800">
                    <div>
                        <h4 class="font-black text-xs text-purple-950 dark:text-white uppercase tracking-wider mb-4">Komentar</h4>
                        <div id="modalCommentsList" class="space-y-3"></div>
                    </div>
                </div>
            </div>
            
            <div class="p-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-[#161245]/20 sticky bottom-0 z-10">
                <form id="modalCommentForm" onsubmit="submitModalComment(event)" class="flex items-center gap-2.5">
                    <input type="hidden" id="modalPostId">
                    <input type="text" id="modalCommentInput" placeholder="Tulis balasan lu..." class="w-full bg-white dark:bg-[#0d0926] border border-slate-200 dark:border-slate-800 focus:border-purple-500 rounded-xl px-4 py-2.5 text-xs outline-none text-slate-800 dark:text-slate-100 transition-all" required autocomplete="off">
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white rounded-xl p-2.5 shadow-md shrink-0 transition-transform active:scale-95">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const postModal = document.getElementById('postModal');
        const modalLoading = document.getElementById('postModalLoading');
        const modalData = document.getElementById('postModalData');
        
        function openPostModal(postId) {
            postModal.classList.remove('hidden');
            modalLoading.classList.remove('hidden');
            modalData.classList.add('hidden');
            document.body.style.overflow = 'hidden';

            fetch(`/api/posts/${postId}`)
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
            document.body.style.overflow = 'auto';
        }

        function renderModalPost(post) {
            document.getElementById('modalPostId').value = post.id;
            
            const getFallbackAvatar = (name, bg, color) => {
                return `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=${bg}&color=${color}&bold=true`;
            };

            const getAvatarUrl = (photo) => {
                if (!photo) return null;
                if (photo.startsWith('http')) return photo;
                
                const cleanPhoto = photo.replace(/^\/+/, '');
                if (cleanPhoto.startsWith('profile-photos')) {
                    return `/${cleanPhoto}`;
                }
                return cleanPhoto.startsWith('storage') ? `/${cleanPhoto}` : `/storage/${cleanPhoto}`;
            };

            const fallbackUser = getFallbackAvatar(post.user.name, '8b5cf6', 'ffffff');
            const userPhoto = getAvatarUrl(post.user.photo) || fallbackUser;
            
            let postHtml = `
                <div class="flex items-center gap-3 mb-4">
                    <img src="${userPhoto}" onerror="this.onerror=null; this.src='${fallbackUser}';" class="h-9 w-9 rounded-full object-cover border border-purple-100 dark:border-purple-900">
                    <div>
                        <p class="text-xs font-black text-purple-950 dark:text-white">${post.user.name}</p>
                        <p class="text-[9px] text-slate-400 dark:text-slate-500 uppercase tracking-wider">Diposting sebelumnya</p>
                    </div>
                </div>
                <p class="text-xs text-slate-700 dark:text-slate-300 leading-relaxed mb-4">${post.content}</p>
            `;

            if(post.image) {
                const imgPath = post.image.startsWith('storage') ? `/${post.image}` : `/storage/${post.image}`;
                postHtml += `<img src="${imgPath}" class="w-full rounded-2xl border border-slate-100 dark:border-slate-800/80 shadow-sm mb-4">`;
            }
            
            document.getElementById('modalPostBody').innerHTML = postHtml;

            let commentsHtml = '';
            if(post.comments && post.comments.length > 0) {
                post.comments.forEach(comment => {
                    const fallbackC = getFallbackAvatar(comment.user.name, '8b5cf6', 'ffffff');
                    const cPhoto = getAvatarUrl(comment.user.photo) || fallbackC;
                    
                    commentsHtml += `
                        <div class="flex gap-3">
                            <img src="${cPhoto}" onerror="this.onerror=null; this.src='${fallbackC}';" class="h-8 w-8 rounded-full mt-0.5 object-cover shrink-0">
                            <div class="bg-slate-50 dark:bg-[#161245] p-3 rounded-2xl rounded-tl-none border border-slate-100 dark:border-slate-800/60 flex-1">
                                <p class="text-[11px] font-black text-purple-950 dark:text-slate-200 mb-0.5">${comment.user.name}</p>
                                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">${comment.body}</p>
                            </div>
                        </div>
                    `;
                });
            } else {
                commentsHtml = `<p class="text-[11px] text-center text-slate-400 dark:text-slate-500 font-bold italic py-4">Belum ada komentar.</p>`;
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
                    openPostModal(postId); 
                }
            });
        }
    </script>
</body>
</html>
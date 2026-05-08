<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LearnLoop | Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #ffffff; color: #1f2937; }
        .glass-nav { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border-right: 1px solid #f3f4f6; }
        .nav-item:hover { background-color: #f5f3ff; color: #a855f7; }
        .active-nav { background-color: #f5f3ff; color: #a855f7; font-weight: 700; }
        .text-aesthetic { color: #a855f7; }
        .bg-aesthetic { background-color: #f5f3ff; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="flex">

    <aside class="w-20 md:w-64 h-screen sticky top-0 glass-nav flex flex-col p-4 z-50">
        <div class="px-4 py-10 mb-6">
            <h1 class="text-2xl font-black text-aesthetic hidden md:block tracking-tighter">LearnLoop.</h1>
            <div class="md:hidden w-10 h-10 bg-aesthetic rounded-xl flex items-center justify-center text-aesthetic font-bold">LL</div>
        </div>

        <nav class="flex-1 space-y-2">
            <a href="/home" class="flex items-center gap-4 p-4 rounded-2xl active-nav transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span class="hidden md:block text-sm">Beranda</span>
            </a>
            
            <button onclick="openUploadModal()" class="flex items-center gap-4 p-4 rounded-2xl nav-item transition-all text-gray-500 w-full text-left">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M12 8v8"/><path d="M8 12h8"/></svg>
                <span class="hidden md:block text-sm">Upload Konten</span>
            </button>

            <a href="#" class="flex items-center gap-4 p-4 rounded-2xl nav-item transition-all text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span class="hidden md:block text-sm">Profil Saya</span>
            </a>
        </nav>

        <div class="mt-auto p-4 border-t border-gray-50">
            <a href="/auth" class="text-gray-400 text-sm font-bold hover:text-red-400 transition flex items-center gap-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                <span class="hidden md:block">Keluar</span>
            </a>
        </div>
    </aside>

    <main class="flex-1 bg-white min-h-screen">
    <div class="max-w-2xl mx-auto py-10 px-4">
        
        <div class="flex gap-4 mb-12 overflow-x-auto pb-4 no-scrollbar">
            @for ($i = 1; $i <= 6; $i++)
            <div class="flex-shrink-0 flex flex-col items-center gap-2">
                <div class="w-16 h-16 rounded-full p-[2px] border-2 border-purple-200 shadow-sm">
                    <img src="https://ui-avatars.com/api/?name=User+{{$i}}&background=f5f3ff&color=a855f7" class="rounded-full w-full h-full object-cover">
                </div>
                <span class="text-[10px] font-semibold text-gray-400">teman_{{$i}}</span>
            </div>
            @endfor
        </div>

        <div class="space-y-16">
            @forelse($posts as $post)
                <article class="bg-white">
                    @php
                        // Karena di DB kamu tidak ada mime_type, kita cek manual lewat akhiran file
                        $isPDF = str_ends_with($post->image, '.pdf');
                        $isVideo = str_ends_with($post->image, '.mp4') || str_ends_with($post->image, '.mov');
                    @endphp

                    @if($isPDF)
                        <div class="mb-4">
                            <h4 class="font-bold text-aesthetic text-lg tracking-tight uppercase">{{ $post->content ?? 'Modul Kuliah.pdf' }}</h4>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Document • PDF</p>
                        </div>
                        <div class="aspect-[4/3] rounded-3xl bg-aesthetic border border-purple-50 flex flex-col items-center justify-center gap-4 shadow-sm">
                            <div class="text-5xl">📄</div>
                            <a href="{{ asset('storage/' . $post->image) }}" target="_blank" class="bg-white px-6 py-2 rounded-xl text-xs font-bold text-aesthetic shadow-sm border border-purple-100 hover:bg-purple-50 transition">Buka Dokumen</a>
                        </div>
                    @else
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-9 h-9 rounded-full bg-aesthetic flex items-center justify-center text-aesthetic font-bold text-xs border border-purple-100">YN</div>
                            <h4 class="font-bold text-sm">yazanz_</h4>
                        </div>
                        <div class="aspect-square rounded-3xl bg-aesthetic border border-purple-50 overflow-hidden shadow-sm">
                            @if($isVideo)
                                <video src="{{ asset('storage/' . $post->image) }}" controls class="w-full h-full object-cover"></video>
                            @else
                                <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        
                        @if($post->content)
                        <div class="mt-4 px-1">
                            <p class="text-sm"><span class="font-bold">yazanz_</span> {{ $post->content }}</p>
                        </div>
                        @endif
                    @endif

                    <div class="mt-5 px-1 flex gap-6">
                        <button class="text-aesthetic hover:scale-110 transition"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg></button>
                        <button class="text-gray-400 hover:text-aesthetic transition"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></button>
                    </div>
                </article>
            @empty
                <div class="text-center py-20 bg-aesthetic rounded-[32px] border-2 border-dashed border-purple-100">
                    <p class="text-gray-400 font-bold">Belum ada konten yang diupload.</p>
                    <button onclick="openUploadModal()" class="mt-4 text-aesthetic font-bold underline">Mulai Upload Pertama Kamu!</button>
                </div>
            @endforelse
        </div>
    </div>
</main>

    <div id="uploadModal" class="fixed inset-0 z-[100] hidden bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-[32px] overflow-hidden shadow-2xl">
            <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                <h3 class="font-bold text-lg">Buat Postingan Baru</h3>
                <button onclick="closeUploadModal()" class="text-gray-400 hover:text-gray-600 font-bold">✕</button>
            </div>
            
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <div class="border-2 border-dashed border-purple-100 rounded-2xl p-8 text-center bg-aesthetic">
                    <input type="file" name="file" id="fileInput" class="hidden" accept="image/*,video/*,.pdf" required onchange="updateFileName()">
                    <label for="fileInput" class="cursor-pointer">
                        <div class="text-4xl mb-2">📁</div>
                        <p class="text-xs font-bold text-aesthetic" id="fileNameDisplay">Pilih Gambar, Video, atau PDF</p>
                    </label>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 mb-2 uppercase tracking-widest">Judul atau Caption</label>
                    <textarea name="caption" class="w-full bg-gray-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-purple-200 outline-none" rows="3" placeholder="Tulis deskripsi konten kamu..."></textarea>
                </div>

                <button type="submit" class="w-full bg-[#a855f7] text-white py-4 rounded-2xl font-bold hover:bg-[#9333ea] transition-all shadow-lg shadow-purple-100">
                    Posting Sekarang
                </button>
            </form>
        </div>
    </div>

    <script>
        function openUploadModal() { document.getElementById('uploadModal').classList.remove('hidden'); }
        function closeUploadModal() { document.getElementById('uploadModal').classList.add('hidden'); }
        function updateFileName() {
            const input = document.getElementById('fileInput');
            if (input.files.length > 0) {
                document.getElementById('fileNameDisplay').innerText = input.files[0].name;
            }
        }
    </script>
</body>
</html>
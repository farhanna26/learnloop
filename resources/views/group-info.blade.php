<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Grup | LearnLoop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .glass-effect { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="flex flex-col items-center min-h-screen py-10 px-4">

    <div class="w-full max-w-3xl bg-white rounded-[32px] border border-slate-200 shadow-2xl overflow-hidden">
        
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <div class="flex items-center gap-4">
                <a href="/chat/{{ $room->id }}" class="flex h-10 w-10 items-center justify-center rounded-full bg-white border border-slate-200 text-slate-500 hover:text-violet-600 shadow-sm transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                </a>
                <div>
                    <h1 class="text-xl font-extrabold text-slate-900">Info Grup</h1>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ $room->users->count() }} Anggota</p>
                </div>
            </div>
        </div>

        <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-10">
            
            <div>
                <h2 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider mb-6">Pengaturan Grup</h2>
                
                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-50 text-emerald-600 text-sm font-bold rounded-2xl border border-emerald-100">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('chat.group.update', $room->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div class="flex flex-col items-center mb-6">
                        <div class="relative h-28 w-28 rounded-3xl bg-slate-100 border-2 border-dashed border-slate-300 group overflow-hidden shadow-sm">
                            <img id="photo-preview" src="{{ $room->photo ? asset('storage/'.$room->photo) : 'https://ui-avatars.com/api/?name='.urlencode($room->name).'&background=8b5cf6&color=ffffff' }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 flex items-center justify-center bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-all cursor-pointer">
                                <label for="photo" class="cursor-pointer text-white flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    <span class="text-[10px] font-bold">Ubah</span>
                                </label>
                            </div>
                            <input type="file" name="photo" id="photo" class="hidden" accept="image/*" onchange="previewImage(this, 'photo-preview')">
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase ml-1">Nama Grup</label>
                            <input type="text" name="name" value="{{ $room->name }}" class="w-full mt-1 bg-slate-50 border border-slate-200 focus:bg-white focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 rounded-2xl px-4 py-3 text-sm font-bold outline-none transition-all" required>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase ml-1">Deskripsi Grup</label>
                            <textarea name="description" rows="3" class="w-full mt-1 bg-slate-50 border border-slate-200 focus:bg-white focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 rounded-2xl px-4 py-3 text-sm outline-none transition-all" placeholder="Misal: Grup khusus ngebahas tugas Web...">{{ $room->description }}</textarea>
                        </div>
                    </div>

                    <button type="submit" class="w-full rounded-2xl bg-slate-900 py-3.5 text-sm font-bold text-white shadow-lg hover:bg-violet-600 transition-colors active:scale-95">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

            <div class="border-t md:border-t-0 md:border-l border-slate-100 pt-8 md:pt-0 md:pl-10 flex flex-col h-full">
                
                <h2 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider mb-4">Daftar Anggota</h2>
                <div class="max-h-48 overflow-y-auto custom-scrollbar pr-2 mb-8 space-y-3">
                    @foreach($room->users as $member)
                        <div class="flex items-center justify-between p-3 rounded-2xl border border-slate-100 bg-slate-50">
                            <div class="flex items-center gap-3">
                                <img src="{{ $member->photo ? asset($member->photo) : 'https://ui-avatars.com/api/?name='.urlencode($member->name).'&background=f1f5f9&color=64748b' }}" class="w-10 h-10 rounded-full object-cover shadow-sm">
                                <div>
                                    <p class="text-sm font-bold text-slate-900">{{ $member->name }}</p>
                                    @if($member->id === Auth::id())
                                        <p class="text-[10px] font-bold text-violet-600 uppercase tracking-widest">Anda</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-auto">
                    <h2 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider mb-4 border-t border-slate-100 pt-6">Tambah Anggota (Mutuals)</h2>
                    
                    <form action="{{ route('chat.group.invite', $room->id) }}" method="POST">
                        @csrf
                        <div class="max-h-40 overflow-y-auto custom-scrollbar pr-2 space-y-2 mb-4">
                            @forelse($invitableMutuals as $mutual)
                                <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 hover:bg-violet-50 hover:border-violet-200 cursor-pointer transition-all">
                                    <input type="checkbox" name="members[]" value="{{ $mutual->id }}" class="w-4 h-4 text-violet-600 rounded focus:ring-violet-500">
                                    <img src="{{ $mutual->photo ? asset($mutual->photo) : 'https://ui-avatars.com/api/?name='.urlencode($mutual->name).'&background=f1f5f9&color=64748b' }}" class="w-8 h-8 rounded-full object-cover">
                                    <span class="text-sm font-bold text-slate-800">{{ $mutual->name }}</span>
                                </label>
                            @empty
                                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 text-center">
                                    <p class="text-xs text-slate-500 font-medium">Semua mutual lu udah masuk grup ini, atau lu belum punya mutual baru.</p>
                                </div>
                            @endforelse
                        </div>
                        
                        @if($invitableMutuals->count() > 0)
                            <button type="submit" class="w-full rounded-2xl bg-violet-100 text-violet-700 py-3.5 text-sm font-bold shadow-sm hover:bg-violet-600 hover:text-white transition-colors active:scale-95">
                                Kirim Undangan Baru
                            </button>
                        @endif
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            const file = input.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>
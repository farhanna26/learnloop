<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil | LearnLoop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .glass-effect { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-2xl bg-white rounded-[32px] border border-slate-200 shadow-2xl overflow-hidden animate-fade-in">
        <div class="p-8 border-b border-slate-100 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900">Edit Profil</h1>
                <p class="text-sm text-slate-500">Sesuaikan tampilan profil LearnLoop-mu</p>
            </div>
            <a href="/profile" class="text-sm font-bold text-slate-400 hover:text-violet-600 transition">Batal</a>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
                @if ($errors->any())
            <div class="mb-6 rounded-2xl bg-red-50 p-4 border border-red-100">
                <ul class="text-sm font-bold text-red-500 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>🚨 {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif    
        @csrf
            
            <div class="space-y-3">
                <label class="text-sm font-bold text-slate-700 ml-1">Banner Profil (Header)</label>
                <div class="relative h-40 w-full rounded-3xl bg-slate-100 border-2 border-dashed border-slate-200 overflow-hidden group">
                    <img id="banner-preview" src="{{ $user->banner ? asset($user->banner) : '' }}" class="w-full h-full object-cover {{ $user->banner ? '' : 'hidden' }}">
                    <div class="absolute inset-0 flex flex-col items-center justify-center bg-slate-900/20 group-hover:bg-slate-900/40 transition-all">
                        <label for="banner" class="cursor-pointer bg-white/90 px-4 py-2 rounded-xl text-xs font-bold shadow-lg hover:scale-105 transition-transform">Ganti Banner</label>
                    </div>
                    <input type="file" name="banner" id="banner" class="hidden" accept="image/*" onchange="previewImage(this, 'banner-preview')">
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-8">
                <div class="space-y-3">
                    <label class="text-sm font-bold text-slate-700 ml-1">Foto Profil</label>
                    <div class="relative h-32 w-32 rounded-full bg-slate-100 border-2 border-dashed border-slate-200 group overflow-hidden">
                        <img id="photo-preview" src="{{ $user->photo ? asset($user->photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 flex items-center justify-center bg-slate-900/20 opacity-0 group-hover:opacity-100 transition-all">
                            <label for="photo" class="cursor-pointer p-2 bg-white rounded-full shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </label>
                        </div>
                        <input type="file" name="photo" id="photo" class="hidden" accept="image/*" onchange="previewImage(this, 'photo-preview')">
                    </div>
                </div>

                <div class="flex-1 space-y-3">
                    <label class="text-sm font-bold text-slate-700 ml-1">Deskripsi Diri (Bio)</label>
                    <textarea name="description" rows="4" class="w-full rounded-3xl border border-slate-200 bg-slate-50 p-5 text-sm outline-none focus:bg-white focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all" placeholder="Contoh: Mahasiswa Teknik Informatika yang suka main Valorant...">{{ $user->description }}</textarea>
                </div>
            </div>

            <button type="submit" class="w-full rounded-2xl bg-violet-600 py-4 text-sm font-extrabold text-white shadow-xl shadow-violet-200 hover:bg-violet-700 hover:-translate-y-1 transition-all active:scale-95">
                Simpan Perubahan Profil
            </button>
        </form>
    </div>

    <script>
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            const file = input.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>
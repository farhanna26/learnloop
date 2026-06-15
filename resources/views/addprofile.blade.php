@php
    $user = Auth::user();
@endphp

<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Profil | LearnLoop</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght=500;600;700;800&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: { 
                        brand: '#7c3aed',
                        brandPastel: '#9333ea',
                        lightBg: '#f0f2fe',
                        darkBg: '#090616'
                    }
                }
            }
        }
    </script>

    <style>
        /* --- HIGH-CONTRAST 3D SOLID BLOK STYLE --- */
        .card-main {
            background: #ffffff;
            border-radius: 2.5rem;
            border: 2px solid #e2e8f0;
            box-shadow: 0px 14px 0px #cbd5e1;
            transition: all 0.2s ease-in-out;
        }

        .btn-pop-purple {
            background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
            border: 2px solid #4c1d95;
            box-shadow: 0px 6px 0px #4c1d95;
            transition: all 0.15s ease;
        }
        .btn-pop-purple:active {
            transform: translateY(6px);
            box-shadow: 0px 0px 0px #4c1d95;
        }

        .btn-pop-white {
            background: #ffffff;
            border: 2px solid #cbd5e1;
            box-shadow: 0px 4px 0px #cbd5e1;
            transition: all 0.15s ease;
        }
        .btn-pop-white:active {
            transform: translateY(4px);
            box-shadow: 0px 0px 0px #cbd5e1;
        }

        .custom-input {
            background: #ffffff;
            border: 2px solid #cbd5e1;
            border-radius: 1.5rem;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.06);
            transition: all 0.2s ease;
        }
        .custom-input:focus {
            border-color: #8b5cf6;
            box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.15);
        }

        /* --- DARK MODE ADJUSTMENT --- */
        .dark .card-main {
            background: #161245;
            border: 2px solid #2e2773;
            box-shadow: 0px 14px 0px #0d0a2d;
        }
        .dark .btn-pop-white {
            background: #161245;
            border: 2px solid #2e2773;
            box-shadow: 0px 4px 0px #0d0a2d;
            color: white;
        }
        .dark .custom-input {
            background: #0d0926;
            border: 2px solid #2e2773;
            color: #ffffff;
        }
        .dark .custom-input:focus {
            border-color: #a78bfa;
        }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    </style>
</head>
<body class="min-h-screen bg-[#f0f2fe] dark:bg-[#060412] text-[#1e1b4b] dark:text-[#f3f1fa] antialiased font-sans p-4 md:p-8 flex flex-col items-center justify-center transition-colors duration-300">

    <div class="w-full max-w-2xl card-main p-6 md:p-8 animate-fade-in relative my-6">
        
        <div class="pb-6 border-b-2 border-dashed border-slate-200 dark:border-slate-800 flex justify-between items-center">
            <div>
                <span class="bg-yellow-400 text-purple-950 text-[9px] font-black px-2.5 py-1 rounded-full uppercase tracking-widest shadow-sm">Pengaturan Akun</span>
                <h1 class="text-xl md:text-2xl font-black tracking-tight mt-1">Edit Profil</h1>
                <p class="text-xs text-slate-400 dark:text-purple-300/60 font-bold">Sesuaikan identitas digital mahasiswa Anda di LearnLoop</p>
            </div>
            
            <div>
                <a href="/profile" class="btn-pop-white px-4 py-2.5 rounded-xl text-xs font-black text-rose-500 uppercase tracking-wider">Batal</a>
            </div>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-6">
            @csrf
            
            @if ($errors->any())
                <div class="rounded-2xl bg-red-50 dark:bg-red-950/20 p-4 border-2 border-red-200 dark:border-red-900/50">
                    <ul class="text-xs font-black text-red-500 space-y-1.5">
                        @foreach ($errors->all() as $error)
                            <li>🚨 {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="space-y-2">
                <label class="text-xs font-black uppercase tracking-wider text-purple-950/60 dark:text-purple-300/60 ml-1">Banner Profil (Header)</label>
                <div class="relative h-40 w-full rounded-3xl bg-slate-100 dark:bg-[#0d0926] border-2 border-dashed border-slate-300 dark:border-purple-900/60 overflow-hidden group shadow-inner">
                    <img id="banner-preview" src="{{ $user->banner ? asset($user->banner) : '' }}" class="w-full h-full object-cover {{ $user->banner ? '' : 'hidden' }}" style="object-position: {{ $user->banner_x ?? 50 }}% {{ $user->banner_y ?? 50 }}%;">
                    <div class="absolute inset-0 flex flex-col items-center justify-center bg-purple-950/20 group-hover:bg-purple-950/40 transition-all">
                        <label for="banner" class="cursor-pointer bg-white dark:bg-[#161245] border-2 border-slate-300 dark:border-purple-800 text-purple-950 dark:text-white px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider shadow-md hover:scale-105 transition-transform">Ganti Banner</label>
                    </div>
                    <input type="file" name="banner" id="banner" class="hidden" accept="image/*" onchange="previewImage(this, 'banner-preview', 'banner-controls')">
                </div>
                
                <div id="banner-controls" class="{{ $user->banner ? '' : 'hidden' }} p-3 bg-slate-50 dark:bg-[#0c0926] rounded-2xl border border-slate-200 dark:border-purple-900/40 space-y-2 mt-2">
                    <span class="text-[10px] font-black uppercase tracking-wider text-purple-600 block">📐 Sesuaikan Posisi Banner</span>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] font-bold text-slate-400">Kiri/Kanan:</span>
                            <input type="range" name="banner_x" id="banner_x" min="0" max="100" value="{{ $user->banner_x ?? 50 }}" class="w-full h-1.5 bg-slate-200 dark:bg-purple-950 rounded-lg appearance-none cursor-pointer accent-purple-600" oninput="adjustPosition('banner-preview', 'x', this.value)">
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] font-bold text-slate-400">Atas/Bawah:</span>
                            <input type="range" name="banner_y" id="banner_y" min="0" max="100" value="{{ $user->banner_y ?? 50 }}" class="w-full h-1.5 bg-slate-200 dark:bg-purple-950 rounded-lg appearance-none cursor-pointer accent-purple-600" oninput="adjustPosition('banner-preview', 'y', this.value)">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-6">
                <div class="space-y-2 flex flex-col items-center md:items-start shrink-0">
                    <label class="text-xs font-black uppercase tracking-wider text-purple-950/60 dark:text-purple-300/60 ml-1">Foto Profil</label>
                    <div class="relative h-32 w-32 rounded-2xl bg-slate-100 dark:bg-[#0d0926] border-2 border-dashed border-slate-300 dark:border-purple-900/60 group overflow-hidden shadow-inner">
                        <img id="photo-preview" src="{{ $user->photo ? asset($user->photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=8b5cf6&color=ffffff' }}" class="w-full h-full object-cover" style="object-position: {{ $user->photo_x ?? 50 }}% {{ $user->photo_y ?? 50 }}%;">
                        <div class="absolute inset-0 flex items-center justify-center bg-purple-950/40 opacity-0 group-hover:opacity-100 transition-all">
                            <label for="photo" class="cursor-pointer p-3 bg-white dark:bg-[#161245] rounded-xl border-2 border-slate-200 dark:border-purple-800 shadow-lg transform hover:scale-110 transition-transform">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600 dark:text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </label>
                        </div>
                        <input type="file" name="photo" id="photo" class="hidden" accept="image/*" onchange="previewImage(this, 'photo-preview', 'photo-controls')">
                    </div>

                    <div id="photo-controls" class="w-32 p-2 bg-slate-50 dark:bg-[#0c0926] rounded-xl border border-slate-200 dark:border-purple-900/40 space-y-1.5 mt-1">
                        <div class="flex flex-col gap-1">
                            <span class="text-[8px] font-bold text-slate-400">↔ Kiri/Kanan:</span>
                            <input type="range" name="photo_x" id="photo_x" min="0" max="100" value="{{ $user->photo_x ?? 50 }}" class="w-full h-1 bg-slate-200 dark:bg-purple-950 rounded-lg appearance-none cursor-pointer accent-purple-600" oninput="adjustPosition('photo-preview', 'x', this.value)">
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-[8px] font-bold text-slate-400">↕ Atas/Bawah:</span>
                            <input type="range" name="photo_y" id="photo_y" min="0" max="100" value="{{ $user->photo_y ?? 50 }}" class="w-full h-1 bg-slate-200 dark:bg-purple-950 rounded-lg appearance-none cursor-pointer accent-purple-600" oninput="adjustPosition('photo-preview', 'y', this.value)">
                        </div>
                    </div>
                </div>

                <div class="flex-1 space-y-2">
                    <label class="text-xs font-black uppercase tracking-wider text-purple-950/60 dark:text-purple-300/60 ml-1">Deskripsi Diri (Bio)</label>
                    <textarea name="description" rows="5" class="w-full custom-input p-4 text-xs font-bold focus:outline-none resize-none leading-relaxed" placeholder="Tulis bio kamu disini...">{{ $user->description }}</textarea>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                <div class="space-y-2">
                    <label class="text-xs font-black uppercase tracking-wider text-purple-950/60 dark:text-purple-300/60 ml-1">
                        🔗 Profil LinkedIn <span class="text-[10px] text-slate-400 lowercase italic">(opsional)</span>
                    </label>
                    <input type="url" name="linkedin" value="{{ $user->linkedin ?? '' }}" 
                           class="w-full custom-input px-4 py-3.5 text-xs font-bold focus:outline-none" 
                           placeholder="https://linkedin.com/in/username">
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-black uppercase tracking-wider text-purple-950/60 dark:text-purple-300/60 ml-1">
                        💼 Link Portofolio <span class="text-[10px] text-slate-400 lowercase italic">(opsional)</span>
                    </label>
                    <input type="url" name="portfolio" value="{{ $user->portfolio ?? '' }}" 
                           class="w-full custom-input px-4 py-3.5 text-xs font-bold focus:outline-none" 
                           placeholder="https://portfolio-kamu.com">
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full rounded-2xl btn-pop-purple py-4 text-xs font-black uppercase tracking-widest text-white">
                    💾 Simpan Perubahan Profil
                </button>
            </div>
        </form>
    </div>

    <script>
        // Simpan nilai koordinat x dan y sementara di memory browser
        const positions = {
            'banner-preview': { x: {{ $user->banner_x ?? 50 }}, y: {{ $user->banner_y ?? 50 }} },
            'photo-preview': { x: {{ $user->photo_x ?? 50 }}, y: {{ $user->photo_y ?? 50 }} }
        };

        function previewImage(input, previewId, controlId) {
            const preview = document.getElementById(previewId);
            const controls = document.getElementById(controlId);
            const file = input.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if(controls) controls.classList.remove('hidden');
            }
            if (file) { reader.readAsDataURL(file); }
        }

        function adjustPosition(previewId, axis, value) {
            const preview = document.getElementById(previewId);
            
            // Perbarui data koordinat aksis aktif
            positions[previewId][axis] = value;
            
            // Aplikasikan langsung ke CSS object-position gambar
            preview.style.objectPosition = `${positions[previewId].x}% ${positions[previewId].y}%`;
        }
    </script>
</body>
</html>
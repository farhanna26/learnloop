<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda LearnLoop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</n    </style>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
    <div class="min-h-screen">
        <header class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 backdrop-blur-sm">
            <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4 sm:px-6">
                <div class="flex items-center gap-4">
                    <a href="/beranda" class="text-xl font-black tracking-tight text-slate-900">LearnLoop</a>
                    <div class="hidden md:flex items-center gap-3 rounded-full border border-slate-200 bg-slate-50 px-4 py-2 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="search" placeholder="Cari konten atau teman" class="w-72 bg-transparent text-sm text-slate-700 outline-none placeholder:text-slate-400" />
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="/chat" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:bg-slate-50" title="Direct Message">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    </a>
                    <button class="inline-flex h-11 items-center justify-center rounded-2xl bg-violet-600 px-4 text-sm font-semibold text-white shadow-lg shadow-violet-200/50 transition hover:bg-violet-700" title="Upload Konten">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 5v14m7-7H5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Upload
                    </button>
                    <a href="#" class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-slate-200 bg-white shadow-sm transition hover:bg-slate-50" title="Profil">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=8b5cf6&color=ffffff&rounded=true" alt="Profil" class="h-9 w-9 rounded-full object-cover" />
                    </a>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-6xl px-4 py-6 pb-24 sm:px-6">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-start">
                <section class="w-full lg:w-[66%] space-y-6">
                    <div class="rounded-[32px] border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm uppercase tracking-[0.35em] text-slate-400">Selamat datang</p>
                                <h1 class="mt-2 text-3xl font-bold text-slate-950">Halo, {{ Auth::user()->name }}.</h1>
                                <p class="mt-3 text-sm leading-6 text-slate-600">Beranda LearnLoop menampilkan konten terbaru dari teman dan komunitasmu. Temukan inspirasi, unggah post, dan terhubung melalui pesan.</p>
                            </div>
                            <div class="rounded-3xl bg-slate-50 p-4 text-center shadow-sm">
                                <p class="text-sm text-slate-500">Postingan</p>
                                <p class="mt-2 text-3xl font-bold text-slate-900">12</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        @foreach ([
                            ['name' => 'Nina &ndash; @nina_kuliah', 'caption' => 'Modul Praktikum AI terbaru sudah siap! 📚✨', 'image' => 'https://images.unsplash.com/photo-1517430816045-df4b7de5008e?auto=format&fit=crop&w=900&q=80'],
                            ['name' => 'Andi &ndash; @andi.study', 'caption' => 'Ringkasan algoritma graf yang gampang dimengerti.', 'image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=900&q=80'],
                            ['name' => 'Rina &ndash; @rina_creates', 'caption' => 'Berbagi catatan QC untuk kamu yang lagi UAS.', 'image' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=900&q=80'],
                        ] as $post)
                            <article class="overflow-hidden rounded-[32px] border border-slate-200 bg-white shadow-sm">
                                <div class="flex items-center justify-between gap-3 p-4">
                                    <div class="flex items-center gap-3">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode(strip_tags($post['name'])) }}&background=7c3aed&color=ffffff&rounded=true" alt="Avatar" class="h-12 w-12 rounded-full object-cover" />
                                        <div>
                                            <p class="text-sm font-semibold text-slate-900">{!! $post['name'] !!}</p>
                                            <p class="text-xs text-slate-500">2 jam lalu</p>
                                        </div>
                                    </div>
                                    <button class="rounded-full border border-slate-200 bg-slate-50 px-3 py-2 text-xs font-semibold text-slate-600 transition hover:bg-slate-100">Ikuti</button>
                                </div>

                                <div class="h-[420px] overflow-hidden bg-slate-200">
                                    <img src="{{ $post['image'] }}" alt="Konten" class="h-full w-full object-cover transition duration-500 hover:scale-105" />
                                </div>

                                <div class="space-y-4 p-4">
                                    <div class="flex items-center justify-between text-slate-700">
                                        <div class="flex items-center gap-4">
                                            <button class="inline-flex items-center gap-2 text-sm font-semibold text-slate-800 transition hover:text-violet-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                                                Suka
                                            </button>
                                            <button class="inline-flex items-center gap-2 text-sm text-slate-500 transition hover:text-slate-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                                Komentar
                                            </button>
                                        </div>
                                        <button class="inline-flex items-center gap-2 text-sm text-slate-500 transition hover:text-slate-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 12h16M4 6h16M4 18h16"/></svg>
                                            Simpan
                                        </button>
                                    </div>

                                    <div class="rounded-3xl bg-slate-50 p-4 text-sm text-slate-600">
                                        <p class="font-medium text-slate-900">Caption</p>
                                        <p class="mt-2 leading-7">{{ $post['caption'] }}</p>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>

                <aside class="w-full lg:w-[34%] space-y-6">
                    <div class="rounded-[32px] border border-slate-200 bg-white p-5 shadow-sm">
                        <div class="flex items-center gap-4">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=8b5cf6&color=ffffff&rounded=true" alt="Avatar" class="h-14 w-14 rounded-full object-cover" />
                            <div>
                                <p class="text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</p>
                                <p class="text-sm text-slate-500">@{{ strtolower(str_replace(' ', '', Auth::user()->name)) }}</p>
                            </div>
                        </div>
                        <div class="mt-6 grid gap-3">
                            <a href="/chat" class="rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">Buka Pesan</a>
                            <a href="{{ route('login') }}" class="rounded-3xl bg-violet-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-violet-700">Logout / Login lain</a>
                        </div>
                    </div>

                    <div class="rounded-[32px] border border-slate-200 bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-slate-900">Rekomendasi Konten</p>
                                <p class="mt-1 text-xs text-slate-500">Untukmu berdasarkan aktivitas belajar</p>
                            </div>
                            <span class="rounded-full bg-violet-100 px-3 py-1 text-xs font-semibold text-violet-700">Baru</span>
                        </div>
                        <div class="mt-5 space-y-4">
                            @foreach (['Design Sprint', 'Statistika', 'Coding Challenge'] as $topic)
                                <div class="rounded-3xl border border-slate-100 bg-slate-50 p-4 text-sm text-slate-600">📌 {{ $topic }}</div>
                            @endforeach
                        </div>
                    </div>
                </aside>
            </div>
        </main>

        <nav class="fixed bottom-0 left-0 right-0 z-40 border-t border-slate-200 bg-white/95 px-6 py-3 shadow-[0_-4px_30px_rgba(15,23,42,0.05)] lg:hidden">
            <div class="mx-auto flex max-w-6xl items-center justify-between">
                <a href="/beranda" class="inline-flex flex-col items-center gap-1 text-slate-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 9.75L12 4l9 5.75v9.5a.75.75 0 0 1-.75.75H3.75A.75.75 0 0 1 3 19.25v-9.5z"/></svg>
                    <span class="text-[10px]">Beranda</span>
                </a>
                <a href="#" class="inline-flex flex-col items-center gap-1 text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M10.5 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0zM3.75 20.25a3.75 3.75 0 0 1 3.75-3.75h9a3.75 3.75 0 0 1 3.75 3.75"/></svg>
                    <span class="text-[10px]">Search</span>
                </a>
                <a href="#" class="inline-flex flex-col items-center gap-1 text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 5v14m7-7H5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span class="text-[10px]">Upload</span>
                </a>
                <a href="/chat" class="inline-flex flex-col items-center gap-1 text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    <span class="text-[10px]">DM</span>
                </a>
                <a href="#" class="inline-flex flex-col items-center gap-1 text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm0 2c-5.33 0-8 2.69-8 4v1h16v-1c0-1.31-2.67-4-8-4z"/></svg>
                    <span class="text-[10px]">Profile</span>
                </a>
            </div>
        </nav>
    </div>
</body>
</html>

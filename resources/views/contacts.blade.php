<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan | LearnLoop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .glass-effect { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.05); }
    </style>
</head>
<body class="min-h-screen text-slate-900">

    <header class="sticky top-0 z-50 border-b border-slate-200 glass-effect">
        <div class="mx-auto flex max-w-4xl items-center justify-between px-6 py-4">
            <div class="flex items-center gap-4">
                <a href="/beranda" class="flex h-10 w-10 items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-violet-600 hover:border-violet-200 transition-colors shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                </a>
                <h1 class="text-xl font-extrabold tracking-tight text-slate-900">Pesan Saya</h1>
            </div>
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-600 shadow-lg shadow-violet-200">
                <span class="text-xl font-bold text-white">L</span>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-4xl px-6 py-10 pb-24">
        
        <section class="mb-12">
            <div class="mb-6 flex items-center gap-3">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-violet-100 text-violet-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <h2 class="text-2xl font-bold text-slate-800">Grup Mahasiswa</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($groups as $group)
                    <div class="card-hover flex items-center justify-between p-5 bg-white rounded-[24px] border border-slate-200">
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-violet-500 to-violet-700 flex items-center justify-center text-white font-bold text-xl shadow-md shadow-violet-200">
                                #
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 line-clamp-1">{{ $group->name }}</h3>
                                <p class="text-[11px] text-violet-600 font-bold uppercase tracking-wider mt-0.5">Group Chat</p>
                            </div>
                        </div>
                        <a href="/chat/{{ $group->id }}" class="px-5 py-2.5 bg-violet-50 hover:bg-violet-600 text-violet-700 hover:text-white text-sm font-bold rounded-xl transition-colors">
                            Buka
                        </a>
                    </div>
                @empty
                    <div class="col-span-full p-8 text-center bg-white rounded-[24px] border border-dashed border-slate-300">
                        <p class="text-slate-500 font-medium">Lu belum masuk grup diskusi mana-mana bos.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <section>
            <div class="mb-6 flex items-center gap-3">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                </div>
                <h2 class="text-2xl font-bold text-slate-800">Pesan Pribadi</h2>
            </div>

            <div class="flex flex-col gap-3">
                @forelse($users as $user)
                    <div class="card-hover flex items-center justify-between p-4 bg-white rounded-[24px] border border-slate-200">
                        <div class="flex items-center gap-4">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=7c3aed&color=ffffff&rounded=true" class="h-12 w-12 rounded-full ring-2 ring-violet-50" alt="{{ $user->name }}" />
                            <div>
                                <h3 class="font-bold text-slate-900">{{ $user->name }}</h3>
                                <p class="text-sm text-slate-500">{{ $user->email }}</p>
                            </div>
                        </div>
                        <a href="/chat/private/{{ $user->id }}" class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-sm font-bold rounded-xl shadow-md transition-all">
                            Chat
                        </a>
                    </div>
                @empty
                    <div class="p-8 text-center bg-white rounded-[24px] border border-dashed border-slate-300">
                        <p class="text-slate-500 font-medium">Belum ada teman terdaftar untuk diajak ngobrol.</p>
                    </div>
                @endforelse
            </div>
        </section>

    </main>

</body>
</html>
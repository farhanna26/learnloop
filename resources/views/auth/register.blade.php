<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register LearnLoop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</n    </style>
</head>
<body class="min-h-screen bg-slate-50 flex items-center justify-center px-6 py-10">
    <div class="w-full max-w-xl rounded-[32px] bg-white p-10 shadow-2xl shadow-slate-200">
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-slate-900">Buat akun LearnLoop</h1>
            <p class="mt-3 text-sm text-slate-500">Daftar sebagai mahasiswa untuk mulai berbagi dan belajar bersama.</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-800">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mt-2 list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/register') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-700">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-violet-500 focus:ring-2 focus:ring-violet-100" placeholder="Nama kamu" />
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-violet-500 focus:ring-2 focus:ring-violet-100" placeholder="nama@student.unila.ac.id" />
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700">Password</label>
                <input type="password" name="password" required class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-violet-500 focus:ring-2 focus:ring-violet-100" placeholder="Minimal 8 karakter" />
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700">Peran</label>
                <select name="role" required class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-violet-500 focus:ring-2 focus:ring-violet-100">
                    <option value="" disabled selected>Pilih peran</option>
                    <option value="creator" {{ old('role') === 'creator' ? 'selected' : '' }}>Creator</option>
                    <option value="learner" {{ old('role') === 'learner' ? 'selected' : '' }}>Learner</option>
                </select>
            </div>

            <button type="submit" class="w-full rounded-full bg-violet-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-violet-200/70 transition hover:bg-violet-700">Daftar sekarang</button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-500">Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold text-violet-600 hover:text-violet-700">Masuk</a></p>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke LearnLoop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; overflow: hidden; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.4); }
        .hidden-auth { display: none; }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
    </style>
</head>
<body class="bg-[#f5f0ff] min-h-screen flex items-center justify-center p-6 relative">

    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-purple-300 rounded-full blur-[100px] opacity-50"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-indigo-300 rounded-full blur-[100px] opacity-50"></div>
    <div class="absolute text-8xl animate-float opacity-40 left-20 top-40">📖</div>
    <div class="absolute text-8xl animate-float opacity-40 right-20 bottom-40" style="animation-delay: 2s">💻</div>

    <div class="glass w-full max-w-[450px] p-10 rounded-[40px] shadow-2xl relative z-10">
        
        <div id="login-form">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Selamat Datang 👋</h2>
            <p class="text-gray-500 mb-8 font-medium">Masuk untuk lanjut belajar di LearnLoop.</p>

            <form action="#" class="space-y-5">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email Mahasiswa</label>
                    <input type="email" class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-gray-200 focus:ring-2 focus:ring-purple-500 outline-none transition-all" placeholder="nama@student.unila.ac.id">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                    <input type="password" class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-gray-200 focus:ring-2 focus:ring-purple-500 outline-none transition-all" placeholder="••••••••">
                </div>
                <a href="/home" class="w-full bg-purple-600 text-white py-4 rounded-2xl font-bold text-lg shadow-lg shadow-purple-200 hover:bg-purple-700 hover:-translate-y-1 transition-all flex items-center justify-center">
    Masuk Sekarang
</a>
            </form>
            <p class="mt-8 text-center text-gray-600 font-medium">
                Belum punya akun? <button onclick="toggleAuth()" class="text-purple-600 font-bold hover:underline">Daftar di sini</button>
            </p>
        </div>

        <div id="register-form" class="hidden-auth text-gray-950">
            <h2 class="text-3xl font-extrabold mb-2">Buat Akun ✨</h2>
            <p class="text-gray-500 mb-8 font-medium">Gabung komunitas Informatika Unila.</p>

            <form action="#" class="space-y-5">
                <div>
                    <label class="block text-sm font-bold mb-2">Nama Lengkap</label>
                    <input type="text" class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-gray-200 focus:ring-2 focus:ring-purple-500 outline-none transition-all" placeholder="Contoh: Yaza Nurzahira">
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">NPM</label>
                    <input type="text" class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-gray-200 focus:ring-2 focus:ring-purple-500 outline-none transition-all" placeholder="2217051xxx">
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">Password</label>
                    <input type="password" class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-gray-200 focus:ring-2 focus:ring-purple-500 outline-none transition-all" placeholder="Min. 8 karakter">
                </div>
                <button type="button" class="w-full bg-gray-900 text-white py-4 rounded-2xl font-bold text-lg hover:bg-black hover:-translate-y-1 transition-all">
                    Buat Akun Baru
                </button>
            </form>
            <p class="mt-8 text-center text-gray-600 font-medium">
                Sudah ada akun? <button onclick="toggleAuth()" class="text-purple-600 font-bold hover:underline">Masuk aja</button>
            </p>
        </div>
    </div>

    <script>
        function toggleAuth() {
            const login = document.getElementById('login-form');
            const register = document.getElementById('register-form');
            
            login.classList.toggle('hidden-auth');
            register.classList.toggle('hidden-auth');
        }
    </script>
</body>
</html>
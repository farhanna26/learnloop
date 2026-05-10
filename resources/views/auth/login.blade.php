<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | LearnLoop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        .aca-bounce {
            animation: bounce-custom 3s infinite ease-in-out;
        }
        @keyframes bounce-custom {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50 flex items-center justify-center p-6">

    <div class="w-full max-w-md">
        <div class="flex justify-center mb-6 aca-bounce">
            <svg width="100" height="100" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M30 45C30 30 45 20 60 20C75 20 90 30 90 45V90C90 100 82 108 70 108C65 108 62 105 60 105C58 105 55 108 50 108C38 108 30 100 30 90V45Z" fill="#A78BFA"/>
                <circle cx="48" cy="62" r="7" fill="white"/>
                <circle cx="48" cy="62" r="4" fill="#1E1B4B"/>
                <circle cx="46" cy="60" r="1.5" fill="white"/>
                
                <circle cx="72" cy="62" r="7" fill="white"/>
                <circle cx="72" cy="62" r="4" fill="#1E1B4B"/>
                <circle cx="70" cy="60" r="1.5" fill="white"/>
                <path d="M52 78C52 78 56 84 60 84C64 84 68 78 68 78" stroke="#4C1D95" stroke-width="2.5" stroke-linecap="round"/>
                <path d="M25 35L60 18L95 35L60 52L25 35Z" fill="#1E293B"/>
                <path d="M45 40V48C45 48 50 52 60 52C70 52 75 48 75 48V40" fill="#1E293B"/>
            </svg>
        </div>

        <div class="bg-white rounded-[32px] p-8 shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-slate-100">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-extrabold text-slate-900">Login Darurat</h2>
                <p class="text-slate-500 text-sm mt-1">Backend Testing Mode</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-xl flex items-start gap-3">
                    <span class="text-red-500 font-bold">!</span>
                    <p class="text-red-700 text-sm font-semibold">{{ $errors->first() }}</p>
                </div>
            @endif

            <form action="/login" method="POST" class="space-y-5">
                @csrf 

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Email Address</label>
                    <input type="email" name="email" required
                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-violet-100 focus:border-violet-400 outline-none transition-all text-slate-900 placeholder:text-slate-400"
                        placeholder="nama@email.com">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-violet-100 focus:border-violet-400 outline-none transition-all text-slate-900 placeholder:text-slate-400"
                        placeholder="••••••••">
                </div>

                <div class="pt-2">
                    <button type="submit" 
                        class="w-full py-4 bg-violet-600 hover:bg-violet-700 text-white font-bold rounded-2xl shadow-xl shadow-violet-200 transition-all active:scale-[0.98]">
                        Gass Login!
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-100 text-center">
                <a href="/" class="text-sm font-bold text-slate-400 hover:text-violet-600 transition">
                    &larr; Kembali ke Landing
                </a>
            </div>
        </div>
    </div>

</body>
</html>
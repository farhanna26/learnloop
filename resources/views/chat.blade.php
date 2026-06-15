<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $chatTitle }} | LearnLoop</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
        .btn-pop-white {
            background: #ffffff;
            border: 2px solid #cbd5e1;
            box-shadow: 0px 4px 0px #cbd5e1;
            transition: all 0.15s ease;
        }
        .btn-pop-white:active { transform: translateY(4px); box-shadow: 0px 0px 0px #cbd5e1; }
        .dark .btn-pop-white { background: #161245; border: 2px solid #2e2773; box-shadow: 0px 4px 0px #0d0a2d; color: white; }

        .btn-pop-purple {
            background: #7c3aed;
            border: 2px solid #a78bfa;
            box-shadow: 0px 4px 0px #5b21b6;
            transition: all 0.15s ease;
        }
        .btn-pop-purple:active { transform: translateY(4px); box-shadow: 0px 0px 0px #5b21b6; }
        .dark .btn-pop-purple { background: #7c3aed; border: 2px solid #a78bfa; box-shadow: 0px 4px 0px #4c1d95; }

        .btn-pop-emerald {
            background: #059669;
            border: 2px solid #34d399;
            box-shadow: 0px 4px 0px #065f46;
            transition: all 0.15s ease;
        }
        .btn-pop-emerald:active { transform: translateY(4px); box-shadow: 0px 0px 0px #065f46; }

        .card-pop-solid {
            background: #ffffff;
            border: 2px solid #e2e8f0;
            box-shadow: 0px 4px 0px #e2e8f0;
        }
        .dark .card-pop-solid { background: #161245; border: 2px solid #2e2773; box-shadow: 0px 4px 0px #0d0a2d; }

        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 999px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #2e2773; }
    </style>
</head>
<body class="h-screen w-screen bg-[#f0f2fe] dark:bg-[#060412] text-[#1e1b4b] dark:text-[#f3f1fa] antialiased font-sans p-3 md:p-6 flex items-center justify-center overflow-hidden transition-colors duration-300">

    <!-- BINGKAI UTAMA DASHBOARD MELAYANG -->
    <div class="w-full max-w-[1440px] h-full bg-[#f8fafc] dark:bg-[#0b0822] rounded-[3.5rem] p-4 md:p-6 border-4 border-slate-200 dark:border-slate-800 shadow-xl flex flex-col overflow-hidden relative">
        
        <!-- HEADER OBROLAN -->
        <header class="p-4 md:p-5 border-b border-slate-100 dark:border-slate-800/80 bg-slate-50/50 dark:bg-[#161245]/30 flex items-center justify-between shrink-0 rounded-t-[2.5rem]">
            <div class="flex items-center gap-4">
                <a href="/contacts" class="btn-pop-white h-10 w-10 flex items-center justify-center rounded-xl text-slate-500 hover:text-purple-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                </a>
                
                <div class="flex items-center gap-3">
                    @if($room->type === 'group')
                        <img src="{{ $room->photo ? asset('storage/' . $room->photo) : 'https://ui-avatars.com/api/?name='.urlencode($chatTitle).'&background=8b5cf6&color=ffffff&rounded=true' }}" 
                             class="h-10 w-10 rounded-xl border-2 border-purple-500 object-cover" alt="Group Profile">
                    @else
                        <img src="{{ $otherUser && $otherUser->photo ? asset($otherUser->photo) : 'https://ui-avatars.com/api/?name='.urlencode($chatTitle).'&background=8b5cf6&color=ffffff&rounded=true' }}" 
                             class="h-10 w-10 rounded-xl border-2 border-purple-500 object-cover" alt="Profile">
                    @endif

                    <div>
                        @if($room->type === 'group' || $room->type === 'classroom')
                            <a href="/chat/group/{{ $room->id }}/info" class="hover:text-purple-600 dark:hover:text-purple-400 transition-colors cursor-pointer group flex items-center gap-1">
                                <h2 class="text-sm font-black text-purple-950 dark:text-white uppercase tracking-tight group-hover:underline leading-tight">{{ $chatTitle }}</h2>
                            </a>
                        @else
                            <h2 class="text-sm font-black text-purple-950 dark:text-white uppercase tracking-tight leading-tight">{{ $chatTitle }}</h2>
                        @endif
                        <p class="text-[9px] text-slate-400 dark:text-slate-500 font-bold flex items-center gap-1 uppercase tracking-wider mt-0.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 block animate-pulse"></span> Online
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 flex items-center justify-center rounded-xl bg-purple-100 dark:bg-purple-950/50 text-purple-600 dark:text-purple-400 border border-purple-200 dark:border-purple-900/50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                </div>
            </div>
        </header>

        <!-- SUB HEADER TABS JIKA RUANG KELAS -->
        @if($room->type === 'classroom')
        <div class="flex border-b-2 border-slate-200 dark:border-slate-800 shrink-0 bg-slate-50/50 dark:bg-[#161245]/20 z-10 p-1 gap-2">
            <button id="tab-obrolan" onclick="switchClassTab('obrolan')" class="flex-1 py-3 text-xs font-black text-slate-800 dark:text-white border-2 border-purple-600 bg-purple-50 dark:bg-purple-950/30 rounded-xl transition-all uppercase tracking-wider">
                💬 Obrolan Kelas
            </button>
            <button id="tab-tugas" onclick="switchClassTab('tugas')" class="flex-1 py-3 text-xs font-black text-slate-400 dark:text-slate-500 border-2 border-transparent hover:text-slate-700 dark:hover:text-slate-300 rounded-xl transition-all uppercase tracking-wider">
                📝 Daftar Tugas
            </button>
        </div>
        @endif

        <!-- AREA 1: KOTAK UTAMA OBROLAN -->
        <div id="area-obrolan" class="flex flex-col flex-1 overflow-hidden bg-white dark:bg-[#110d35] rounded-b-[2.5rem] border-x-2 border-b-2 border-slate-200/60 dark:border-slate-800/60">
            <div id="chat-box" class="flex-1 overflow-y-auto p-6 space-y-6 bg-slate-50/40 dark:bg-[#0e0a2f]/20 custom-scrollbar flex flex-col-reverse">
                <div class="space-y-6 flex flex-col w-full">
                    @foreach($messages as $msg)
                        @if($msg->username === Auth::user()->name)
                            <div class="flex justify-end animate-fade-in w-full">
                                <div class="w-fit max-w-[75%] bg-purple-600 text-white px-4 py-3 rounded-2xl rounded-tr-sm border-2 border-purple-400 shadow-sm font-medium text-xs">
                                    <p class="leading-relaxed whitespace-pre-wrap">{{ $msg->text }}</p>
                                </div>
                            </div>
                        @else
                            <div class="flex items-start gap-3 animate-fade-in w-full">
                                <img src="{{ $msg->user && $msg->user->photo ? asset($msg->user->photo) : 'https://ui-avatars.com/api/?name='.urlencode($msg->username).'&background=f1f5f9&color=64748b&bold=true' }}" 
                                     alt="{{ $msg->username }}" class="w-8 h-8 rounded-xl border border-slate-200 dark:border-slate-700 object-cover shrink-0">
                                <div class="max-w-[75%]">
                                    <span class="text-[9px] text-slate-400 dark:text-slate-500 font-black mb-1 block uppercase tracking-wider">{{ $msg->username }}</span>
                                    <div class="w-fit bg-white dark:bg-[#161245] text-slate-800 dark:text-slate-100 px-4 py-3 rounded-2xl rounded-tl-sm border-2 border-slate-200 dark:border-slate-800 shadow-sm text-xs">
                                        <p class="leading-relaxed whitespace-pre-wrap">{{ $msg->text }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- FORM KIRIM CHAT -->
            <div class="bg-slate-50/50 dark:bg-[#161245]/40 border-t-2 border-slate-200 dark:border-slate-800 p-4 shrink-0">
                <form id="chat-form" class="flex items-center gap-3">
                    <div class="relative flex-1">
                        <input type="text" id="message-text" placeholder="Ketik pesan di sini..." class="w-full bg-white dark:bg-[#0c0926] border-2 border-slate-200 dark:border-slate-800 focus:border-purple-500 dark:focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 rounded-2xl pl-5 pr-4 py-3.5 text-xs font-bold text-slate-800 dark:text-white transition-all outline-none" required autocomplete="off">
                    </div>
                    
                    <button type="submit" class="btn-pop-purple bg-purple-600 text-white rounded-xl h-12 w-12 flex items-center justify-center shrink-0 border-purple-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- AREA 2: DAFTAR TUGAS KELAS -->
        @if($room->type === 'classroom')
        <div id="area-tugas" class="hidden flex-1 overflow-y-auto p-6 space-y-6 bg-white dark:bg-[#110d35] rounded-b-[2.5rem] border-x-2 border-b-2 border-slate-200/60 dark:border-slate-800/60 custom-scrollbar">
            
            @if(auth()->user()->role === 'creator')
                <button onclick="document.getElementById('modalBuatTugas').classList.remove('hidden')" class="w-full py-4 border-2 border-dashed border-emerald-400 bg-emerald-50/40 dark:bg-emerald-950/10 text-emerald-700 dark:text-emerald-400 font-black rounded-2xl hover:bg-emerald-50 dark:hover:bg-emerald-950/20 transition-all flex items-center justify-center gap-2 mb-6 text-xs uppercase tracking-wider">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Buat Tugas Baru
                </button>
            @endif

            <div class="space-y-4">
                @forelse($assignments as $tugas)
                    <div class="card-pop-solid flex flex-col p-5 bg-white dark:bg-[#161245] border-2 border-slate-200 dark:border-slate-800 rounded-2xl transition-all hover:translate-x-1 cursor-pointer" 
                         onclick="authRole === 'creator' ? openReviewModal({{ $tugas->id }}) : openSubmitModal({{ $tugas->id }}, '{{ addslashes($tugas->title) }}')">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-black text-xs text-purple-950 dark:text-white uppercase tracking-tight">{{ $tugas->title }}</h3>
                            @if($tugas->deadline > now())
                                <span class="bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-400 text-[9px] font-black px-2.5 py-1 rounded-lg uppercase tracking-wider border border-emerald-300 dark:border-emerald-800">Aktif</span>
                            @else
                                <span class="bg-red-100 dark:bg-red-950 text-red-600 dark:text-red-400 text-[9px] font-black px-2.5 py-1 rounded-lg uppercase tracking-wider border border-red-200 dark:border-red-900">Ditutup</span>
                            @endif
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-medium line-clamp-2 leading-relaxed">{{ $tugas->description }}</p>
                        <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center gap-2 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wide">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Tenggat: {{ $tugas->deadline->format('d M Y, H:i') }}
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 bg-white dark:bg-[#161245] rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-800">
                        <p class="text-slate-400 dark:text-slate-500 italic font-bold text-xs uppercase tracking-wider">Belum ada tugas di kelas ini. Santai aja dulu ☕</p>
                    </div>
                @endforelse
            </div>
        </div>
        @endif

    </div>

    <!-- MODAL POPUP: BUAT TUGAS BARU -->
    <div id="modalBuatTugas" class="fixed inset-0 z-[80] hidden flex items-center justify-center p-4 bg-slate-900/60 dark:bg-[#03010a]/80 backdrop-blur-sm">
        <div class="w-full max-w-lg rounded-[2.5rem] bg-white dark:bg-[#110d35] p-6 border-4 border-slate-200 dark:border-slate-800 shadow-2xl">
            <div class="flex items-center justify-between mb-6 pb-3 border-b border-slate-100 dark:border-slate-800">
                <h3 class="text-sm font-black uppercase tracking-wider text-purple-950 dark:text-white">Buat Tugas Baru</h3>
                <button onclick="document.getElementById('modalBuatTugas').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 bg-slate-50 dark:bg-[#161245] p-2 rounded-xl transition-colors">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <form id="formBuatTugas" onsubmit="submitTugas(event)" class="space-y-4">
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2 ml-1">Judul Tugas</label>
                    <input type="text" id="tugasTitle" class="w-full rounded-xl border-2 border-slate-200 dark:border-slate-800 p-3 text-xs font-bold text-slate-800 dark:text-white outline-none focus:border-emerald-500 dark:focus:border-emerald-500 transition-all bg-slate-50 dark:bg-[#0c0926]" required placeholder="Misal: Tugas Akhir Pemrograman Web">
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2 ml-1">Deskripsi / Instruksi</label>
                    <textarea id="tugasDesc" rows="3" class="w-full rounded-xl border-2 border-slate-200 dark:border-slate-800 p-3 text-xs text-slate-800 dark:text-white outline-none focus:border-emerald-500 dark:focus:border-emerald-500 transition-all bg-slate-50 dark:bg-[#0c0926]" required placeholder="Jelaskan apa yang harus dikerjakan mahasiswa..."></textarea>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2 ml-1">Tenggat Waktu (Deadline)</label>
                    <input type="datetime-local" id="tugasDeadline" class="w-full rounded-xl border-2 border-slate-200 dark:border-slate-800 p-3 text-xs font-bold text-slate-800 dark:text-white outline-none focus:border-emerald-500 dark:focus:border-emerald-500 transition-all bg-slate-50 dark:bg-[#0c0926]" required>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2 ml-1">File Soal/Modul (Opsional)</label>
                    <input type="file" id="tugasFile" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-2 file:border-emerald-400 file:text-[10px] file:font-black file:uppercase file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-colors cursor-pointer" accept=".pdf,.doc,.docx,.zip">
                </div>

                <div class="pt-2">
                    <button type="submit" id="btnSubmitTugas" class="btn-pop-emerald w-full bg-emerald-600 py-3.5 text-xs font-black text-white uppercase tracking-widest rounded-xl">Terbitkan Tugas</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL POPUP: KUMPUL JAWABAN TUGAS -->
    <div id="modalKumpulTugas" class="fixed inset-0 z-[80] hidden flex items-center justify-center p-4 bg-slate-900/60 dark:bg-[#03010a]/80 backdrop-blur-sm">
        <div class="w-full max-w-md rounded-[2.5rem] bg-white dark:bg-[#110d35] p-6 border-4 border-slate-200 dark:border-slate-800 shadow-2xl">
            <div class="flex items-center justify-between mb-6 pb-3 border-b border-slate-100 dark:border-slate-800">
                <h3 class="text-sm font-black uppercase tracking-wider text-purple-950 dark:text-white">Kumpul Tugas</h3>
                <button onclick="document.getElementById('modalKumpulTugas').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 bg-slate-50 dark:bg-[#161245] p-2 rounded-xl transition-colors">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <form id="formKumpulTugas" onsubmit="submitJawaban(event)" class="space-y-5">
                <input type="hidden" id="submitAssignmentId">
                
                <div class="p-4 bg-purple-50 dark:bg-purple-950/30 rounded-2xl border-2 border-purple-200 dark:border-purple-900/40 text-xs">
                    <span class="font-black text-purple-700 dark:text-purple-400 uppercase tracking-wider block mb-1">Tugas yang dipilih:</span>
                    <span id="submitAssignmentTitle" class="text-slate-800 dark:text-slate-200 font-bold"></span>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2 ml-1">Upload File Jawaban</label>
                    <input type="file" id="submitFile" required class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-2 file:border-purple-400 file:text-[10px] file:font-black file:uppercase file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 transition-colors cursor-pointer" accept=".pdf,.zip,.doc,.docx,.png,.jpg">
                </div>

                <div class="pt-2">
                    <button type="submit" id="btnSubmitJawaban" class="btn-pop-purple w-full bg-purple-600 py-3.5 text-xs font-black text-white uppercase tracking-widest rounded-xl border-purple-400">Kirim Jawaban</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL POPUP: REVIEW DASHBOARD PENILAIAN -->
    <div id="modalReviewTugas" class="fixed inset-0 z-[80] hidden flex items-center justify-center p-4 bg-slate-900/60 dark:bg-[#03010a]/80 backdrop-blur-sm">
        <div class="w-full max-w-2xl rounded-[2.5rem] bg-white dark:bg-[#110d35] border-4 border-slate-200 dark:border-slate-800 p-6 shadow-2xl flex flex-col max-h-[85vh]">
            <div class="flex items-center justify-between mb-4 shrink-0 pb-3 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <h3 class="text-sm font-black uppercase tracking-wider text-purple-950 dark:text-white">Dashboard Penilaian</h3>
                    <p id="reviewAssignmentTitle" class="text-[10px] font-black text-purple-600 dark:text-purple-400 mt-0.5 uppercase tracking-wider"></p>
                </div>
                <button onclick="document.getElementById('modalReviewTugas').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 bg-slate-50 dark:bg-[#161245] p-2 rounded-xl transition-colors">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <div id="submissionsListWrapper" class="flex-1 overflow-y-auto space-y-4 pr-1 custom-scrollbar my-2 py-2">
                <!-- Data submission di-render dinamis oleh javascript -->
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT LOGIC SECTION -->
    <script type="module">
        const chatBox = document.getElementById('chat-box');
        const chatForm = document.getElementById('chat-form');
        const textInput = document.getElementById('message-text');

        const roomId = {{ $room->id }};
        const myName = "{{ Auth::user()->name }}";

        chatBox.scrollTop = chatBox.scrollHeight;

        window.Echo.private(`chat.room.${roomId}`)
            .listen('.message.sent', (e) => {
                const newChat = document.createElement('div');
                const isMe = e.username === myName;
                const avatarUrl = e.photo 
                    ? e.photo 
                    : `https://ui-avatars.com/api/?name=${encodeURIComponent(e.username)}&background=f1f5f9&color=64748b&bold=true`;

                if (isMe) {
                    newChat.className = 'flex justify-end w-full';
                    newChat.innerHTML = `<div class="w-fit max-w-[75%] bg-purple-600 text-white px-4 py-3 rounded-2xl rounded-tr-sm border-2 border-purple-400 shadow-sm text-xs font-medium"><p class="leading-relaxed whitespace-pre-wrap">${e.message}</p></div>`;
                } else {
                    newChat.className = 'flex items-start gap-3 w-full';
                    newChat.innerHTML = `<img src="${avatarUrl}" class="w-8 h-8 rounded-xl border border-slate-200 dark:border-slate-700 object-cover shrink-0"><div class="max-w-[75%]"><span class="text-[9px] text-slate-400 dark:text-slate-500 font-black mb-1 block uppercase tracking-wider">${e.username}</span><div class="w-fit bg-white dark:bg-[#161245] text-slate-800 dark:text-slate-100 px-4 py-3 rounded-2xl rounded-tl-sm border-2 border-slate-200 dark:border-slate-800 shadow-sm text-xs"><p class="leading-relaxed whitespace-pre-wrap">${e.message}</p></div></div>`;
                }
                
                const containerInner = chatBox.querySelector('.space-y-6');
                if (containerInner) {
                    containerInner.appendChild(newChat);
                } else {
                    chatBox.appendChild(newChat);
                }
                chatBox.scrollTop = chatBox.scrollHeight;
            });

        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const text = textInput.value;
            if (!text.trim()) return;

            fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message: text, room_id: roomId })
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response error');
                return response.json();
            })
            .then(data => { textInput.value = ''; })
            .catch(error => { console.error('Error:', error); });
        });
    </script>

    <script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const authRole = "{{ auth()->user()->role }}";
    const globalAssignmentsData = @json($assignments);

    if (sessionStorage.getItem('openTab') === 'tugas') {
        sessionStorage.removeItem('openTab');
        switchClassTab('tugas');
    }
    
    function switchClassTab(tab) {
        const btnObrolan = document.getElementById('tab-obrolan');
        const btnTugas = document.getElementById('tab-tugas');
        const areaObrolan = document.getElementById('area-obrolan');
        const areaTugas = document.getElementById('area-tugas');

        const activeClass = "flex-1 py-3 text-xs font-black text-slate-800 dark:text-white border-2 border-purple-600 bg-purple-50 dark:bg-purple-950/30 rounded-xl transition-all uppercase tracking-wider";
        const inactiveClass = "flex-1 py-3 text-xs font-black text-slate-400 dark:text-slate-500 border-2 border-transparent hover:text-slate-700 dark:hover:text-slate-300 rounded-xl transition-all uppercase tracking-wider";

        if (tab === 'obrolan') {
            btnObrolan.className = activeClass;
            btnTugas.className = inactiveClass;
            areaObrolan.classList.remove('hidden');
            areaTugas.classList.add('hidden');
        } else {
            btnObrolan.className = inactiveClass;
            btnTugas.className = activeClass;
            areaObrolan.classList.add('hidden');
            areaTugas.classList.remove('hidden');
        }
    }

    function openSubmitModal(id, title) {
        document.getElementById('submitAssignmentId').value = id;
        document.getElementById('submitAssignmentTitle').innerText = title;
        document.getElementById('modalKumpulTugas').classList.remove('hidden');
    }

    async function submitTugas(e) {
        e.preventDefault();
        
        const title    = document.getElementById('tugasTitle').value;
        const desc     = document.getElementById('tugasDesc').value;
        const deadline = document.getElementById('tugasDeadline').value;
        const file     = document.getElementById('tugasFile').files[0];
        const btn      = document.getElementById('btnSubmitTugas');

        btn.innerText = "Menerbitkan...";
        btn.disabled  = true;

        const formData = new FormData();
        formData.append('room_id', '{{ $room->id }}');
        formData.append('title', title);
        formData.append('description', desc);
        formData.append('deadline', deadline);
        if (file) formData.append('file_path', file);

        try {
            const response = await fetch('/assignments', {
                method: 'POST',
                body: formData,
                headers: { 'X-CSRF-TOKEN': csrfToken }
            });
            const result = await response.json();
            if (result.success) {
                alert('Tugas berhasil diterbitkan.');
                window.location.reload();
            } else {
                alert('Gagal: ' + result.message);
            }
        } catch (error) {
            console.error(error);
            alert('Terjadi kesalahan sistem!');
        } finally {
            btn.innerText = "Terbitkan Tugas";
            btn.disabled  = false;
        }
    }

    async function submitJawaban(e) {
        e.preventDefault();
        const assignId = document.getElementById('submitAssignmentId').value;
        const file     = document.getElementById('submitFile').files[0];
        const btn      = document.getElementById('btnSubmitJawaban');

        if (!file) return alert('Pilih file dulu!');

        btn.innerText = "Mengirim...";
        btn.disabled  = true;

        const formData = new FormData();
        formData.append('assignment_id', assignId);
        formData.append('file_path', file);

        try {
            const response = await fetch('/submissions', {
                method: 'POST',
                body: formData,
                headers: { 'X-CSRF-TOKEN': csrfToken }
            });
            const result = await response.json();
            if (result.success) {
                alert('Tugas berhasil dikumpulkan.');
                window.location.reload();
            } else {
                alert('Gagal: ' + result.message);
            }
        } catch (err) {
            console.error(err);
            alert('Error sistem!');
        } finally {
            btn.innerText = "Kirim Jawaban";
            btn.disabled  = false;
        }
    }

    function openReviewModal(assignmentId) {
        const assignment = globalAssignmentsData.find(a => a.id === assignmentId);
        if (!assignment) return;

        document.getElementById('reviewAssignmentTitle').innerText = assignment.title;
        const listWrapper = document.getElementById('submissionsListWrapper');
        listWrapper.innerHTML = '';

        if (!assignment.submissions || assignment.submissions.length === 0) {
            listWrapper.innerHTML = `
                <div class="text-center py-12 bg-slate-50 dark:bg-[#161245] rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-800">
                    <p class="text-slate-400 dark:text-slate-500 italic font-bold text-xs uppercase tracking-wider">Belum ada mahasiswa yang mengumpulkan tugas ini.</p>
                </div>`;
        } else {
            assignment.submissions.forEach(sub => {
                const studentName = sub.user?.name || 'Mahasiswa';
                const fileUrl = `/storage/${sub.file_path}`;
                const statusColor = sub.status === 'late' ? 'text-red-500 bg-red-50 dark:bg-red-950/30 border-red-200 dark:border-red-900' : 'text-emerald-600 bg-emerald-50 dark:bg-emerald-950/30 border-emerald-200 dark:border-emerald-900';
                const statusText = sub.status === 'late' ? 'Terlambat' : 'Tepat Waktu';
                const currentGrade = sub.grade !== null ? sub.grade : '';

                const subDiv = document.createElement('div');
                subDiv.className = "flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 bg-white dark:bg-[#161245] border-2 border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm";
                subDiv.innerHTML = `
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <h4 class="font-black text-slate-800 dark:text-slate-100 text-xs uppercase tracking-tight">${studentName}</h4>
                            <span class="text-[8px] font-black px-2 py-0.5 rounded-lg border uppercase tracking-wider ${statusColor}">${statusText}</span>
                        </div>
                        <a href="${fileUrl}" target="_blank" class="inline-flex items-center gap-1.5 text-[11px] font-black text-purple-600 dark:text-purple-400 hover:underline">
                            📂 Buka File Jawaban
                        </a>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <input type="number" id="grade-input-${sub.id}" value="${currentGrade}" min="0" max="100" placeholder="Nilai" 
                               class="w-20 rounded-xl border-2 border-slate-200 dark:border-slate-800 px-3 py-2 text-center text-xs font-black text-slate-800 dark:text-white outline-none focus:border-purple-500 bg-slate-50 dark:bg-[#0c0926]">
                        <button onclick="saveGrade(${sub.id})" class="bg-slate-900 dark:bg-purple-600 hover:bg-purple-700 text-white text-[11px] font-black px-4 py-2.5 rounded-xl border border-slate-700 dark:border-purple-400 transition-all active:scale-95 uppercase tracking-wider">
                            Simpan
                        </button>
                    </div>
                `;
                listWrapper.appendChild(subDiv);
            });
        }
        document.getElementById('modalReviewTugas').classList.remove('hidden');
    }

    async function saveGrade(submissionId) {
        const gradeInput = document.getElementById(`grade-input-${submissionId}`);
        const gradeValue = gradeInput.value.trim();

        if (gradeValue === '' || isNaN(gradeValue)) return alert('Isi nilainya terlebih dahulu!');
        if (gradeValue < 0 || gradeValue > 100) return alert('Skala nilai harus di antara 0 sampai 100!');

        try {
            const response = await fetch(`/submissions/${submissionId}/grade`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ grade: gradeValue })
            });
            const result = await response.json();

            if (result.success) {
                alert('Nilai berhasil disimpan');
                window.location.reload(); 
            } else {
                alert('Gagal: ' + result.message);
            }
        } catch (err) {
            console.error(err);
            alert('Gagal memproses nilai!');
        }
    }
</script>
</body>
</html>
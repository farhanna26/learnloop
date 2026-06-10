<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $chatTitle }} | LearnLoop</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .glass-effect { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-slate-50 h-screen flex justify-center overflow-hidden">

    <div class="w-full max-w-3xl bg-white shadow-xl flex flex-col h-full border-x border-slate-200">
        
        <header class="glass-effect border-b border-slate-200 px-6 py-4 flex items-center justify-between shrink-0 z-10">
            <div class="flex items-center gap-4">
                <a href="/contacts" class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-50 border border-slate-200 text-slate-500 hover:text-violet-600 hover:bg-violet-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                </a>
                
                <div class="flex items-center gap-3">
                    @if($room->type === 'group')
                        <img src="{{ $room->photo ? asset('storage/' . $room->photo) : 'https://ui-avatars.com/api/?name='.urlencode($chatTitle).'&background=8b5cf6&color=ffffff&rounded=true' }}" 
                             class="h-10 w-10 rounded-full border border-slate-100 shadow-sm object-cover" alt="Group Profile">
                    @else
                        <img src="{{ $otherUser && $otherUser->photo ? asset($otherUser->photo) : 'https://ui-avatars.com/api/?name='.urlencode($chatTitle).'&background=8b5cf6&color=ffffff&rounded=true' }}" 
                             class="h-10 w-10 rounded-full border border-slate-100 shadow-sm object-cover" alt="Profile">
                    @endif

                    <div>
                        @if($room->type === 'group' || $room->type === 'classroom')
                            <a href="/chat/group/{{ $room->id }}/info" class="hover:text-violet-600 transition-colors cursor-pointer group">
                                <h2 class="text-sm font-extrabold text-slate-900 leading-tight group-hover:underline">{{ $chatTitle }}</h2>
                            </a>
                        @else
                            <h2 class="text-sm font-extrabold text-slate-900 leading-tight">{{ $chatTitle }}</h2>
                        @endif
                        <p class="text-[10px] text-slate-400 font-bold flex items-center gap-1 uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 block"></span> Online
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
            </div>
        </header>

        @if($room->type === 'classroom')
        <div class="flex border-b border-slate-200 shrink-0 bg-white z-10">
            <button id="tab-obrolan" onclick="switchClassTab('obrolan')" class="flex-1 py-3 text-sm font-bold text-slate-900 border-b-4 border-emerald-600 transition-colors">
                💬 Obrolan Kelas
            </button>
            <button id="tab-tugas" onclick="switchClassTab('tugas')" class="flex-1 py-3 text-sm font-bold text-slate-500 border-b-4 border-transparent hover:text-slate-900 transition-colors">
                📝 Daftar Tugas
            </button>
        </div>
        @endif

        <div id="area-obrolan" class="flex flex-col flex-1 overflow-hidden">
            <div id="chat-box" class="flex-1 overflow-y-auto p-6 space-y-6 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] bg-slate-50 custom-scrollbar">
                @foreach($messages as $msg)
                    @if($msg->username === Auth::user()->name)
                        <div class="flex justify-end animate-fade-in">
                            <div class="w-fit max-w-[75%] bg-violet-600 text-white px-4 py-3 rounded-2xl rounded-tr-sm shadow-sm shadow-violet-100">
                                <p class="text-sm leading-relaxed whitespace-pre-wrap">{{ $msg->text }}</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-start gap-3 animate-fade-in">
                            <img src="{{ $msg->user && $msg->user->photo ? asset($msg->user->photo) : 'https://ui-avatars.com/api/?name='.urlencode($msg->username).'&background=f1f5f9&color=64748b&bold=true' }}" 
                                 alt="{{ $msg->username }}" class="w-8 h-8 rounded-full border border-slate-200 mt-5 object-cover shrink-0">
                            <div class="max-w-[75%]">
                                <span class="text-[10px] text-slate-400 font-bold ml-1 mb-1 block tracking-wide">{{ $msg->username }}</span>
                                <div class="w-fit bg-white text-slate-800 px-4 py-3 rounded-2xl rounded-tl-sm shadow-sm border border-slate-100">
                                    <p class="text-sm leading-relaxed whitespace-pre-wrap">{{ $msg->text }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="bg-white border-t border-slate-100 p-4 shrink-0">
                <form id="chat-form" class="flex items-center gap-3">
                    <div class="relative flex-1">
                        <input type="text" id="message-text" placeholder="Ketik pesan..." class="w-full bg-slate-100 border-transparent focus:bg-white focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 rounded-2xl pl-5 pr-4 py-3.5 text-sm transition-all outline-none" required autocomplete="off">
                    </div>
                    
                    <button type="submit" class="bg-violet-600 hover:bg-violet-700 text-white rounded-2xl h-12 w-12 flex items-center justify-center transition-all hover:scale-105 active:scale-95 shadow-lg shadow-violet-200 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        @if($room->type === 'classroom')
        <div id="area-tugas" class="hidden flex-1 overflow-y-auto p-6 space-y-6 bg-slate-50 custom-scrollbar">
            
            @if(auth()->user()->role === 'creator')
                <button onclick="document.getElementById('modalBuatTugas').classList.remove('hidden')" class="w-full py-4 border-2 border-dashed border-emerald-300 bg-emerald-50 text-emerald-700 font-bold rounded-[24px] hover:bg-emerald-100 hover:border-emerald-400 transition-all flex items-center justify-center gap-2 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Buat Tugas Baru
                </button>
            @endif

            <div class="space-y-4">
                @forelse($assignments as $tugas)
                    <div class="bg-white border border-slate-200 rounded-[24px] p-5 shadow-sm hover:shadow-md transition-shadow cursor-pointer" 
                         onclick="authRole === 'creator' ? openReviewModal({{ $tugas->id }}) : openSubmitModal({{ $tugas->id }}, '{{ addslashes($tugas->title) }}')">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-extrabold text-lg text-slate-900">{{ $tugas->title }}</h3>
                            @if($tugas->deadline > now())
                                <span class="bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">Aktif</span>
                            @else
                                <span class="bg-red-100 text-red-600 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">Ditutup</span>
                            @endif
                        </div>
                        <p class="text-sm text-slate-600 line-clamp-2">{{ $tugas->description }}</p>
                        <div class="mt-4 pt-4 border-t border-slate-100 flex items-center gap-2 text-xs font-bold text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Tenggat: {{ $tugas->deadline->format('d M Y, H:i') }}
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 bg-white rounded-[24px] border border-slate-200">
                        <p class="text-slate-400 italic font-medium text-sm">Belum ada tugas di kelas ini. Santai aja dulu ☕</p>
                    </div>
                @endforelse
            </div>
        </div>
        @endif

    </div>

    <div id="modalBuatTugas" class="fixed inset-0 z-[80] hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div class="w-full max-w-lg rounded-[32px] bg-white p-8 shadow-2xl">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-extrabold text-slate-900">Buat Tugas Baru</h3>
                <button onclick="document.getElementById('modalBuatTugas').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 bg-slate-50 hover:bg-slate-100 p-2 rounded-full transition-colors">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <form id="formBuatTugas" onsubmit="submitTugas(event)">
                <div class="mb-4">
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Judul Tugas</label>
                    <input type="text" id="tugasTitle" class="w-full rounded-2xl border border-slate-200 p-3.5 text-sm font-medium outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all bg-slate-50" required placeholder="Misal: Tugas Akhir Pemrograman Web">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Deskripsi / Instruksi</label>
                    <textarea id="tugasDesc" rows="3" class="w-full rounded-2xl border border-slate-200 p-4 text-sm outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all bg-slate-50" required placeholder="Jelaskan apa yang harus dikerjakan mahasiswa..."></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Tenggat Waktu (Deadline)</label>
                    <input type="datetime-local" id="tugasDeadline" class="w-full rounded-2xl border border-slate-200 p-3.5 text-sm font-medium outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all bg-slate-50" required>
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">File Soal/Modul (Opsional)</label>
                    <input type="file" id="tugasFile" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-colors cursor-pointer" accept=".pdf,.doc,.docx,.zip">
                </div>

                <button type="submit" id="btnSubmitTugas" class="w-full rounded-2xl bg-emerald-600 py-4 text-sm font-bold text-white hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-200 active:scale-95">Terbitkan Tugas</button>
            </form>
        </div>
    </div>

    <div id="modalKumpulTugas" class="fixed inset-0 z-[80] hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
                <div class="w-full max-w-md rounded-[32px] bg-white p-8 shadow-2xl">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-extrabold text-slate-900">Kumpul Tugas</h3>
                        <button onclick="document.getElementById('modalKumpulTugas').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 bg-slate-50 hover:bg-slate-100 p-2 rounded-full transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <form id="formKumpulTugas" onsubmit="submitJawaban(event)">
                        <input type="hidden" id="submitAssignmentId">
                        
                        <div class="mb-6 p-4 bg-violet-50 rounded-2xl border border-violet-100 text-sm">
                            <span class="font-bold text-violet-700 block mb-1">Tugas yang dipilih:</span>
                            <span id="submitAssignmentTitle" class="text-slate-800 font-medium"></span>
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Upload File Jawaban</label>
                            <input type="file" id="submitFile" required class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100 transition-colors cursor-pointer" accept=".pdf,.zip,.doc,.docx,.png,.jpg">
                        </div>

                        <button type="submit" id="btnSubmitJawaban" class="w-full rounded-2xl bg-violet-600 py-4 text-sm font-bold text-white hover:bg-violet-700 transition-all shadow-lg shadow-violet-200 active:scale-95">Kirim Jawaban</button>
                    </form>
                </div>
            </div>

            <div id="modalReviewTugas" class="fixed inset-0 z-[80] hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
                <div class="w-full max-w-2xl rounded-[32px] bg-white p-8 shadow-2xl flex flex-col max-h-[85vh]">
                    <div class="flex items-center justify-between mb-4 shrink-0">
                        <div>
                            <h3 class="text-xl font-extrabold text-slate-900">Dashboard Penilaian</h3>
                            <p id="reviewAssignmentTitle" class="text-xs font-bold text-violet-600 mt-0.5 uppercase tracking-wider"></p>
                        </div>
                        <button onclick="document.getElementById('modalReviewTugas').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 bg-slate-50 hover:bg-slate-100 p-2 rounded-full transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <div id="submissionsListWrapper" class="flex-1 overflow-y-auto space-y-4 pr-1 custom-scrollbar my-4 py-2">
                        </div>
                </div>
            </div>

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
                    newChat.className = 'flex justify-end mt-4 mb-4';
                    newChat.innerHTML = `<div class="w-fit max-w-[75%] bg-violet-600 text-white px-4 py-3 rounded-2xl rounded-tr-sm shadow-sm"><p class="text-sm leading-relaxed whitespace-pre-wrap">${e.message}</p></div>`;
                } else {
                    newChat.className = 'flex items-start gap-3 mt-4 mb-4';
                    newChat.innerHTML = `<img src="${avatarUrl}" class="w-8 h-8 rounded-full border border-slate-200 mt-5 object-cover shrink-0"><div class="max-w-[75%]"><span class="text-[10px] text-slate-400 font-bold ml-1 mb-1 block tracking-wide">${e.username}</span><div class="w-fit bg-white text-slate-800 px-4 py-3 rounded-2xl rounded-tl-sm shadow-sm border border-slate-100"><p class="text-sm leading-relaxed whitespace-pre-wrap">${e.message}</p></div></div>`;
                }
                
                chatBox.appendChild(newChat);
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

    // Auto buka tab tugas kalau dari notifikasi
    if (sessionStorage.getItem('openTab') === 'tugas') {
        sessionStorage.removeItem('openTab');
        switchClassTab('tugas');
    }
    
    function switchClassTab(tab) {
        const btnObrolan = document.getElementById('tab-obrolan');
        const btnTugas = document.getElementById('tab-tugas');
        const areaObrolan = document.getElementById('area-obrolan');
        const areaTugas = document.getElementById('area-tugas');

        const activeClass = "flex-1 py-4 text-sm font-bold text-slate-900 border-b-4 border-emerald-600 transition-colors";
        const inactiveClass = "flex-1 py-4 text-sm font-bold text-slate-500 border-b-4 border-transparent hover:text-slate-900 transition-colors";

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

        if (!file) return alert('Pilih file dulu beb!');

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
                alert('Mantap! Tugas berhasil dikumpulkan.');
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

    // Buka Dashboard Review buat Creator
    function openReviewModal(assignmentId) {
        const assignment = globalAssignmentsData.find(a => a.id === assignmentId);
        if (!assignment) return;

        document.getElementById('reviewAssignmentTitle').innerText = assignment.title;
        const listWrapper = document.getElementById('submissionsListWrapper');
        listWrapper.innerHTML = '';

        if (!assignment.submissions || assignment.submissions.length === 0) {
            listWrapper.innerHTML = `
                <div class="text-center py-12 bg-slate-50 rounded-2xl border border-slate-100 border-dashed">
                    <p class="text-slate-400 italic font-medium text-sm">Belum ada mahasiswa yang ngumpul tugas ini, bos.</p>
                </div>`;
        } else {
            assignment.submissions.forEach(sub => {
                const studentName = sub.user?.name || 'Mahasiswa';
                const fileUrl = `/storage/${sub.file_path}`;
                const statusColor = sub.status === 'late' ? 'text-red-500 bg-red-50' : 'text-emerald-600 bg-emerald-50';
                const statusText = sub.status === 'late' ? 'Terlambat' : 'Tepat Waktu';
                const currentGrade = sub.grade !== null ? sub.grade : '';

                const subDiv = document.createElement('div');
                subDiv.className = "flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-5 bg-slate-50 border border-slate-200 rounded-2xl transition-all hover:bg-slate-100/50";
                subDiv.innerHTML = `
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <h4 class="font-bold text-slate-900 text-sm">${studentName}</h4>
                            <span class="text-[9px] font-extrabold px-2 py-0.5 rounded-full uppercase tracking-wider ${statusColor}">${statusText}</span>
                        </div>
                        <a href="${fileUrl}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-violet-600 hover:underline">
                            📂 Buka File Jawaban
                        </a>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <input type="number" id="grade-input-${sub.id}" value="${currentGrade}" min="0" max="100" placeholder="Nilai" 
                               class="w-20 rounded-xl border border-slate-200 px-3 py-2 text-center text-sm font-bold outline-none focus:border-violet-500 bg-white shadow-sm">
                        <button onclick="saveGrade(${sub.id})" class="bg-slate-900 hover:bg-violet-600 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-all shadow-sm active:scale-95">
                            Simpan
                        </button>
                    </div>
                `;
                listWrapper.appendChild(subDiv);
            });
        }
        document.getElementById('modalReviewTugas').classList.remove('hidden');
    }

    // Kirim nilai ke backend lewat AJAX
    async function saveGrade(submissionId) {
        const gradeInput = document.getElementById(`grade-input-${submissionId}`);
        const gradeValue = gradeInput.value.trim();

        if (gradeValue === '' || isNaN(gradeValue)) return alert('Isi nilainya yang bener dulu beb!');
        if (gradeValue < 0 || gradeValue > 100) return alert('Nilai itu skalanya 0 sampai 100 bos!');

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
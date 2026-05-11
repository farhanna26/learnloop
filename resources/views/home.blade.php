<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LearnLoop | Platform Kolaborasi Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .glass-effect { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.05); }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
    </style>
</head>
<body class="min-h-screen text-slate-900">

    <header class="sticky top-0 z-50 border-b border-slate-200 glass-effect">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6">
            <div class="flex flex-1 items-center gap-8">
                <a href="#" class="flex items-center gap-2">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-600 shadow-lg shadow-violet-200">
                        <span class="text-xl font-bold text-white">L</span>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight text-slate-900">LearnLoop</span>
                </a>
            </div>

            <div class="flex items-center gap-3">
                <input type="file" id="fileInput" class="hidden" accept="image/*,video/*,.pdf">
                <button id="uploadBtn" class="hidden items-center gap-2 rounded-2xl bg-violet-600 px-5 py-2.5 text-sm font-bold text-white shadow-md transition-all hover:bg-violet-700 md:flex">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14m7-7H5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Upload
                </button>
                <img src="https://ui-avatars.com/api/?name=Yaza&background=8b5cf6&color=ffffff&rounded=true" class="h-9 w-9 rounded-xl shadow-sm" />
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-8 pb-24 sm:px-6">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
            
            <aside class="hidden lg:col-span-3 lg:block">
                <div class="sticky top-28 space-y-4">
                    <nav class="space-y-1">
                        <a href="#" class="group flex items-center gap-3 rounded-2xl bg-violet-50 px-4 py-3 text-sm font-bold text-violet-700 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Beranda
                        </a>
                        <a href="#" class="group flex items-center justify-between rounded-2xl px-4 py-3 text-sm font-medium text-slate-600 transition-all hover:bg-slate-100 hover:text-slate-900">
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                Pesan
                            </div>
                        </a>
                        <a href="#" class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium text-slate-600 transition-all hover:bg-slate-100 hover:text-slate-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Profil Saya
                        </a>
                    </nav>
                </div>
            </aside>

            <section id="feedContainer" class="lg:col-span-6 space-y-8">
                <div class="relative overflow-hidden rounded-[32px] bg-white border border-slate-200 p-8 shadow-sm">
                    <h1 class="text-2xl font-extrabold text-slate-900">Halo, Yaza! 👋</h1>
                    <p class="text-sm text-slate-500 mt-1">Postingan Anda akan tersimpan secara permanen di browser ini.</p>
                </div>

                <div id="postList" class="space-y-8"></div>
            </section>
        </div>
    </main>

    <div id="uploadModal" class="fixed inset-0 z-[60] hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div class="w-full max-w-lg rounded-[32px] bg-white p-8 shadow-2xl">
            <h3 class="text-xl font-bold mb-6">Posting Konten Baru</h3>
            <div id="previewArea" class="mb-4 rounded-2xl bg-slate-50 border-2 border-dashed border-slate-200 min-h-[150px] flex items-center justify-center overflow-hidden italic text-slate-400 text-xs text-center p-4"></div>
            <textarea id="captionText" rows="3" class="w-full rounded-2xl border border-slate-200 p-4 text-sm outline-none focus:border-violet-500" placeholder="Tulis caption..."></textarea>
            <button id="submitUpload" class="mt-6 w-full rounded-2xl bg-violet-600 py-4 text-sm font-bold text-white hover:bg-violet-700 transition-all">Posting Sekarang</button>
            <button id="closeModal" class="w-full mt-2 text-sm text-slate-400 font-medium py-2">Batal</button>
        </div>
    </div>

    <script>
        const uploadBtn = document.getElementById('uploadBtn');
        const fileInput = document.getElementById('fileInput');
        const uploadModal = document.getElementById('uploadModal');
        const closeModal = document.getElementById('closeModal');
        const submitUpload = document.getElementById('submitUpload');
        const previewArea = document.getElementById('previewArea');
        const postList = document.getElementById('postList');
        const captionText = document.getElementById('captionText');

        let currentFileData = ""; // Menampung Base64
        let currentFileType = "";
        let currentFileName = "";

        // 1. Ambil data dari LocalStorage saat pertama kali load
        window.addEventListener('load', () => {
            const savedPosts = JSON.parse(localStorage.getItem('learnloop_posts')) || [];
            savedPosts.forEach(post => {
                createPostElement(post);
            });
        });

        // 2. Klik tombol Upload
        uploadBtn.addEventListener('click', () => fileInput.click());

        // 3. Proses File yang dipilih (Ubah ke Base64)
        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                currentFileType = file.type;
                currentFileName = file.name;
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    currentFileData = e.target.result; // Ini adalah string permanen
                    
                    if (file.type.startsWith('image/')) {
                        previewArea.innerHTML = `<img src="${currentFileData}" class="w-full h-full object-cover">`;
                    } else if (file.type.startsWith('video/')) {
                        previewArea.innerHTML = `<video src="${currentFileData}" class="w-full h-full object-cover" autoplay muted loop></video>`;
                    } else {
                        previewArea.innerHTML = `<div class="font-bold text-violet-600">📄 ${file.name} (PDF)</div>`;
                    }
                    uploadModal.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        // 4. Klik tombol "Posting Sekarang"
        submitUpload.addEventListener('click', () => {
            if (!captionText.value.trim()) return alert("Isi caption dulu!");

            const newPost = {
                id: Date.now(),
                caption: captionText.value,
                media: currentFileData,
                type: currentFileType,
                name: currentFileName,
                date: "Baru saja"
            };

            // Simpan ke LocalStorage
            const savedPosts = JSON.parse(localStorage.getItem('learnloop_posts')) || [];
            savedPosts.unshift(newPost);
            localStorage.setItem('learnloop_posts', JSON.stringify(savedPosts));

            // Tampilkan di UI
            createPostElement(newPost, true);

            // Reset
            uploadModal.classList.add('hidden');
            captionText.value = "";
            fileInput.value = "";
            currentFileData = "";
        });

        // 5. Fungsi membuat elemen HTML postingan
        function createPostElement(post, isNew = false) {
            const article = document.createElement('article');
            article.setAttribute('data-id', post.id);
            article.className = `card-hover overflow-hidden rounded-[32px] border border-slate-200 bg-white mb-8 ${isNew ? 'animate-fade-in' : ''}`;
            
            let mediaSection = "";
            if (post.type.startsWith('image/')) {
                mediaSection = `<img src="${post.media}" class="h-full w-full object-cover">`;
            } else if (post.type.startsWith('video/')) {
                mediaSection = `<video src="${post.media}" controls class="w-full h-full object-cover"></video>`;
            } else {
                mediaSection = `
                    <div class="flex flex-col items-center justify-center gap-3 p-8 bg-violet-50 w-full h-full">
                        <span class="text-xs font-bold text-violet-700">${post.name}</span>
                        <a href="${post.media}" download="${post.name}" class="rounded-xl bg-violet-600 px-4 py-2 text-[10px] text-white font-bold">DOWNLOAD PDF</a>
                    </div>`;
            }

            article.innerHTML = `
                <div class="flex items-center justify-between p-5">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name=Yaza&background=8b5cf6&color=ffffff&rounded=true" class="h-11 w-11 rounded-xl" />
                        <div>
                            <p class="text-sm font-bold text-slate-900">Yaza (Anda)</p>
                            <p class="text-[11px] text-slate-400 uppercase font-medium">${post.date}</p>
                        </div>
                    </div>
                    <button onclick="hapusPost(${post.id})" class="text-slate-300 hover:text-red-500 transition-colors p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </div>
                <div class="px-5 pb-4 text-sm text-slate-700">${post.caption}</div>
                <div class="mx-5 mb-5 h-80 overflow-hidden rounded-2xl bg-slate-100 flex items-center justify-center border border-slate-50">
                    ${mediaSection}
                </div>
            `;

            if (isNew) {
                postList.prepend(article);
            } else {
                postList.appendChild(article);
            }
        }

        // 6. Fungsi Hapus Postingan
        window.hapusPost = function(id) {
            if (confirm("Hapus postingan ini secara permanen?")) {
                // Hapus dari LocalStorage
                let savedPosts = JSON.parse(localStorage.getItem('learnloop_posts')) || [];
                savedPosts = savedPosts.filter(p => p.id !== id);
                localStorage.setItem('learnloop_posts', JSON.stringify(savedPosts));

                // Hapus dari layar
                const elemen = document.querySelector(`article[data-id="${id}"]`);
                if (elemen) elemen.remove();
            }
        }

        closeModal.addEventListener('click', () => uploadModal.classList.add('hidden'));
    </script>
</body>
</html>
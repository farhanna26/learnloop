<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LearnLoop | Upload Karya Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        .card-upload {
            background: #ffffff;
            border-radius: 2.25rem;
            border: 2px solid #e2e8f0;
            box-shadow: 0px 14px 0px #cbd5e1;
        }
        .btn-submit {
            background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
            border: 2px solid #4c1d95;
            box-shadow: 0px 6px 0px #4c1d95;
            transition: all 0.15s ease;
        }
        .btn-submit:active { transform: translateY(6px); box-shadow: 0px 0px 0px #4c1d95; }
        .btn-submit:disabled { opacity: 0.6; cursor: not-allowed; }
        
        .btn-cancel {
            background: #ffffff;
            border: 2px solid #cbd5e1;
            box-shadow: 0px 5px 0px #cbd5e1;
            transition: all 0.15s ease;
        }
        .btn-cancel:active { transform: translateY(5px); box-shadow: 0px 0px 0px #cbd5e1; }
    </style>
</head>
<body class="min-h-screen bg-[#f0f2fe] flex items-center justify-center p-4 antialiased font-sans">

    <div class="w-full max-w-2xl card-upload p-8 md:p-10">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-extrabold text-purple-950 tracking-tight">➕ Upload Karya Baru</h1>
                <p class="text-xs text-slate-500 font-semibold mt-1">Bagikan hasil riset, codingan, atau portofolio tugasmu ke komunitas.</p>
            </div>
            <span class="text-3xl">🚀</span>
        </div>

        <div id="alertBox" class="hidden mb-6 p-4 rounded-2xl text-xs font-bold"></div>

        <form id="uploadForm" class="space-y-6">
            <div class="flex flex-col space-y-2">
                <label for="type" class="text-xs font-black text-purple-950 uppercase tracking-wider">Kategori Konten</label>
                <select name="type" id="type" class="w-full p-4 text-sm font-semibold text-slate-800 bg-slate-50 border-2 border-slate-200 rounded-2xl focus:outline-none focus:border-brand">
                    <option value="portfolio">💼 Karya / Portofolio</option>
                    <option value="learning">📘 Materi Pembelajaran</option>
                </select>
            </div>

            <div class="flex flex-col space-y-2">
                <label for="content" class="text-xs font-black text-purple-950 uppercase tracking-wider">Detail atau Deskripsi Karya</label>
                <textarea 
                    name="content" 
                    id="content" 
                    rows="5" 
                    required
                    placeholder="Contoh: Berhasil menyelesaikan desain interface platform LearnLoop menggunakan Tailwind CSS..."
                    class="w-full p-5 text-sm font-semibold text-slate-800 placeholder-slate-400 bg-slate-50 border-2 border-slate-200 rounded-2xl focus:outline-none focus:border-purple-500 transition-colors"
                ></textarea>
            </div>

            <div class="p-4 bg-purple-50/60 border border-purple-100 rounded-2xl space-y-3" x-data="{ createClass: false }">
                <div class="flex items-center gap-2.5">
                    <input type="checkbox" name="create_class" id="create_class" value="true" class="w-4 h-4 text-purple-600 border-slate-300 rounded focus:ring-purple-500" onchange="toggleClassInput(this)">
                    <label for="create_class" class="text-xs font-bold text-purple-950 cursor-pointer select-none">Sekaligus buat Ruang Kelas Kolaboratif untuk karya ini</label>
                </div>
                <div id="classNameWrapper" class="hidden flex flex-col space-y-2 pt-2">
                    <label for="class_name" class="text-[11px] font-black text-purple-800 uppercase tracking-wide">Nama Ruang Kelas</label>
                    <input type="text" name="class_name" id="class_name" placeholder="Misal: Kelompok Riset AI Terdistribusi" class="w-full p-3 text-xs font-semibold text-slate-800 bg-white border border-slate-200 rounded-xl focus:outline-none focus:border-purple-500">
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 pt-2">
                <button type="submit" id="submitBtn" class="btn-submit w-full sm:w-auto px-8 py-4 text-xs font-black text-white rounded-xl uppercase tracking-widest text-center">
                    Publish Karya
                </button>
                <a href="/beranda" class="btn-cancel w-full sm:w-auto px-8 py-4 text-xs font-black text-slate-600 rounded-xl uppercase tracking-widest text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>

    <script>
        // Toggle input nama kelas jika checkbox dicentang
        function toggleClassInput(checkbox) {
            const wrapper = document.getElementById('classNameWrapper');
            const input = document.getElementById('class_name');
            if (checkbox.checked) {
                wrapper.classList.remove('hidden');
                input.setAttribute('required', 'required');
            } else {
                wrapper.classList.add('hidden');
                input.removeAttribute('required');
                input.value = '';
            }
        }

        // Handle AJAX submission ke PostController
        document.getElementById('uploadForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submitBtn');
            const alertBox = document.getElementById('alertBox');
            
            // Loading State
            submitBtn.disabled = true;
            submitBtn.innerText = 'MEMPUBLIKASIKAN...';
            
            // Siapkan Data Form
            const formData = new FormData(this);
            
            try {
                const response = await fetch('/posts', {
                    method: 'POST',
                    headers: {
                        'X-CSR-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const result = await response.json();

                if (response.status === 201 || result.success) {
                    // Berhasil dimasukkan ke database
                    alertBox.className = "mb-6 p-4 bg-green-50 border-2 border-green-200 text-green-700 rounded-2xl text-xs font-bold";
                    alertBox.innerHTML = "🎉 Sukses! " + result.message;
                    alertBox.classList.remove('hidden');
                    
                    // Kembalikan ke halaman beranda/feed utama setelah 1.5 detik
                    setTimeout(() => {
                        window.location.href = '/beranda';
                    }, 1500);
                } else {
                    // Validasi gagal atau error lainnya dari controller
                    throw new Error(result.message || 'Gagal mempublikasikan karya.');
                }

            } catch (error) {
                alertBox.className = "mb-6 p-4 bg-red-50 border-2 border-red-200 text-red-600 rounded-2xl text-xs font-bold";
                alertBox.innerHTML = "⚠️ " + error.message;
                alertBox.classList.remove('hidden');
                
                // Reset tombol jika gagal
                submitBtn.disabled = false;
                submitBtn.innerText = 'PUBLISH KARYA';
            }
        });
    </script>
</body>
</html>
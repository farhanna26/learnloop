<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Temen LearnLoop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">

    <div class="max-w-xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Cari Temen Baru</h2>

        <div class="flex space-x-2 mb-6">
            <input type="text" id="search-input" placeholder="Ketik nama (misal: Dihan)..." 
                   class="flex-1 px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" autocomplete="off">
        </div>

        <div id="search-results">
            </div>
        
        <div class="mt-6 text-center">
            <a href="/beranda" class="text-blue-600 hover:underline text-sm">Kembali</a>
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('search-input');
        const searchResults = document.getElementById('search-results');

        // Fungsi ini jalan setiap kali lu ngetik huruf di inputan
        searchInput.addEventListener('input', function() {
            const keyword = this.value;

            // Kalau kotak pencarian kosong, bersihin layarnya
            if (keyword.length === 0) {
                searchResults.innerHTML = '';
                return;
            }

            // Nembak diem-diem ke Controller pake Fetch API
            fetch(`/search?q=${keyword}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest' // Ngasih tau Controller kalau ini request AJAX
                }
            })
            .then(response => response.json())
            .then(users => {
                // Kalau orangnya gak ketemu
                if (users.length === 0) {
                    searchResults.innerHTML = `<p class="text-center text-red-500 font-medium py-2">Yah, orangnya kagak ketemu bos!</p>`;
                    return;
                }

                // Kalau ketemu, kita rakit HTML-nya
                let html = `<p class="text-sm text-gray-500 mb-4">Hasil pencarian buat: <strong>"${keyword}"</strong></p>`;
                html += `<ul class="space-y-3">`;
                
                users.forEach(user => {
                    html += `
                        <li class="flex items-center justify-between p-3 bg-gray-50 rounded border border-gray-200">
                            <span class="font-semibold text-gray-800">${user.name}</span>
                            <a href="/profile/${user.id}" class="px-3 py-1 bg-gray-600 hover:bg-gray-700 text-white text-xs font-bold rounded">
                                Lihat Profil
                            </a>
                        </li>
                    `;
                });
                
                html += `</ul>`;

                // Tembakin hasil rakitannya ke layar
                searchResults.innerHTML = html;
            });
        });
    </script>
</body>
</html>
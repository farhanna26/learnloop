<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Meta Token ini WAJIB buat ngirim data ke Laravel -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LearnLoop Live Chat</title>
    <!-- Panggil Vite biar Echo dan Tailwind jalan -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Panggil Tailwind CSS via CDN (buat testing cepet) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex flex-col items-center justify-center">

    <div class="w-full max-w-2xl bg-white rounded-lg shadow-xl overflow-hidden flex flex-col h-[80vh]">
        <!-- Header -->
        <div class="bg-blue-600 text-white px-4 py-3 font-bold text-lg">
            LearnLoop Real-time Room
        </div>

        <!-- Area Pesan (Kotak Chat) -->
        <div id="chat-box" class="flex-1 p-4 overflow-y-auto space-y-3 bg-gray-50">
            @foreach($messages as $msg)
                <div class="bg-white p-3 rounded shadow-sm border border-gray-200">
                    <span class="font-bold text-blue-600">{{ $msg->username }}:</span> 
                    <span class="text-gray-800">{{ $msg->text }}</span>
                </div>
            @endforeach
        </div>

        <!-- Area Input -->
        <div class="bg-gray-200 p-4">
            <form id="chat-form" class="flex space-x-2">
                <input type="text" id="username" placeholder="Nama lu..." class="w-1/4 px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <input type="text" id="message-text" placeholder="Ketik pesan..." class="flex-1 px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required autocomplete="off">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition-colors">
                    Kirim
                </button>
            </form>
        </div>
    </div>

   <!-- Logika JavaScript-nya -->
    <script type="module">
        const chatBox = document.getElementById('chat-box');
        const chatForm = document.getElementById('chat-form');
        const usernameInput = document.getElementById('username');
        const textInput = document.getElementById('message-text');
        
        // Ambil token keamanan Laravel biar diizinin masuk ke Controller
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Biar scroll otomatis ke bawah pas halaman dibuka
        chatBox.scrollTop = chatBox.scrollHeight;

        // 1. NANGKEP SINYAL DARI REVERB (WEBSOCKET)
        window.Echo.channel('chat-channel')
            .listen('.message.sent', (e) => {
                const newChat = document.createElement('div');
                newChat.className = 'bg-white p-3 rounded shadow-sm border border-gray-200 mb-3';
                newChat.innerHTML = `<span class="font-bold text-blue-600">${e.message.split(' bilang: ')[0]}:</span> <span class="text-gray-800">${e.message.split(' bilang: ')[1]}</span>`;
                
                chatBox.appendChild(newChat);
                chatBox.scrollTop = chatBox.scrollHeight;
            });

        // 2. NGIRIM PESAN KE CONTROLLER PAKE FETCH (BAWAAN BROWSER)
        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const user = usernameInput.value;
            const text = textInput.value;

            // Kirim paketnya
            fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    username: user,
                    text: text
                })
            })
            .then(response => response.json())
            .then(data => {
                // Kalau sukses kekirim, hapus teks yang diketik biar rapi
                textInput.value = '';
            })
            .catch(error => {
                console.error('Waduh gagal ngirim:', error);
            });
        });
    </script>
</body>
</html>
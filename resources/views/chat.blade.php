<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LearnLoop Live Chat</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex flex-col items-center justify-center">

    <div class="w-full max-w-2xl bg-white rounded-lg shadow-xl overflow-hidden flex flex-col h-[80vh]">
        <div class="bg-blue-600 text-white px-4 py-3 font-bold text-lg flex justify-between">
            <span>LearnLoop Room: {{ $room->name ?? 'Private Chat' }}</span>
            <span class="text-sm font-normal bg-blue-800 px-2 rounded">Room ID: {{ $room->id }}</span>
        </div>

        <div id="chat-box" class="flex-1 p-4 overflow-y-auto space-y-3 bg-gray-50">
            @foreach($messages as $msg)
                <div class="bg-white p-3 rounded shadow-sm border border-gray-200">
                    <span class="font-bold text-blue-600">{{ $msg->username ?? 'Anonim' }}:</span> 
                    <span class="text-gray-800">{{ $msg->text }}</span>
                </div>
            @endforeach
        </div>

        <div class="bg-gray-200 p-4">
            <form id="chat-form" class="flex space-x-2">
                <div class="hidden md:flex px-4 py-2 bg-gray-300 text-gray-700 font-semibold border border-gray-400 rounded items-center select-none w-1/4 truncate">
                    {{ Auth::user()->name }}
                </div>
                
                <input type="text" id="message-text" placeholder="Ketik pesan..." 
                    class="flex-1 px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    required autocomplete="off">
                
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition-colors">
                    Kirim
                </button>
            </form>
        </div>
    </div>

    <script type="module">
        const chatBox = document.getElementById('chat-box');
        const chatForm = document.getElementById('chat-form');
        const textInput = document.getElementById('message-text');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Auto-scroll ke bawah saat loading awal
        chatBox.scrollTop = chatBox.scrollHeight;

        // 1. MENDENGARKAN REAL-TIME BROADCAST (REVERB/PUSHER)
        window.Echo.channel('chat-channel')
            .listen('.message.sent', (e) => {
                const newChat = document.createElement('div');
                newChat.className = 'bg-white p-3 rounded shadow-sm border border-gray-200 mb-3';
                
                // Pastikan struktur e.username dan e.message sesuai dengan Event MessageSent.php kamu
                newChat.innerHTML = `
                    <span class="font-bold text-blue-600">${e.username}:</span> 
                    <span class="text-gray-800">${e.message}</span>
                `;
                
                chatBox.appendChild(newChat);
                chatBox.scrollTop = chatBox.scrollHeight;
            });

        // 2. MENGIRIM PESAN
        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const text = textInput.value;
            if (!text.trim()) return; // Jangan kirim kalau kosong

            fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                // Kirim pesannya dan kirim ID kamarnya!
                body: JSON.stringify({
                    message: text,
                    room_id: roomId 
                })
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                textInput.value = ''; // Kosongkan input setelah sukses
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal mengirim pesan. Coba lagi.');
            });
        });
    </script>
</body>
</html>
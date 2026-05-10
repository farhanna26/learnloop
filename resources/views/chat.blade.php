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
                <input type="hidden" id="room-id" value="{{ $room->id }}"> 

                <div class="px-4 py-2 bg-gray-300 text-gray-700 font-semibold border border-gray-400 rounded flex items-center select-none w-1/4 truncate">
                    {{ Auth::user()->name }}
                </div>
                
                <input type="text" id="message-text" placeholder="Ketik pesan..." class="flex-1 px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required autocomplete="off">
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
        
        // Ambil ID Kamar dari elemen hidden yang udah kita siapin di atas
        const roomId = document.getElementById('room-id').value; 
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        chatBox.scrollTop = chatBox.scrollHeight;

        // 1. NANGKEP SINYAL (SESUAI ID KAMAR)
        // Kita ganti 'channel' biasa jadi 'private', dan tempelin roomId-nya
        window.Echo.private(`chat.room.${roomId}`) 
                .listen('.message.sent', (e) => {
                const newChat = document.createElement('div');
                newChat.className = 'bg-white p-3 rounded shadow-sm border border-gray-200 mb-3';
    
                newChat.innerHTML = `<span class="font-bold text-blue-600">${e.username}:</span> <span class="text-gray-800">${e.message}</span>`;
    
                chatBox.appendChild(newChat);
                chatBox.scrollTop = chatBox.scrollHeight;
            });

        // 2. NGIRIM PESAN (SEKALIAN BAWA KUNCI KAMAR)
        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const text = textInput.value;

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
            .then(response => response.json())
            .then(data => {
                textInput.value = '';
            })
            .catch(error => {
                console.error('Waduh gagal ngirim:', error);
            });
        });
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kontak LearnLoop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">

    <div class="max-w-xl mx-auto bg-white rounded-lg shadow-md p-6">
        
        <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Grup Lu</h2>
        <ul class="space-y-4 mb-8">
            @forelse($groups as $group)
                <li class="flex items-center justify-between p-4 bg-blue-50 rounded-lg border border-blue-200 hover:bg-blue-100 transition">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xl">
                            G
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">{{ $group->name }}</p>
                            <p class="text-sm text-blue-600 font-medium">Group Chat</p>
                        </div>
                    </div>
                    <a href="/chat/{{ $group->id }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-md shadow transition">
                        Buka Grup
                    </a>
                </li>
            @empty
                <li class="text-center text-gray-500 py-4">Lu belum masuk grup mana-mana bos.</li>
            @endforelse
        </ul>

        <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Mau nge-chat siapa hari ini?</h2>
        <ul class="space-y-4">
            @forelse($users as $user)
                <li class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100 transition">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 rounded-full bg-gray-500 flex items-center justify-center text-white font-bold text-xl">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                        </div>
                    </div>
                    <a href="/chat/private/{{ $user->id }}" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-bold rounded-md shadow transition">
                        Kirim Pesan
                    </a>
                </li>
            @empty
                <li class="text-center text-gray-500 py-4">Belum ada user lain di database lu bos.</li>
            @endforelse
        </ul>

        <div class="mt-8 text-center">
            <a href="/beranda" class="text-blue-600 hover:underline text-sm">Kembali ke Beranda</a>
        </div>
    </div>

</body>
</html>
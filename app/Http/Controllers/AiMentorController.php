<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\AiChat;
use App\Models\AiMessage;

class AiMentorController extends Controller
{
    // 1. Nampilin Halaman UI beserta list history dari database
    public function index(Request $request)
    {
        // Ambil semua history chat milik user yang lagi login
        $chats = AiChat::where('user_id', auth()->id())
            ->orderBy('is_pinned', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();

        // Kalo user lagi ngeklik salah satu history, ambil isi chatnya
        $activeChat = null;
        if ($request->has('chat_id')) {
            $activeChat = AiChat::with('messages')
                ->where('user_id', auth()->id())
                ->find($request->chat_id);
        }

        return view('ai-mentor', compact('chats', 'activeChat'));
    }

    // 2. Fungsi menerima pesan, kelola memori database, dan dapatkan jawaban AI
    public function ask(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'chat_id' => 'nullable|integer'
        ]);

        $user = auth()->user();
        $apiKey = env('GEMINI_API_KEY');
        $model = env('GEMINI_MODEL', 'gemini-3.5-flash');

        // A. Logika Sesi Chat (Bikin baru atau pake yang lama)
        $isNewChat = false;
        if ($request->filled('chat_id')) {
            $chat = AiChat::where('user_id', $user->id)->find($request->chat_id);
            if (!$chat) {
                return response()->json(['success' => false, 'message' => 'Sesi chat gak ketemu beb!'], 404);
            }
        } else {
            // Kalo chat_id kosong, berarti user buka chat baru
            $chat = AiChat::create([
                'user_id' => $user->id,
                'title' => 'New Chat',
                'is_pinned' => false
            ]);
            $isNewChat = true;
        }

        // B. Simpan Pesan User ke Database
        AiMessage::create([
            'ai_chat_id' => $chat->id,
            'role' => 'user',
            'content' => $request->message
        ]);

        // C. Tarik Riwayat Pesan Sebelumnya buat Konteks Memori AI
        $previousMessages = AiMessage::where('ai_chat_id', $chat->id)
            ->orderBy('created_at', 'asc')
            ->get();

        // D. Racik System Prompt + Gabungin Riwayat Chat
        $systemPrompt = "Kamu BUKAN asisten virtual biasa. Kamu adalah teman sekelas User di Universitas Lampung, namamu Amalia, jurusan Teknik Informatika. " .
                        "Kamu bertindak sebagai Mentor AI yang super jago koding, tapi gaya bicaramu SANGAT natural, santai, dan persis seperti anak kuliahan yang lagi nongkrong ngerjain tugas. " .
                        "Gunakan 'lo/gue'. " .
                        "JANGAN PERNAH menyapa dengan kalimat kaku seperti 'Halo, ada yang bisa gue bantu?'. Mulailah obrolan dengan santai, seolah kalian sudah kenal lama. " .
                        "Jika user nge-troll atau bercanda, balas dengan sarkasme ringan yang lucu, BUKAN dengan jawaban formal. " .
                        "Jika user bertanya soal kodingan (Laravel, PHP, Tailwind), berikan penjelasan layaknya teman yang mengajari temannya H-1 sebelum deadline tugas: *to the point*, praktis, dan nggak bertele-tele.";

        // Kita susun riwayatnya biar AI paham kronologinya
        $historyText = "";
        foreach ($previousMessages as $msg) {
            $speaker = $msg->role === 'user' ? 'User' : 'AI Mentor';
            $historyText .= "{$speaker}: {$msg->content}\n";
        }

        $promptGabungan = $systemPrompt . "\n\nBerikut adalah riwayat percakapan kita sejauh ini:\n" . $historyText . 
                          "\nPertanyaan/Respon terbaru dari User: " . $request->message;

        try {
            // E. Tembak ke API Murni Gemini
            $response = Http::withoutVerifying()
                ->timeout(60)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}", [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $promptGabungan]
                            ]
                        ]
                    ]
                ]);

            $result = $response->json();

            if (isset($result['error'])) {
                return response()->json(['success' => false, 'message' => $result['error']['message']], 500);
            }

            $jawabanAi = $result['candidates'][0]['content']['parts'][0]['text'] ?? 'Aduh beb, otak gue rada nge-blank. Nanya lagi dong.';

            // F. Simpan Balasan AI ke Database
            AiMessage::create([
                'ai_chat_id' => $chat->id,
                'role' => 'model',
                'content' => $jawabanAi
            ]);

            // G. JURUS OTOMATIS BIKIN JUDUL CHAT (Cuma jalan di chat baru)
            $newTitle = $chat->title;
            if ($isNewChat) {
                $titlePrompt = "Rangkum pesan user berikut menjadi sebuah judul topik obrolan pendek yang padat berisi 3-5 kata saja. JANGAN gunakan tanda kutip, jangan pakai kata pengantar, langsung berikan hasil rangkumannya saja.\n\nPesan: " . $request->message;
                
                $titleResponse = Http::withoutVerifying()
                    ->timeout(15)
                    ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}", [
                        'contents' => [[
                            'parts' => [['text' => $titlePrompt]]
                        ]]
                    ]);
                
                $titleResult = $titleResponse->json();
                $generatedTitle = $titleResult['candidates'][0]['content']['parts'][0]['text'] ?? null;
                
                if ($generatedTitle) {
                    // Bersihin tanda baca yang mengganggu
                    $newTitle = trim(str_replace(['"', "'", "\n"], '', $generatedTitle));
                    $chat->update(['title' => $newTitle]);
                }
            }

            // Touch chat biar updated_at berubah dan otomatis naik ke atas list history
            $chat->touch();

            return response()->json([
                'success' => true,
                'chat_id' => $chat->id,
                'title' => $newTitle,
                'data' => $jawabanAi
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal kontak server AI: ' . $e->getMessage()], 500);
        }
    }

    // 3. Fungsi Tambahan buat nge-Pin / Unpin Chat Sesi
    public function togglePin($id)
    {
        $chat = AiChat::where('user_id', auth()->id())->findOrFail($id);
        $chat->update(['is_pinned' => !$chat->is_pinned]);
        return response()->json(['success' => true, 'is_pinned' => $chat->is_pinned]);
    }

    // 4. Fungsi Tambahan buat ngehapus satu Sesi Chat
    public function deleteChat($id)
    {
        $chat = AiChat::where('user_id', auth()->id())->findOrFail($id);
        $chat->delete();
        return response()->json(['success' => true]);
    }
}
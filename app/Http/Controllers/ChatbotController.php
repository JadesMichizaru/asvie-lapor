<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ChatbotResponses;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function ask(Request $request)
        {
            $message = strtolower(trim($request->input('message', '')));

            if (empty($message)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesan tidak boleh kosong',
                ], 422);
            }

            $botResponse = ChatbotResponses::where('keyword', 'LIKE', "%{$message}%")
                ->orWhereRaw('? LIKE \'%\' || keyword || \'%\'', [$message])
                ->first();

            if ($botResponse) {
                return response()->json([
                    'success' => true,
                    'reply' => $botResponse->response,
                ], 200);
            }

            return response()->json([
                'success' => true,
                'reply' => 'Maaf, saya belum memahami pertanyaan Anda. Silakan tanyakan hal lain atau buat pengaduan langsung melalui form.',
            ], 200);
        }
}

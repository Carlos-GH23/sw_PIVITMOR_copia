<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatBotController extends Controller
{
    use ApiResponse;
    private string $replyFailed = 'El chatbot no está disponible en este momento. Intenta más tarde.';

    public function process(Request $request)
    {
        set_time_limit(120);

        $validated = $request->validate([
            'message' => 'required|string|max:2555',
        ]);

        $url = config('services.chatbot.url');

        return response()->stream(function () use ($url, $validated) {
            // 1. Apagar buffers de PHP
            if (ob_get_level()) ob_end_clean();

            try {
                $response = Http::withOptions([
                    'stream' => true,
                    'timeout' => 120, // Importante para CPU-only
                ])->post("{$url}/chat", [
                    'pregunta' => $validated['message'],
                ]);

                $body = $response->toPsrResponse()->getBody();

                while (!$body->eof()) {
                    // 2. Leer paquetes pequeños para fluidez visual
                    $chunk = $body->read(8);

                    if ($chunk) {
                        echo $chunk;

                        // 3. Forzar salida inmediata
                        if (ob_get_level() > 0) ob_flush();
                        flush();
                    }
                }
            } catch (\Exception $e) {
                Log::error('ChatBot Error: ' . $e->getMessage());
                echo " [Error al generar respuesta]";
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'X-Accel-Buffering' => 'no',
            'Connection' => 'keep-alive',
        ]);
    }
}

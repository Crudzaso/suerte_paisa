<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http; 
use Illuminate\Support\Facades\Log;

class DiscordHelper
{
    public static function sendMessage($message)
    {
        $webhookUrl = env('DISCORD_WEBHOOK_URL');

        $response = Http::post($webhookUrl, [
            'content' => $message,
        ]);

        if (!$response->successful()) {
            Log::error('Error al enviar mensaje a Discord:', ['response' => $response->body()]);
        }
    }
}

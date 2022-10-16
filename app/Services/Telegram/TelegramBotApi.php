<?php

namespace App\Services\Telegram;

use App\Exceptions\TelegramLogException;
use Illuminate\Support\Facades\Http;

class TelegramBotApi
{
    public const HOST = 'https://api.telegram.org/bot';

    public static function sendMessage(string $token, int $chatId, string $text): bool
    {
        try {
            $response = Http::get(self::HOST.$token.'/sendMessage', [
                'chat_id' => $chatId,
                'text' => $text,
            ]);

            return $response->status() == 200;
        } catch (TelegramLogException $e) {
            return $e->getMessage();
        }
    }

}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TelegramApiRequest;
use App\Http\Resources\TelegramApiResource;
use MohsenNajafizadeh\TelegramNotifier\Exceptions\TelegramException;
use MohsenNajafizadeh\TelegramNotifier\Telegram;

class TelegramController extends Controller
{
    /**
     * @throws TelegramException
     */
    public function sendMessage(TelegramApiRequest $request)
    {
        $params = $request->only(['message', 'botToken', 'chatId', 'parseMode']);
        $response = Telegram::sendMessage(...$params);
        return response()->json(
            new TelegramApiResource($response),200
        );
    }
}

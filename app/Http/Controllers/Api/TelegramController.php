<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TelegramApiRequest;
use App\Http\Resources\TelegramApiResource;
use Illuminate\Http\JsonResponse;
use MohsenNajafizadeh\TelegramNotifier\Exceptions\TelegramException;
use MohsenNajafizadeh\TelegramNotifier\Telegram;

class TelegramController extends Controller
{
    /**
     * Send a message via Telegram API.
     *
     * @OA\Post(
     *     path="/telegram",
     *     summary="Send a message through Telegram",
     *     description="Sends a message to a specific chat using Telegram Bot API.",
     *     tags={"Telegram"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"message", "botToken", "chatId"},
     *             @OA\Property(property="message", type="string", example="Hello, world!", description="Message to be sent."),
     *             @OA\Property(property="botToken", type="string", example="123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11", description="Bot token from Telegram."),
     *             @OA\Property(property="chatId", type="string", example="12345678", description="Unique identifier for the target chat."),
     *             @OA\Property(property="parseMode", type="string", example="Markdown", description="Text formatting mode (e.g., Markdown, HTML).")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Message sent successfully.",
     *         @OA\JsonContent(
     *             @OA\Property(property="header-code", type="integer", example=200, description="HTTP status code."),
     *             @OA\Property(property="status", type="string", example="success", description="Request status."),
     *             @OA\Property(property="message", type="string", example="Message sent successfully.", description="Detailed response message."),
     *             @OA\Property(property="data", type="object", description="Response data from Telegram.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request.",
     *         @OA\JsonContent(
     *             @OA\Property(property="header-code", type="integer", example=400),
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Invalid input provided."),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized.",
     *         @OA\JsonContent(
     *             @OA\Property(property="header-code", type="integer", example=401),
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Unauthorized: Invalid access token."),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     *
     * @param TelegramApiRequest $request
     * @return JsonResponse
     * @throws TelegramException
     */
    public function sendMessage(TelegramApiRequest $request): JsonResponse
    {
        $params = $request->only(['message', 'botToken', 'chatId', 'parseMode']);
        $response = Telegram::sendMessage(...$params);
        return response()->json(
            new TelegramApiResource($response)
        );
    }
}

<?php

namespace App\Http\Middleware;

use App\Http\Resources\TelegramApiResource;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApiAccessToken
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @return JsonResponse
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        $validTokens = explode(',', env('API_ACCESS_TOKENS', ''));

        $accessToken = $request->header('Authorization');
        $accessToken = str_replace('Bearer ', '', $accessToken);
        if (!$accessToken || !in_array($accessToken, $validTokens)) {

            return response()->json(
                new TelegramApiResource([
                    'headerCode' => 401,
                    'status' => 'error',
                    'message' => 'Unauthorized: Invalid access token',
                    'data' => [],
                ]),
                401
            );
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $headerCode
 * @property mixed $status
 * @property mixed $message
 * @property mixed $data
 */
class TelegramApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'header-code' => $this->resource['headerCode'] ?? null,
            'status' => $this->resource['status'] ?? null,
            'message' => $this->resource['message'] ?? null,
            'data' => $this->resource['data'] ?? [],
        ];
    }
}

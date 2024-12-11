<?php

use App\Http\Controllers\Api\TelegramController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('check.api.token')->group(function () {
    Route::post('/telegram', [TelegramController::class, 'sendMessage']);
});

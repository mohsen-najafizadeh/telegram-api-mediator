<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="Telegram API Mediator",
 *     version="0.0.4",
 *     description="API documentation for Telegram API Mediator service.",
 *     @OA\Contact(
 *         email="your-email@example.com"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://localhost/api",
 *     description="Local server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="sha256",
 *     description="Enter your Bearer token here"
 * )
 */
abstract class Controller
{
    //
}

<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * @method getJson(string $string)
 */
class AuthenticationTest extends TestCase
{
    /**
     * Test that a request without API_ACCESS_TOKEN is rejected.
     */
    public function test_request_without_token_is_rejected()
    {
        // Send a POST request to a protected route without a token
        $response = $this->postJson('/api/telegram');

        // Assert the response status is 401
        $response->assertStatus(401);
    }

    /**
     * Test that a request with an invalid API_ACCESS_TOKEN is rejected.
     */
    public function test_request_with_invalid_token_is_rejected()
    {
        // Send a POST request to a protected route with an invalid token
        $response = $this->postJson('/api/telegram', [], [
            'Authorization' => 'InvalidToken'
        ]);

        // Assert the response status is 401
        $response->assertStatus(401);
    }

    /**
     * Test that a request with a valid API_ACCESS_TOKEN is accepted.
     */
    public function test_request_with_valid_token_is_accepted()
    {
        $validTokens = explode(',', env('API_ACCESS_TOKENS', ''));
        $validToken = $validTokens[0];

        $response = $this->postJson('/api/telegram', [], [
            'Authorization' => 'Bearer ' . $validToken,
        ]);

        $response->assertStatus(422);
    }
}

<?php

namespace Tests\Feature;

use Mockery;
use MohsenNajafizadeh\TelegramNotifier\Telegram;
use Tests\TestCase;

/**
 * @method postJson(string $string, string[] $array, string[] $array1)
 */
class ApiSendMessageTest extends TestCase
{
    /**
     * Data provider for testing different invalid parameters
     *
     * @return array
     */
    public static function errorParametersProvider(): array
    {
        return [
            'no_parameters' => [[], 422],
            'missing_message' => [['botToken' => 'validBotToken', 'chatId' => 'validChatId'], 422],
            'missing_botToken' => [['message' => 'Test message', 'chatId' => 'validChatId'], 422],
            'missing_chatId' => [['message' => 'Test message', 'botToken' => 'validBotToken'], 422],
            'invalid_parseMode' => [['message' => 'Test message', 'botToken' => 'validBotToken', 'chatId' =>
                'validChatId', 'parseMode' => 'InvalidMode'], 422],
            'invalid_botToken' => [['message' => 'Test message', 'botToken' => 'invalidBotToken', 'chatId' =>
                'validChatId'], 422],
            'invalid_chatId' => [['message' => 'Test message', 'botToken' => 'validBotToken', 'chatId' => 'invalidChatId'], 422],
        ];
    }

    /**
     * Test request with invalid parameters
     *
     * @dataProvider errorParametersProvider
     */
    public function test_request_with_invalid_parameters($params, $expectedStatus)
    {
        $validTokens = explode(',', env('API_ACCESS_TOKENS', ''));
        $validToken = $validTokens[0];

        $response = $this->postJson('/api/telegram', $params, [
            'Authorization' => 'Bearer ' . $validToken,
        ]);

        $response->assertStatus($expectedStatus);
    }

    /**
     * Data provider for testing different invalid parameters
     *
     * @return array
     */
    public static function successParseModeProvider(): array
    {
        return [
            'valid_parseMode_HTML' => ['success', ['message' => 'Test message', 'botToken' => 'validBotToken', 'chatId' =>
                'validChatId', 'parseMode' => 'HTML'], 200],
            'valid_parseMode_Markdown' => ['success', ['message' => 'Test message', 'botToken' => 'validBotToken', 'chatId' =>
                'validChatId', 'parseMode' => 'Markdown'], 200],
            'valid_parseMode_MarkdownV2' => ['success', ['message' => 'Test message', 'botToken' => 'validBotToken', 'chatId' =>
                'validChatId', 'parseMode' => 'MarkdownV2'], 200],
        ];
    }

    /**
     * Test request with valid parseMode
     *
     * @dataProvider successParseModeProvider
     */
    public function test_request_with_valid_parseMode($expectedStatus, $params, $expectedHeaderStatus )
    {
        $telegramMock = Mockery::mock(Telegram::class);
            $telegramMock->shouldReceive('sendMessage')
                ->once()
                ->with(
                    $params['message'],
                    $params['botToken'],
                    $params['chatId'],
                    $params['parseMode']
                )->andReturn([
                    'status' => $expectedStatus,
                    'headerCode' => $expectedHeaderStatus,
                ]);

        $this->app->instance(Telegram::class, $telegramMock);

        $validTokens = explode(',', env('API_ACCESS_TOKENS', ''));
        $validToken = $validTokens[0];

        $response = $this->postJson('/api/telegram', $params, [
            'Authorization' => 'Bearer ' . $validToken,
        ]);

        $response->assertStatus($expectedHeaderStatus);
    }

    /**
     * Test request with valid parameters
     */
    public function test_request_with_valid_parameters()
    {
        $params = [
            'message' => 'Test message',
            'botToken' => 'validBotToken',
            'chatId' => 'validChatId',
        ];
        $expectedStatus = 'success';
        $expectedHeaderStatus = 200;

        $telegramMock = Mockery::mock(Telegram::class);
            $telegramMock->shouldReceive('sendMessage')
                ->once()
                ->with(
                    $params['message'],
                    $params['botToken'],
                    $params['chatId'],
                )->andReturn([
                    'status' => $expectedStatus,
                    'headerCode' => $expectedHeaderStatus,
                ]);

        $this->app->instance(Telegram::class, $telegramMock);

        $validTokens = explode(',', env('API_ACCESS_TOKENS', ''));
        $validToken = $validTokens[0];

        $response = $this->postJson('/api/telegram', $params, [
            'Authorization' => 'Bearer ' . $validToken,
        ]);

        $response->assertStatus($expectedHeaderStatus);
    }

}

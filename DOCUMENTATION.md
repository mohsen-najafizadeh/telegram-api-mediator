# Telegram Api Mediator Documentation

## 1. Introduction

This project is designed to provide a streamlined way to send messages to Telegram using the Telegram Bot API. It is built on top of the [Telegram Notifier](https://github.com/mohsen-najafizadeh/telegram-notifier) package, a robust and easy-to-use PHP library for Telegram message communication.

---

## Send Simple Message By Telegram Api Mediator
### API Endpoint

To send a message, make a POST request to the following URL:

```
POST https://example-domain.com/api/telegram
```
### Example Request

Here’s an example of how your POST request should look:

### Request

```http
POST /api/telegram HTTP/1.1
Host: shilaei.com
Authorization: Bearer YOUR_API_TOKEN
Accept: application/json
Content-Type: application/json

{
    "message": "This message is being sent for testing the service.",
    "botToken": "YOUR_BOT_TOKEN",
    "chatId": "YOUR_CHAT_ID",
    "parseMode": "HTML"
}
```

---

## 1. API Methods

### sendMessage

Sends a message to Telegram.

#### Parameters

| Parameter       | Type            | Required | Description                                                                                                   |
|-----------------|-----------------|----------|---------------------------------------------------------------------------------------------------------------|
| `$message`      | `string`        | Yes      | The message text to send.                                                                                     |
| `$botToken`     | `string`        | Yes      | Your Telegram bot token. To create, visit [BotFather](https://t.me/BotFather).                                |
| `$chatId`       | `string`        | Yes      | The Chat ID that you want to send the message to                                                              |
| `$parseMode`    | `string`,`null` | No       | Text format (`HTML`, `Markdown` or `MarkdownV2`) [Read more.](https://core.telegram.org/bots/api#sendmessage) |


#### Response

An json response containing the following details:

- `header-code`: HTTP status code.
- `status`: Request status (`success` or `error`).
- `message`: Description of the send result.
- `data`: API response data (on success).

#### Success Example

```php
POST /api/telegram HTTP/1.1
Host: shilaei.com
Authorization: Bearer YOUR_API_TOKEN
Accept: application/json
Content-Type: application/json

{
    "message": "This message is being sent for testing the service.",
    "botToken": "YOUR_BOT_TOKEN",
    "chatId": "YOUR_CHAT_ID",
    "parseMode": "HTML"
}

// Output:
/*
json
(
    .
    .
    .
)
*/
```

#### Error Example

If the message fails to send:

```php
// Output:
/*
json
(
    .
    .
    .
)
*/
```

#### Common Issues and Troubleshooting

- Invalid Bot Token Error: Ensure your bot token is correctly generated from [BotFather](https://t.me/BotFather).
- Message Not Delivered: Verify that your bot has permission to send messages to the specified chat ID.
- **How to fix**: After creating your bot and adding it to the desired chat, you can retrieve the chat ID by visiting the following link, replacing `<YOUR_BOT_TOKEN>` with your actual bot token: [Learn more](https://core.telegram.org/bots/api#getupdates)
    ```
    https://api.telegram.org/bot<YOUR_BOT_TOKEN>/getUpdates
    ```

---

## 2. Error Requests

```php
POST /api/telegram HTTP/1.1
Host: shilaei.com
Authorization: Bearer YOUR_API_TOKEN
Accept: application/json
Content-Type: application/json

{
    "message": "This message is being sent for testing the service.",
    "botToken": "YOUR_BOT_TOKEN",
    "chatId": "YOUR_CHAT_ID",
    "parseMode": "HTML"
}

// Output:
/*
json
(
    .
    .
    .
)
*/
```

---

## 3. Tests

This package includes PHPUnit tests. Run the tests using:

```bash
 ???
```

---

## 4. Changelog

For details about version changes, see the [`CHANGELOG.md`](CHANGELOG.md) file.

---

## 5. Contributing

We welcome contributions! Please read the [`CONTRIBUTING.md`](CONTRIBUTING.md) file before submitting changes.

---

## 6. FAQ

### 1. Does this package support sending photos or files?

Currently, the package is designed for sending text messages only, but it is extendable.

### 2. How can I report issues?

Please report issues in the GitHub Issues section.

---

## 7. References

- [Telegram Bot API Documentation](https://core.telegram.org/bots/api)

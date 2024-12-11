
# Telegram Api Mediator
## About This Project

This project is designed to provide a streamlined way to send messages to Telegram using the Telegram Bot API. It is built on top of the [Telegram Notifier](https://github.com/mohsen-najafizadeh/telegram-notifier) package, a robust and easy-to-use PHP library for Telegram message communication.

#### Key Features:
- Utilizes the Telegram Notifier package for efficient API interactions.
- Pre-configured for seamless integration in Dockerized environments.
- Customizable to meet specific project requirements.

The integration with the Telegram Notifier package allows this project to handle message formatting, error management, and API communication effortlessly, making it a reliable solution for Telegram notifications.

## Installation and Usage

This project is optimized for use with Docker. You can easily set up and run this project in a Dockerized environment.  
For detailed setup instructions, refer to the [SETUP.md](SETUP.md) file to get started with Docker.


## API Endpoint

To send a message in Telegram, make a POST request to the following URL:

```
POST https://YOUR_DOMAIN.COM/api/telegram
```
For detailed documentation and examples, refer to the [Documentation](DOCUMENTATION.md) /  [Documentation that created by PHPDocumentor]().
___
## Contribution
If you want to contribute to the project, please read the [Contributing Guidelines](CONTRIBUTING.md).

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).

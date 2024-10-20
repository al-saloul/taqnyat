# Laravel Taqnyat SMS Package

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)

## Overview

The Laravel Taqnyat SMS package provides a simple integration with the [Taqnyat SMS API](https://www.taqnyat.sa) to send SMS messages directly from your Laravel application. It includes methods for sending SMS messages, querying your account balance, retrieving available senders, and checking the system status of Taqnyat.

## Features

- **Send SMS**: Send SMS messages to multiple recipients.
- **Account Balance**: Retrieve your Taqnyat account balance.
- **Available Senders**: Fetch the list of available sender names.
- **System Status**: Check the current status of the Taqnyat system.
- **Configurable**: Easily configure API authentication and default sender details.

## Requirements

- PHP >= 7.4
- Laravel 7.x, 8.x, 9.x, 10.x or 11.x
- [GuzzleHttp](https://github.com/guzzle/guzzle) for making HTTP requests.

## Installation

Install the package via Composer:

```bash
composer require al-saloul/taqnyat
```

After installing the package, publish the configuration file:

```bash
php artisan vendor:publish --provider="Alsaloul\Taqnyat\TaqnyatSmsServiceProvider"
```

This command will create the `config/taqnyat-sms.php` configuration file where you can set your API authentication and sender information.

## Configuration

After publishing the config file, update your `.env` file with your Taqnyat API credentials:

```dotenv
TAQNYAT_SMS_AUTH=your_api_key_here
TAQNYAT_SMS_SENDER=your_default_sender_name_here
TAQNYAT_SMS_BASE_URL=https://api.taqnyat.sa
```

### Config Options

- **`TAQNYAT_SMS_AUTH`**: Your API key for authentication.
- **`TAQNYAT_SMS_SENDER`**: The default sender name for SMS messages.
- **`TAQNYAT_SMS_BASE_URL`**: The base URL for the Taqnyat API (default is `https://api.taqnyat.sa`).

## Usage

You can use the package by either calling the `TaqnyatSms` facade or injecting the `TaqnyatSms` service into your classes.

### Example: Sending an SMS via Facade

```php
use Alsaloul\Taqnyat\TaqnyatSms;

$response = TaqnyatSms::sendMessage('Hello, this is a test message.', ['966********'], 'SenderName');
return $response;
```

### Example: Injecting `TaqnyatSms` in Controller

```php
use Alsaloul\Taqnyat\TaqnyatSms;

class SmsController extends Controller
{
    protected $sms;

    public function __construct(TaqnyatSms $sms)
    {
        $this->sms = $sms;
    }

    public function sendSms()
    {
        $body = 'Hello, this is a test message.';
        $recipients = ['966********'];
        $sender = 'SenderName';

        $response = $this->sms->sendMessage($body, $recipients, $sender);
        return response()->json($response);
    }
}
```

### Available Methods

#### 1. Send SMS

```php
TaqnyatSms::sendMessage($body, $recipients, $sender, $smsId = '', $scheduled = '', $deleteId = '');
```

- **`$body`**: The SMS message content.
- **`$recipients`**: Array of recipient phone numbers.
- **`$sender`**: Sender name (optional, defaults to configured sender).
- **`$smsId`** (optional): Custom SMS ID for tracking purposes.
- **`$scheduled`** (optional): Scheduled date and time for sending the message.
- **`$deleteId`** (optional): ID for message deletion after sending.

#### 2. Get Account Balance

Retrieve your account balance from Taqnyat:

```php
$response = TaqnyatSms::getBalance();
return $response;
```

#### 3. Get Available Senders

Get the list of available SMS sender names:

```php
$response = TaqnyatSms::getSenders();
return $response;
```

#### 4. Check System Status

Check the status of the Taqnyat system:

```php
$response = TaqnyatSms::getStatus();
return $response;
```

## Handling Errors

All methods use Guzzle for HTTP requests and are wrapped in `try-catch` blocks to handle exceptions gracefully. In case of an error, you will receive a descriptive error message which can help in debugging.

### Example: Handling Errors

```php
try {
    $response = TaqnyatSms::sendMessage('Hello, this is a test message.', ['966********'], 'SenderName');
    return $response;
} catch (Exception $e) {
    return 'Error: ' . $e->getMessage();
}
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Contributions are welcome! If you would like to contribute, please submit a pull request or open an issue for any bugs or feature requests.

### Steps to Contribute

1. Fork the repository.
2. Create a new branch: `git checkout -b feature-branch`.
3. Make your changes.
4. Submit a pull request.

## License

This package is open-sourced software licensed under the [MIT License](LICENSE).

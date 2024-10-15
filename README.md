# Laravel Taqnyat SMS Package

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)

## Overview

The Laravel Taqnyat SMS package provides a simple integration with the [Taqnyat SMS API](https://www.taqnyat.sa) to send SMS messages directly from your Laravel application. It comes with methods for sending SMS messages, querying your SMS balance, retrieving senders, and checking the system status.

## Features

- Send SMS messages easily.
- Retrieve account balance.
- Get list of available senders.
- Check Taqnyat system status.
- Configurable API authentication and sender details.

## Requirements

- PHP >= 7.4
- Laravel 8.x, 9.x, or 10.x
- [GuzzleHttp](https://github.com/guzzle/guzzle) for making HTTP requests.

## Installation

You can install the package via Composer:

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

```bash
TAQNYAT_SMS_AUTH=your_api_key_here
TAQNYAT_SMS_SENDER=your_default_sender_name_here
TAQNYAT_SMS_BASE_URL=https://api.taqnyat.sa
```
### Config Options

- `TAQNYAT_SMS_AUTH:` Your API key for authentication.
- `TAQNYAT_SMS_SENDER:` The default sender name for SMS messages.
- `TAQNYAT_SMS_BASE_URL:` The base URL for the Taqnyat API (default is `https://api.taqnyat.sa`).

## Usage
You can use the package by either calling the `TaqnyatSms` facade or injecting the `TaqnyatSms` service into your classes.

### Example: Sending an SMS via Facade

```bash
use TaqnyatSms;

$response = TaqnyatSms::sendMessage('Hello, this is a test message.', ['966********'], 'SenderName');
print_r($response);
```

### Example: Injecting `TaqnyatSms` in Controller

```bash
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
Send SMS
```bash
TaqnyatSms::sendMessage($body, $recipients, $sender, $smsId = '', $scheduled = '', $deleteId = '');
```

- **$body** The SMS message content.
- **$recipients**: Array of recipient phone numbers.
- **$sender**: Sender name.
- **$smsId** (optional): Custom SMS ID.
- **$scheduled** (optional): Scheduled date and time for sending.
- **$deleteId** (optional): ID to delete after sending.

Get Balance
```bash
TaqnyatSms::getBalance();
```
Get Senders
```bash
TaqnyatSms::getSenders();
```
Check System Status
```bash
TaqnyatSms::getStatus();
```

## Changelog
Please see CHANGELOG for more information on what has changed recently.

## Contributing
Contributions are welcome! Feel free to submit a pull request or open an issue for any bugs or feature requests.

### Steps to contribute:
1. Fork the repository.
2. Create a new branch: `git checkout -b feature-branch`.
3. Make your changes.
4. Submit a pull request.

## License
This package is open-sourced software licensed under the MIT License.
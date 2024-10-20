<?php

namespace Alsaloul\Taqnyat;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Config;

/**
 * Main class for handling Taqnyat SMS functionality.
 */
class TaqnyatSms
{
    private static $client;
    private static $sender;

    /**
     * Initialize static properties for API authentication, base URL, and HTTP client.
     */
    private static function init()
    {
        if (!isset(self::$client)) {
            $base = Config::get('taqnyat-sms.base_url');
            $auth = Config::get('taqnyat-sms.auth');
            self::$sender = Config::get('taqnyat-sms.sender_name'); // Default sender from config

            self::$client = new Client([
                'base_uri' => $base,
                'headers' => [
                    'Authorization' => 'Bearer ' . $auth,
                    'Content-Type' => 'application/json',
                ],
            ]);
        }
    }

    /**
     * Send an SMS message to specified recipients.
     *
     * @param string $body The content of the message
     * @param array $recipients List of recipients' phone numbers
     * @param string|null $sender Sender's name (optional)
     * @param string|null $smsId SMS ID for tracking (optional)
     * @param string|null $scheduled Time to schedule message (optional)
     * @param string|null $deleteId ID for deleting a message (optional)
     * @return array|string API response as an associative array or error message
     */
    public static function sendMessage($body, $recipients, $sender = null, $smsId = '', $scheduled = '', $deleteId = '')
    {
        self::init();

        $data = [
            'body' => $body,
            'recipients' => $recipients,
            'sender' => $sender ?? self::$sender,
            'smsId' => $smsId,
            'scheduledDatetime' => $scheduled,
            'deleteId' => $deleteId,
        ];

        try {
            $response = self::$client->post('/v1/messages', [
                'json' => $data
            ]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return json_decode($e->getResponse()->getBody()->getContents(), true);
            }
            return 'Request failed: ' . $e->getMessage();
        }
    }

    /**
     * Retrieve account balance from the API.
     *
     * @return array|string API response as an associative array or error message
     */
    public static function getBalance()
    {
        self::init();
        try {
            $response = self::$client->get('/account/balance');
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return json_decode($e->getResponse()->getBody()->getContents(), true);
            }
            return 'Request failed: ' . $e->getMessage();
        }
    }

    /**
     * Get list of available SMS senders.
     *
     * @return array|string API response as an associative array or error message
     */
    public static function getSenders()
    {
        self::init();
        try {
            $response = self::$client->get('/v1/messages/senders');
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return json_decode($e->getResponse()->getBody()->getContents(), true);
            }
            return 'Request failed: ' . $e->getMessage();
        }
    }

    /**
     * Check the status of the SMS system.
     *
     * @return array|string API response as an associative array or error message
     */
    public static function getStatus()
    {
        self::init();
        try {
            $response = self::$client->get('/system/status');
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return json_decode($e->getResponse()->getBody()->getContents(), true);
            }
            return 'Request failed: ' . $e->getMessage();
        }
    }
}

<?php

namespace Alsaloul\Taqnyat;

use GuzzleHttp\Client;

/**
 * Main class for handling Taqnyat SMS functionality.
 */
class TaqnyatSms
{
    private $base;
    private $auth;
    private $client;
    private $sender;

    /**
     * Constructor to initialize API authentication, base URL, and HTTP client.
     */
    public function __construct($auth)
    {
        $this->auth = config('taqnyat-sms.auth');
        $this->base = config('taqnyat-sms.base_url');
        $this->sender = config('taqnyat-sms.sender_name'); // Default sender from config
        $this->client = new Client([
            'base_uri' => $this->base,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->auth,
                'Content-Type' => 'application/json',
            ],
        ]);
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
     * @return array API response as an associative array
     */
    public function sendMessage($body, $recipients, $sender = null, $smsId = '', $scheduled = '', $deleteId = '')
    {
        $data = [
            'body' => $body,
            'recipients' => $recipients,
            'sender' => $sender ?? $this->sender,
            'smsId' => $smsId,
            'scheduledDatetime' => $scheduled,
            'deleteId' => $deleteId,
        ];

        $response = $this->client->post('/v1/messages', [
            'json' => $data
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * Retrieve account balance from the API.
     *
     * @return array API response as an associative array
     */
    public function getBalance()
    {
        $response = $this->client->get('/account/balance');
        return json_decode($response->getBody(), true);
    }

    /**
     * Get list of available SMS senders.
     *
     * @return array API response as an associative array
     */
    public function getSenders()
    {
        $response = $this->client->get('/v1/messages/senders');
        return json_decode($response->getBody(), true);
    }

    /**
     * Check the status of the SMS system.
     *
     * @return array API response as an associative array
     */
    public function getStatus()
    {
        $response = $this->client->get('/system/status');
        return json_decode($response->getBody(), true);
    }
}

<?php

namespace App\Services\Twilio;

use Twilio\Rest\Client;
use Twilio\Exceptions\TwilioException;

class TwilioWhatsAppService
{
    protected Client $client;
    protected string $fromNumber;

    public function __construct()
    {
        $this->client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.auth_token')
        );
        $this->fromNumber = config('services.twilio.whatsapp_from');
    }

    public function send(string $to, string $message): array
    {
        // Format phone number with whatsapp: prefix
        $formattedTo = 'whatsapp:' . preg_replace('/[\s\-\(\)]/', '', $to);
        if (!str_starts_with($formattedTo, 'whatsapp:+')) {
            $formattedTo = 'whatsapp:+673' . ltrim(str_replace('whatsapp:', '', $formattedTo), '+');
        }

        $msg = $this->client->messages->create($formattedTo, [
            'from' => $this->fromNumber,
            'body' => $message,
        ]);

        return ['success' => true, 'sid' => $msg->sid];
    }
}

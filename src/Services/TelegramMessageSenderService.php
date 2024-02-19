<?php

namespace Maksatsaparbekov\Tlog\Services;


class TelegramMessageSenderService
{
    private $endpoint;
    private $companyCode;

    /**
     * MessageSenderService constructor.
     * @param string $endpoint API endpoint for sending messages.
     * @param string|null $companyCode Default company code to be used for messages.
     */
    public function __construct(string $endpoint , ?string $companyCode = null)
    {
        $this->endpoint = $endpoint ?? config('tlog-config.url');
        $this->companyCode = $companyCode ?? config('tlog-config.code');
    }

    /**
     * Send a message using the configured API endpoint and company code.
     * @param mixed $message The message to be sent.
     * @param string|null $companyCode Optional company code to override the default.
     * @return bool Returns true on success, false on failure.
     */
    public function sendMessage($message, ?string $companyCode = null): bool
    {
        $data = [
            'companycode' => $companyCode ?? $this->companyCode,
            'data' => [
                ['message' => json_encode($message)]
            ]
        ];

        $json_data = json_encode($data);

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->endpoint,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $json_data,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_TIMEOUT => 1,
            CURLOPT_CONNECTTIMEOUT => 1,
            CURLOPT_RETURNTRANSFER => true,
        ]);

        $result = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);

        if ($error) {
            return false;
        }

        return true;
    }
}

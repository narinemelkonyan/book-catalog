<?php

namespace app\services;

use Yii;
use yii\base\Component;

class SmsService extends Component
{
    private string $apiKey;
    private string $apiUrl = 'https://smspilot.ru/api.php';

    public function __construct()
    {
        $this->apiKey = Yii::$app->params['smsApiKey'] ?? 'TEST';
    }

    /**
     * Sends an SMS message to the given phone number.
     */
    public function send(string $phone, string $message): bool
    {
        $params = http_build_query([
            'send' => $message,
            'to'   => $phone,
            'apikey' => $this->apiKey,
            'format' => 'json',
        ]);

        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $params,
            ],
        ]);

        $result = file_get_contents($this->apiUrl, false, $context);

        if ($result === false) {
            Yii::error("SMS send failed to {$phone}", __METHOD__);
            return false;
        }

        $response = json_decode($result, true);

        if (!empty($response['error'])) {
            Yii::error("SMS error: {$response['error']['description']}", __METHOD__);
            return false;
        }

        return true;
    }
}
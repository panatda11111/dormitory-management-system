<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class LineService
{
    private string $channelAccessToken;

    public function __construct()
    {
        $this->channelAccessToken = config(
            'services.line.channel_access_token'
        );
    }

    /**
     * ส่งข้อความตอบกลับจาก Webhook
     */
    public function replyMessage(
        string $replyToken,
        string $message
    ): array {
        $response = Http::withToken($this->channelAccessToken)
            ->post(
                'https://api.line.me/v2/bot/message/reply',
                [
                    'replyToken' => $replyToken,
                    'messages' => [
                        [
                            'type' => 'text',
                            'text' => $message,
                        ],
                    ],
                ]
            );

        return [
            'success' => $response->successful(),
            'status' => $response->status(),
            'body' => $response->json(),
        ];
    }

    /**
     * ส่งข้อความแจ้งเตือนไปยัง LINE User โดยตรง
     */
    public function pushMessage(
        string $lineUserId,
        string $message
    ): array {
        $response = Http::withToken($this->channelAccessToken)
            ->post(
                'https://api.line.me/v2/bot/message/push',
                [
                    'to' => $lineUserId,
                    'messages' => [
                        [
                            'type' => 'text',
                            'text' => $message,
                        ],
                    ],
                ]
            );

        return [
            'success' => $response->successful(),
            'status' => $response->status(),
            'body' => $response->json(),
        ];
    }
}
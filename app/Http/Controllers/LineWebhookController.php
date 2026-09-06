<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Services\LineService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LineWebhookController extends Controller
{
    /**
     * รับ Webhook จาก LINE
     */
    public function handle(Request $request, LineService $lineService)
    {
        $channelSecret = config('services.line.channel_secret');

        $signature = $request->header('X-Line-Signature');
        $body = $request->getContent();

        /*
         * ตรวจสอบข้อมูลพื้นฐานของ Webhook
         */
        if (!$signature || !$channelSecret) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid LINE webhook request',
            ], 400);
        }

        /*
         * ตรวจสอบ LINE Signature
         */
        $hash = base64_encode(
            hash_hmac('sha256', $body, $channelSecret, true)
        );

        if (!hash_equals($hash, $signature)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid LINE signature',
            ], 400);
        }

        $events = $request->input('events', []);

        foreach ($events as $event) {

            /*
             * รับ LINE User ID
             */
            $lineUserId = $event['source']['userId'] ?? null;

            /*
             * ตรวจเฉพาะข้อความ Text
             */
            if (
                ($event['type'] ?? null) !== 'message' ||
                ($event['message']['type'] ?? null) !== 'text' ||
                !isset($event['replyToken'])
            ) {
                continue;
            }

            $replyToken = $event['replyToken'];
            $text = trim($event['message']['text'] ?? '');

            /*
             * คำสั่งเชื่อมบัญชี
             *
             * รูปแบบ:
             * ผูกบัญชี DORM-XXXXXX
             */
            if (
                preg_match(
                    '/^ผูกบัญชี\s+([A-Z0-9-]+)$/u',
                    $text,
                    $matches
                )
            ) {
                $code = strtoupper($matches[1]);

                /*
                 * ต้องมี LINE User ID
                 */
                if (!$lineUserId) {
                    $lineService->replyMessage(
                        $replyToken,
                        'ไม่สามารถระบุบัญชี LINE ของคุณได้ กรุณาลองใหม่อีกครั้ง'
                    );

                    continue;
                }

                /*
                 * ค้นหารหัสเชื่อมบัญชี
                 */
                $tenant = Tenant::where('line_link_code', $code)->first();

                if (!$tenant) {
                    $lineService->replyMessage(
                        $replyToken,
                        "ไม่พบรหัสเชื่อมบัญชี {$code}\nกรุณาตรวจสอบรหัสแล้วลองใหม่อีกครั้ง"
                    );

                    continue;
                }

                /*
                 * ตรวจสอบวันหมดอายุ
                 */
                if (
                    !$tenant->line_link_code_expires_at ||
                    $tenant->line_link_code_expires_at->isPast()
                ) {
                    $lineService->replyMessage(
                        $replyToken,
                        "รหัส {$code} หมดอายุแล้ว\nกรุณาขอรหัสเชื่อม LINE ใหม่จากผู้ดูแลหอพัก"
                    );

                    continue;
                }

                /*
                 * ตรวจสอบว่า LINE นี้ถูกผูกกับผู้เช่าคนอื่นหรือไม่
                 */
                $alreadyLinkedToOtherTenant = Tenant::where(
                    'line_user_id',
                    $lineUserId
                )
                    ->where('id', '!=', $tenant->id)
                    ->exists();

                if ($alreadyLinkedToOtherTenant) {
                    $lineService->replyMessage(
                        $replyToken,
                        'บัญชี LINE นี้ถูกเชื่อมกับผู้เช่ารายอื่นแล้ว'
                    );

                    continue;
                }

                /*
                 * ถ้าผู้เช่ารายนี้มี LINE User ID อื่นอยู่แล้ว
                 * จะไม่เขียนทับโดยอัตโนมัติ
                 */
                if (
                    $tenant->line_user_id &&
                    $tenant->line_user_id !== $lineUserId
                ) {
                    $lineService->replyMessage(
                        $replyToken,
                        'ผู้เช่ารายนี้มีบัญชี LINE ที่เชื่อมอยู่แล้ว'
                    );

                    continue;
                }

                /*
                 * เชื่อมบัญชีสำเร็จ
                 */
                $tenant->update([
                    'line_user_id' => $lineUserId,
                    'line_link_code' => null,
                    'line_link_code_expires_at' => null,
                ]);

                Log::info('LINE account linked successfully', [
                    'tenant_id' => $tenant->id,
                    'tenant_name' => $tenant->name,
                ]);

                $lineService->replyMessage(
                    $replyToken,
                    "เชื่อมบัญชี LINE สำเร็จแล้ว 🎉\n\n"
                    . "ผู้เช่า: {$tenant->name}\n"
                    . "ห้อง: " . ($tenant->room->room_number ?? '-') . "\n\n"
                    . "ต่อไปคุณจะสามารถรับการแจ้งเตือนจากระบบบริหารจัดการหอพักได้"
                );

                continue;
            }

            /*
             * คำสั่งอื่น ๆ
             */
            $lineService->replyMessage(
                $replyToken,
                "ได้รับข้อความแล้วครับ\n\n"
                . "หากต้องการเชื่อมบัญชี กรุณาพิมพ์:\n"
                . "ผูกบัญชี DORM-XXXXXX"
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'LINE Webhook received',
            'events_count' => count($events),
        ]);
    }
}
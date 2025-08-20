<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SmsGatewayService
{
    public static function send($phone, $message)
    {
     Route::get('/test-sms', function () {
    $url = 'https://bulksms.scroll2earn.fun/send';
    $token = '4b41c811-d6e7-4a82-aea2-0855f4cdb810';

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->post($url, [
        'phone'   => '918651323192', // apna number daalo
        'message' => 'Test message from Laravel',
    ]);

    dd($response->body());
});

    }
}

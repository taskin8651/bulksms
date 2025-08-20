<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SmsGatewayService
{
    public static function send($phone, $message)
    {
        $url = env('SMS_GATEWAY_URL');
        $token = env('SMS_GATEWAY_KEY');

       $response = Http::withHeaders([
    'Authorization' => 'Bearer ' . $token,
])->post(rtrim($url, '/') . '/send', [
    'phone'   => $phone,
    'message' => $message,
]);


        return $response->json();
    }
}

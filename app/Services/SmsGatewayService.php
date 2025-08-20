<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SmsGatewayService
{
    public static function send($phone, $message)
    {
      $url = config('services.smsgateway.url');
$token = config('services.smsgateway.key');


$finalUrl = 'https://bulksms.scroll2earn.fun/send';
\Log::info('SMS Request URL: ' . $finalUrl);

$response = Http::withHeaders([
    'Authorization' => 'Bearer ' . $token,
])->post($finalUrl, [
    'phone'   => $phone,
    'message' => $message,
]);



        return $response->json();
    }
}

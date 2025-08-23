<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use App\Models\EmailSetup; // yeh jaruri hai

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Dynamic mail configuration
        try {
            $mailConfig = EmailSetup::where('status', 1)->first();

            if ($mailConfig) {
                $config = [
                    'transport' => 'smtp',
                    'host' => $mailConfig->host,
                    'port' => $mailConfig->port,
                    'encryption' => $mailConfig->encryption,
                    'username' => $mailConfig->username,
                    'password' => $mailConfig->password,
                    'timeout' => null,
                    'auth_mode' => null,
                ];

                Config::set('mail.mailers.smtp', $config);

                Config::set('mail.from', [
                    'address' => $mailConfig->from_email,
                    'name'    => $mailConfig->from_name,
                ]);
            }
        } catch (\Exception $e) {
            \Log::error("Mail config load error: " . $e->getMessage());
        }
    }
}

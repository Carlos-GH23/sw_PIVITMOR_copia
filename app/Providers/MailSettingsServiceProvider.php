<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Models\MailSetting;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Facades\Config;


class MailSettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('mail_settings')) {
            try {
                $mailSettings = MailSetting::first();
                if ($mailSettings) {

                    $username = $mailSettings->auth_enabled ? $mailSettings->username : null;
                    $password = $mailSettings->auth_enabled ? $mailSettings->password : null;

                    $encryption = null;
                    if ($mailSettings->port == 465) {
                        $encryption = 'ssl';
                    } elseif ($mailSettings->starttls_enabled) {
                        $encryption = !empty($mailSettings->encryption) ? $mailSettings->encryption : 'tls';
                    }

                    $contextOptions = [];
                    if (!empty($mailSettings->trust)) {
                        $contextOptions = [
                            'ssl' => [
                                'verify_peer' => false,
                                'verify_peer_name' => false,
                                'allow_self_signed' => true,
                            ],
                        ];
                    }

                    $config = [
                        'transport'    => 'smtp',
                        'host'         => $mailSettings->host,
                        'port'         => $mailSettings->port,
                        'encryption'   => $encryption,
                        'username'     => $username,
                        'password'     => $password,
                        'timeout'      => null,
                        'auth_mode'    => null,
                        'stream'      => $contextOptions,
                    ];
                    Config::set('mail.mailers.smtp', $config);

                    if ($mailSettings->from_address && $mailSettings->from_name) {
                        Config::set('mail.from.address', $mailSettings->from_address);
                        Config::set('mail.from.name', $mailSettings->from_name);
                    }

                    if ($mailSettings->debug) {
                        Event::listen(MessageSending::class, function (MessageSending $event) {

                            $message = $event->message;

                            Log::channel('daily')->info('Intento de envio', [
                                'to'      => $this->formatAddresses($message->getTo()),
                                'subject' => $message->getSubject(),
                                'headers' => $message->getHeaders()->toString(),
                            ]);
                        });
                    }
                }
            } catch (\Exception $e) {
            }
        }
    }

    private function formatAddresses(?array $addresses): string
    {
        if (!$addresses) return 'Desconocido';

        return collect($addresses)->map(function ($address) {
            return $address->getAddress();
        })->implode(', ');
    }
}

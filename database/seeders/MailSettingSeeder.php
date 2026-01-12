<?php

namespace Database\Seeders;

use App\Models\MailSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MailSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MailSetting::create([
            'username' => '9bebe7001@smtp-brevo.com',
            'password' => env('BREVO_SMTP_PASSWORD'),
            'from_address' => 'serchypq04@gmail.com',
            'from_name' => 'PIVITMor',
            'host' => 'smtp-relay.brevo.com',
            'port' => 587,
            'trust' => null,
            'protocol' => 'smtp',
            'encoding' => 'utf-8',
            'debug' => false,
            'auth_enabled' => true,
            'encryption' => 'tls',
            'starttls_enabled' => true,
        ]);
    }
}

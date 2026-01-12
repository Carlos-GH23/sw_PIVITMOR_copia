<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailSetting extends Model
{
    protected $table = 'mail_settings';

    protected $fillable = [
        'username',
        'password',
        'from_address',
        'from_name',
        'host',
        'port',
        'trust',
        'protocol',
        'encoding',
        'debug',
        'auth_enabled',
        'encryption',
        'starttls_enabled',
    ];

    protected $casts = [
        'password' => 'encrypted',
        'auth_enabled' => 'boolean',
        'starttls_enabled' => 'boolean',
        'debug' => 'boolean',
    ];
}

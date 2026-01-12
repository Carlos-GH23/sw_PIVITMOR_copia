<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsentConfiguration extends Model
{
    protected $table = 'consent_configurations';

    protected $fillable = [
        'data_usage_consent',
        'force_acceptance',
        'electronic_communication_consent',
        'electronic_communication_message',
        'statistical_data_consent',
        'statistical_data_message',
        'frequency_of_acceptance',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInformation extends Model
{
    /** @use HasFactory<\Database\Factories\ContactInformationFactory> */
    use HasFactory;
    protected $table = 'contact_information';

    protected $fillable = [
        'email',
        'address',
        'latitude',
        'longitude',
        'opening_time',
        'closing_time',
    ];

    public function phoneNumbers()
    {
        return $this->morphMany(PhoneNumber::class, 'phoneable');
    }
}
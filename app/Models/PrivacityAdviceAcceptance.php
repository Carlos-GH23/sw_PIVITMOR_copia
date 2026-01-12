<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrivacityAdviceAcceptance extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'privacity_advice_acceptances';

    protected $fillable = [
        'is_accepted',
        'user_id',
        'privacity_compliance_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function privacityCompliance()
    {
        return $this->belongsTo(PrivacityCompliance::class);
    }
}

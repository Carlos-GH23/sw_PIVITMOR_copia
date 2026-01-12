<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnowledgeLine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'knowledge_lineable_id',   
        'knowledge_lineable_type',
    ];

    public function knowledgeLineable() 
    {
        return $this->morphTo();
    }
}

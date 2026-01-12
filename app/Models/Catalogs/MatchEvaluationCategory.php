<?php

namespace App\Models\Catalogs;

use App\Models\MatchEvaluation;
use App\Traits\HasHierarchy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchEvaluationCategory extends Model
{
    use HasFactory;
    use HasHierarchy;

    protected $fillable = [
        'name',
        'description',
        'parent_id',
    ];

    public function evaluations()
    {
        return $this->belongsToMany(MatchEvaluation::class, 'match_evaluation_category');
    }

    public function parent()
    {
        return $this->belongsTo(MatchEvaluationCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MatchEvaluationCategory::class, 'parent_id');
    }
}

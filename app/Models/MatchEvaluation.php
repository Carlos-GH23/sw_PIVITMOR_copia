<?php

namespace App\Models;

use App\Enums\MatchAction;
use App\Enums\TerritoryLevel;
use App\Models\AcademicOfferings\AcademicOffering;
use App\Models\Catalogs\ImpactMetric;
use App\Models\Catalogs\MatchEvaluationCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MatchEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'story',
        'results',
        'goals',
        'lessons',
        'rating',
        'training_hours',
        'economic_estimate',
        'productivity_increase',
        'territorial_level',
        'emissions_percentage',
        'emissions_methodology',
        'community_impact_level',
        'inclusion_equity_level',
        'project_sustainability_status',
        'continuity_percentage',
        'continuity_type',
        'communication_management_percentage',
        'infrastructure_level',
        'estimated_investment',
        'maturity_level',
        'structure_type',
        'public_service_percentage',
        'transparency_level',
        'process_digitalization_percentage',
        'process_simplification_percentage',
        'interoperability_level',
        'evaluated_at',

        'is_success_story',
        'capability_requirement_match_id',
        'match_evaluation_status_id',
        'user_id',
    ];

    protected $casts = [
        'territorial_level' => TerritoryLevel::class,
    ];

    protected static function booted()
    {
        static::creating(function ($matchEvaluation) {
            if (is_null($matchEvaluation->user_id)) {
                $matchEvaluation->user_id = Auth::id();
            }
        });

        static::created(function ($matchEvaluation) {
            if ($matchEvaluation->match_evaluation_status_id === 2) {
                $matchEvaluation->evaluated_at = now();
                $matchEvaluation->save();
            }
        });
    }

    public function match()
    {
        return $this->belongsTo(CapabilityRequirementMatch::class, 'capability_requirement_match_id');
    }

    public function matchEvaluationStatus()
    {
        return $this->belongsTo(MatchEvaluationStatus::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categories()
    {
        return $this->belongsToMany(MatchEvaluationCategory::class, 'match_evaluation_category');
    }

    public function isOffererEvaluation(): bool
    {
        return $this->match?->isOfferer($this->user);
    }

    public function isApplicantEvaluation(): bool
    {
        return $this->match?->isApplicant($this->user);
    }

    // 
    public function technologyLevelTransitions()
    {
        return $this->hasMany(TechnologyLevelTransition::class);
    }

    public function studentParticipations()
    {
        return $this->hasMany(StudentParticipation::class);
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    public function partnershipAgreements()
    {
        return $this->hasMany(PartnershipAgreement::class);
    }

    public function institutionalRecognitions()
    {
        return $this->hasMany(InstitutionalRecognition::class);
    }

    public function derivedPolicies()
    {
        return $this->hasMany(DerivedPolicy::class);
    }

    public function academicOfferings()
    {
        return $this->belongsToMany(AcademicOffering::class);
    }

    public function metricIndicators()
    {
        return $this->morphMany(MetricIndicator::class, 'indicatorable');
    }

    public function impactMetrics()
    {
        return $this->belongsToMany(ImpactMetric::class, 'impact_metric_match_evaluation');
    }
}

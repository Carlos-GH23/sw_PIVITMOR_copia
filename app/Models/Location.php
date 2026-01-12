<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'locations';

    protected $fillable = [
        'street',
        'exterior_number',
        'interior_number',
        'longitude',
        'latitude',
        'locationable_id',
        'locationable_type',
        'neighborhood_id',
    ];

    public function locationable()
    {
        return $this->morphTo();
    }

    public function neighborhood(): BelongsTo
    {
        return $this->belongsTo(Neighborhood::class);
    }

    public function fullAddress(): Attribute
    {
        return Attribute::make(
            get: function () {
                $address = collect([
                    $this->street,
                    $this->interior_number,
                    $this->exterior_number
                ])->filter()->implode(' ');

                $neighborhood = collect([
                    $this->neighborhood?->name,
                    $this->neighborhood?->postal_code
                ])->filter()->implode(' ');

                $cityState = collect([
                    $this->neighborhood?->municipality?->name,
                    $this->neighborhood?->municipality?->state?->name
                ])->filter()->implode(', ');

                return collect([$address, $neighborhood, $cityState])
                    ->filter()
                    ->implode(', ');
            }
        );
    }

    public function cityState(): Attribute
    {
        return Attribute::make(
            get: function () {
                $cityState = collect([
                    $this->neighborhood?->municipality?->name,
                    $this->neighborhood?->municipality?->state?->name
                ])->filter()->implode(', ');

                return $cityState;
            }
        );
    }
}

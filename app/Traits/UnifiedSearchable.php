<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

trait UnifiedSearchable
{
    use Searchable;

    public function initializeUnifiedSearchable()
    {
        $this->append('type');
    }

    public function getTypeAttribute(): string
    {
        if (property_exists($this, 'searchableType')) {
            return $this->searchableType;
        }

        return Str::snake(class_basename($this));
    }

    public function getScoutKey(): mixed
    {
        return $this->getTable() . '_' . $this->getKey();
    }

    public function shouldBeSearchable(): bool
    {
        $table = $this->getTable();
        
        if ($table === 'conferences') {
            return isset($this->conference_status_id) 
                && (int)$this->conference_status_id === 2;
        }

        if ( $table === 'facility_equipments' ) {
            return $this->status ?? true;
        }
        
        $statusFields = [
            'technology_services' => 'technology_service_status_id',
            'capabilities' => 'capability_status_id',
            'requirements' => 'requirement_status_id',
        ];
        
        if (isset($statusFields[$table])) {
            $statusField = $statusFields[$table];
            return ($this->is_active ?? true)
                && isset($this->$statusField)
                && in_array((int)$this->$statusField, [3, 6]);
        }
        
        return $this->is_active ?? true;
    }

    public function searchableAs(): string
    {
        return 'pivit_local';
    }
}

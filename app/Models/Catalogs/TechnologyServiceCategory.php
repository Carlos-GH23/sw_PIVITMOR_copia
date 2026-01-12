<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TechnologyServiceCategory extends Model
{
	use SoftDeletes;

	protected $table = 'technology_service_categories';

	protected $fillable = [
		'code',
		'name',
		'description',
	];

	public function serviceTypes()
	{
		return $this->hasMany(TechnologyServiceType::class, 'category_id');
	}
}

<?php

namespace App;

use App\Traits\FilterHelperTrait;
use App\Traits\KpiFilterTrait;
use App\Traits\KpiYearTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


class KpiYear extends Model
{
    //
	protected $table = 'kpi_year';

	use FilterHelperTrait;
	use KpiFilterTrait;
	use KpiYearTrait;


	function intervals(){
		return $this->hasMany(KpiInterval::class,'kpi_year_id');
	}


	public function loadFilters()
	{
		$ref = $this;
//		$this->addFilter([], function(Builder $builder,$filter) use ($ref){
//
//		});

	}
}

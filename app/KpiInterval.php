<?php

namespace App;

use App\Traits\FilterHelperTrait;
use App\Traits\KpiFilterTrait;
use App\Traits\KpiIntervalTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class KpiInterval extends Model
{
	use KpiIntervalTrait;
	use FilterHelperTrait;
	use KpiFilterTrait;

    //
	protected $table = 'kpi_interval';

	function year(){
		return $this->belongsTo(KpiYear::class,'kpi_year_id');
	}

	function data(){
		return $this->hasMany(KpiData::class,'kpi_interval_id');
	}

	function session(){
		return $this->hasMany(KpiSession::class,'kpi_interval_id');
	}

	public function loadFilters()
	{
		// TODO: Implement loadFilters() method.
		$ref = $this;
		$this->addFilter(['kpi_year_id'], function(Builder $builder,$filter) use ($ref){
			return $ref->filterByKpiYearId($builder, $filter);
		});

		$this->addFilter(['interval_check'], function(Builder $builder,$filter) use ($ref){
			return $ref->filterByKpiInterval($builder, $filter);
		});

	}


	function intervalNotExpired(){
	   $date = date('Y-m-d');
//	   $sql = (new KpiInterval)->fetch([
//		   'interval_check'=>$date
//	   ])->where('id',(new KpiSession)->getCurrentIntervalId())->toSql();
//	   echo $sql;
	   $recordCount = (new KpiInterval)->fetch([
	   	'interval_check'=>$date
	   ])->where('id',(new KpiSession)->getCurrentIntervalId())->count();
	   return ($recordCount >= 1);
	}


}

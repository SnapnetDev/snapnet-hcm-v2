<?php

namespace App;

use App\Traits\KpiSessionTrait;
use Illuminate\Database\Eloquent\Model;

class KpiSession extends Model
{
	use KpiSessionTrait;
    //
	protected $table = 'kpi_session';

	function interval(){
		return $this->belongsTo(KpiInterval::class,'kpi_interval_id');
	}

}

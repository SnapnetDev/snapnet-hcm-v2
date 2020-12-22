<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KpiAgreement extends Model
{
    //
	protected $table = 'kpi_agreement';

	function interval(){
		return $this->belongsTo(KpiInterval::class,'kpi_interval_id');
	}

	function user(){
		return $this->belongsTo(User::class,'user_id');
	}


	function acceptAgreement(){
	   $user_id = request()->get('user_id');
	   $kpi_interval_id = request()->get('kpi_interval_id');
	   if (!$this->agreementExists($user_id, $kpi_interval_id)){
	   	 $obj = new KpiAgreement;
	   	 $obj->user_id = $user_id;
	   	 $obj->kpi_interval_id = $kpi_interval_id;
	   	 $obj->status = 1;
	   	 $obj->save();
	   }else{
           $obj = KpiAgreement::where('user_id',$user_id)->where('kpi_interval_id',$kpi_interval_id)->first();
		   $obj->user_id = $user_id;
		   $obj->kpi_interval_id = $kpi_interval_id;
		   $obj->status = 1;
		   $obj->save();

	   }


	   return [
	   	'message'=>'Agreement accepted.',
		'error'=>false
	   ];

	}

	function agreementExists($user_id,$kpi_interval_id){

	  return KpiAgreement::where('user_id',$user_id)->where('kpi_interval_id',$kpi_interval_id)->exists();
	}



	function denyAgreement(){
		$user_id = request()->get('user_id');
		$kpi_interval_id = request()->get('kpi_interval_id');
		if (!$this->agreementExists($user_id, $kpi_interval_id)){
			$obj = new KpiAgreement;
			$obj->user_id = $user_id;
			$obj->kpi_interval_id = $kpi_interval_id;
			$obj->status = 0;
			$obj->save();
		}else{
			$obj = KpiAgreement::where('user_id',$user_id)->where('kpi_interval_id',$kpi_interval_id)->first();
			$obj->user_id = $user_id;
			$obj->kpi_interval_id = $kpi_interval_id;
			$obj->status = 0;
			$obj->save();

		}

		return [
			'message'=>'Agreement denied.',
			'error'=>false
		];

	}

}

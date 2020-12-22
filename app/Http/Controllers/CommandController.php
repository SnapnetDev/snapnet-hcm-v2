<?php

namespace App\Http\Controllers;

use App\KpiData;
use App\KpiInterval;
use App\KpiSession;
use App\KpiUserScore;
use App\KpiYear;
use App\Traits\FrontEndTrait;
use Illuminate\Http\Request;

class CommandController extends Controller
{
    //

	use FrontEndTrait;

	function process($cmd){
		return $this->execCommand($cmd);
	}


	function addKpiYear(){
		$response = (new KpiYear)->createKpiYear();
		return redirect()->back()->with($response);
	}

	function updateKpiYear(){
		$response = (new KpiYear)->updateKpiYear();
		return redirect()->back()->with($response);
	}

	function removeKpiYear(){
		$response = (new KpiYear)->removeKpiYear();
		return redirect()->back()->with($response);
	}



	function addKpiInterval(){
		$response = (new KpiInterval)->createKpiInterval();
		return redirect()->back()->with($response);
	}

	function updateKpiInterval(){
	   $response = (new KpiInterval)->updateKpiInterval();
	   return redirect()->back()->with($response);
	}

	function removeKpiInterval(){
		$response = (new KpiInterval)->removeKpiInterval();
		return redirect()->back()->with($response);
	}

	function addKpiData(){
		$response = (new KpiData)->createKpiData();
		return redirect()->back()->with($response);
	}

	function updateKpiData(){
		$response = (new KpiData)->updateKpiData();
		return redirect()->back()->with($response);
	}

	function removeKpiData(){
		$response = (new KpiData)->removeKpiData();
		return redirect()->back()->with($response);
	}

	function createIndividualKpi(){
		$response = (new KpiUserScore)->createIndividualKpi();
		return redirect()->back()->with($response);
	}

	function removeIndividualKpi(){
		$response = (new KpiUserScore)->removeIndividualKpi();
		return redirect()->back()->with($response);
	}

	function kpiCreateUserScore(){
		$response = (new KpiUserScore)->createUserScore();
		return $response;
	}

	function sendGeneralNotification(){
		$response = (new KpiSession)->sendGeneralNotification();
		return redirect()->back()->with($response)->withInput();
	}


}

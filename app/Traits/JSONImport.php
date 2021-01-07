<?php
/**
 * Created by PhpStorm.
 * User: NnamdiAlexanderAkamu
 * Date: 1/6/2021
 * Time: 1:31 PM
 */

namespace App\Traits;


trait JSONImport
{

	function importJSONArray($jsonResource,$callback){

		$json = public_path($jsonResource);

		$hnd = fopen($json, 'r+');
		$data = fread($hnd, filesize($json) );
		fclose($hnd);

		$data = json_decode($data);

		if (method_exists($this, $callback)){

			foreach ($data as $k=>$v){
				$this->$callback($k,$v);
			}
			
		}

	}
	
	
	

}
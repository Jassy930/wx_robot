<?php

/**
	* User :jassy
	* Date :2017-01-26
	* Time :13:02
*/

namespace App\Model;

use DB;
use Log;

class dialogue_log
{

	private static $tablename = 'dialogue_log';


	public static function insertLog(array $datalog = array()){
		if(empty($datalog['open_id'])){
			return false;
		}
		try{
			$result = DB::table(self::$tablename)->insertGetId($datalog);
			return $result;
		}
		catch(\Exception $e){
			Log::info(__CLASS__ . '::' . __FUNCTION__ . '()' . __LINE__ . ': ' . $e->getMessage());
			return false;
		}
	}
}

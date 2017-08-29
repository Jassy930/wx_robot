<?php

/**
	* User :jassy
	* Date :2017-01-26
	* Time :21:15
*/

namespace App\Model;

use DB;
use Log;
use PDO;

class filter_word
{

	private static $tablename = 'filter_word';

	public static function getFilterRes($text = ""){
		if(empty($text)){
			return false;
		}
		return false;	
		try{
			//Log::info('FilterResTEST_sqlword:' . "select * from filter_word where '%" . $text . "' like CONCAT('%',filterword,'%')" );
			//$con = mysqli_connect("localhost", "root", "10010","filter_word");
			//$data = mysqli_query($con, 'SELECT * FROM `filter_word` WHERE "红娣呀" LIKE CONCAT("%",filterword,"%")');
			//mysqli_close($con);
			$options = array(
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			);
			$pdo = new PDO('mysql:host=localhost;dbname=weixinbot;port=3306;charset=utf8','root','10010',$options);
			$data = $pdo -> query('SELECT * FROM `filter_word` WHERE "红娣呀" LIKE CONCAT("%",filterword,"%")');
			$data = $data->fetchAll();
			//$data = DB::select('SELECT * FROM `filter_word` WHERE "红娣呀" LIKE CONCAT("%",filterword,"%")');	
			//$data = DB::table($tablename)
			//	->where("%" . %text . "%", 'like', 
			Log::info('logselect:' . var_dump($data));
			//foreach($data as $key=>$value)
			//{
		//		Log::info('log_data_array:' . $key . '=>' . $value);
		//	}
			return $data;
		}
		catch(\Exception $e){
			Log::info(__CLASS__ . '::' . __FUNCTION__ . '()' . __LINE__ . ': ' . $e->getMessage());
			return false;
		}
	}

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


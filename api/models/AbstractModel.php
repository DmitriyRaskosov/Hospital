<?php

require_once __DIR__.'/../../Database.php';

abstract class AbstractModel {

	public $id = null;

	public static function validation ($array)
	{
		foreach ($array as $key => $value) {
			if (!array_key_exists($key, static::$attributes)) {
				throw new Exception ("Ошибка в написании ".$key);
			}
		}
		return true;
	}

	public static function getOne($id, $db_data)
	{
	    $data = $db_data->query('SELECT * FROM '.static::$table_name.' WHERE id='.$id);
	    return $data;
	}
	
	public static function getAll($db_data)
	{
		$data = $db_data->query('SELECT * FROM '.static::$table_name);
		return $data;
	}

	public static function create($post, $db_data)
	{
		self::validation($post);
		foreach ($post as $key => $value){
		    $post[$key] = "'".$value."'";
		}
		print_r($post);
		$data = $db_data->query('INSERT INTO '.static::$table_name." (".implode(", ",array_keys($post)).") ".'VALUES'." (".implode(", ", $post).")");
        return $data;
	}

	public static function update($id, $changed_data, $db_data)
	{
	    self::validation($changed_data);
	    if (self::getOne($id, $db_data)) {
		    $arr_attributes = [];
		    foreach ($changed_data as $key => $value) {
		    	$arr_attributes[] = $key." = "."'".$value."'";
		    }
		    $data = $db_data->query('UPDATE '.static::$table_name.' SET '.implode(", ", $arr_attributes)." ".'WHERE id = '.$id);
	    	return $data;
	    }
    }

	public static function delete($id, $db_data)
	{	
		if (static::$table_name = 'Patients') {
			$result = $db_data->query('DELETE FROM Appointments WHERE patient_id = '.$id);
		}
		if (self::getOne($id, $db_data)) {
			$result = $db_data->query('DELETE FROM '.static::$table_name.' WHERE id = '.$id);
			return $result;
		}
	}
}
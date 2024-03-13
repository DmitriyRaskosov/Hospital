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

	public static function getOne($id)
	{
	    $data = Database::query('SELECT * FROM '.static::$table_name.' WHERE id='.$id);
	    return $data;
	}
	
	public static function getAll()
	{
		$data = Database::query('SELECT * FROM '.static::$table_name);
		return $data;
	}

	public static function create($post)
	{
		self::validation($post);
		foreach ($post as $key => $value){
		    $post[$key] = "'".$value."'";
		}
		$data = Database::query('INSERT INTO '.static::$table_name." (".implode(", ",array_keys($post)).") ".'VALUES'." (".implode(", ", $post).")");
        return $data;
	}

	public static function update($id, $changed_data)
	{
	    self::validation($changed_data);
	    if (self::getOne($id)) {
		    $arr_attributes = [];
		    foreach ($changed_data as $key => $value) {
		    	$arr_attributes[] = $key." = "."'".$value."'";
		    }
		    $data = Database::query('UPDATE '.static::$table_name.' SET '.implode(", ", $arr_attributes)." ".'WHERE id = '.$id);
	    	return $data;
	    }
    }

	public static function delete($id)
	{	
		if (static::$table_name = 'Patients') {
			$result = Database::query('DELETE FROM Appointments WHERE patient_id = '.$id);
		}
		if (self::getOne($id)) {
			$result = Database::query('DELETE FROM '.static::$table_name.' WHERE id = '.$id);
			return $result;
		}
	}
}
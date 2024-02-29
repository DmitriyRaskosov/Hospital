<?php

require_once __DIR__.'/../../Database.php';

abstract class AbstractModel {

	public $id = null;

	public static function getOne($id)
	{
	    $db_data = new Database();
	    $data = $db_data->query('SELECT * FROM '.static::$table_name.' WHERE id='.$id);
	    return $data;
	}
	
	public static function getAll()
	{
		$db_data = new Database();
		$data = $db_data->query('SELECT * FROM '.static::$table_name);
		return $data;
	}

	public static function create($post)
	{
		foreach ($post as $key => $value){
		    $post[$key] = "'".$value."'";
		}
		print_r($post);
		$db_data = new Database();
		$data = $db_data->query('INSERT INTO '.static::$table_name." (".implode(", ",array_keys($post)).") ".'VALUES'." (".implode(", ", $post).")");
        return $data;
	}

	public static function update($id, $changed_data)
	{
		$db_data = new Database();
		print_r($changed_data);
		foreach ($changed_data as $key => $value) {
			if (array_key_exists($key, static::$attributes) != false) {
				$data = $db_data->query('UPDATE '.static::$table_name.' SET '.$key." = "."'".$value."'"." ".'WHERE id = '.$id)."<br>";
			}
		}
    	return $data;
    }

	public static function delete($id)
	{
		$db_data = new Database();

		$result = $db_data->query('DELETE FROM Appointments WHERE patient_id = '.$id);
		$result = $db_data->query('DELETE FROM '.static::$table_name.' WHERE id = '.$id);

		return $result;
	}
}
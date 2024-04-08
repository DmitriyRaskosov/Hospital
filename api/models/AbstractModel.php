<?php

require_once __DIR__.'/../../Database.php';
require_once __DIR__.'/../../ValidationTrait.php';

abstract class AbstractModel {
	use Validation;

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

	public static function filter($valid_data)
    {
        if ($valid_data != null) {
        	self::validation($valid_data);
        	
            // тут разбираем и формируем входящие данные в нужный для запроса формат (добавляем кавычки)
            $data_keys = array_keys($valid_data);
            $data_values = array_values($valid_data);

            $query = [];
            foreach ($data_values as $key => $value){
                $data_values[$key] = "'".$value."'";
                $query[] = $data_keys[$key]." = ".$data_values[$key];
            }
            $query = implode(" AND ", $query);

            $data = Database::getConnect()->query('SELECT * FROM '.static::$table_name.' WHERE '.$query);
            return $data;
        }
        $data = Database::getConnect()->query('SELECT * FROM '.static::$table_name);
        return $data;
    }

	public static function getOne($id)
	{
	    $data = Database::getConnect()->query('SELECT * FROM '.static::$table_name.' WHERE id='.$id);
	    return $data;
	}
	
	public static function getAll($get)
	{
		$data = self::filter($get);
		return $data;
	}

	public static function create($post)
	{
		self::validation($post);
		foreach ($post as $key => $value){
		    $post[$key] = "'".$value."'";
		}
		$data = Database::getConnect()->query('INSERT INTO '.static::$table_name." (".implode(", ",array_keys($post)).") ".'VALUES'." (".implode(", ", $post).")");
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
		    $data = Database::getConnect()->query('UPDATE '.static::$table_name.' SET '.implode(", ", $arr_attributes)." ".'WHERE id = '.$id);
	    	return $data;
	    }
    }

	public static function delete($id)
	{	
		if (static::$table_name = 'Patients') {
			$result = Database::getConnect()->query('DELETE FROM Appointments WHERE patient_id = '.$id);
		}
		if (self::getOne($id)) {
			$result = Database::getConnect()->query('DELETE FROM '.static::$table_name.' WHERE id = '.$id);
			return $result;
		}
	}
}
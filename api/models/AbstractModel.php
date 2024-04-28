<?php

require_once __DIR__.'/../../Database.php';
require_once __DIR__.'/../../ValidationTrait.php';

abstract class AbstractModel {
	use Validation;

	public $id = null;

	public static function validation ($array)
	{
		foreach ($array as $key => $value) {
			if (!array_key_exists($value, static::$attributes)) {
				throw new Exception ("Ошибка в написании ".$key);
			}
		}
		return true;
	}

	public static function filter($valid_data)
    {
        if ($valid_data != null) {
        	$valid_data = (array)json_decode($valid_data['filter'], true);

            // тут разбираем и формируем входящие данные в нужный для запроса формат - разбираем json на две части - запрос с плейсхолдерами и массив значений
            $query_filters = [];
            $query_values = [];
            $placeholder_num = 1;
            foreach ($valid_data as $arrays => $filters) {

            	// валидируем фильтры на соответствие атрибутам модели
            	self::validation((array)$filters['filter_name']);
            	if (strlen($filters['symbol']) > 2) {
            		throw new Exception ('Проверь количество символов');
            	}
            	$filter = null;
            	// выносим значения фильтров в отдельный массив, заменяем значения в массиве фильтров на плейсхолдеры
            	foreach ($filters as $key => $value) {
            		if ($key == 'value') {
            			$query_values['$'.$placeholder_num] = $value;
            			$value = '$'.$placeholder_num;
            			$placeholder_num++;
            		}
            		$filter .= " ".$value;
            	}
            	$query_filters[] = $filter;
            }
            $query_filters = implode(' AND ', $query_filters);
            
            $data = Database::getConnect()->query('SELECT * FROM '.static::$table_name.' WHERE '.$query_filters, $query_values);
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
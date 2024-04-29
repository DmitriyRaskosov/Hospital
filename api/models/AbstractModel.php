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

	public static function filter($valid_data, $query_string, $id = null)
    {
        // тут разбираем и формируем входящие данные в нужный для запроса формат - запрос с плейсхолдерами и массив значений
        $query_filters = [];
        $query_values = [];
        $placeholder_num = 1;

        if (str_contains($query_string, 'SELECT')) {
        	foreach ($valid_data as $arrays => $filters) {

		        // валидируем фильтры на соответствие атрибутам модели
		        self::validation((array)$filters['filter_name']);
		        if (strlen($filters['symbol']) > 2) {
		        	throw new Exception ('Проверь количество символов');
		        }
		        $filter = null;

		        // выносим значения фильтров в отдельный массив, заменяем значения в массиве фильтров на плейсхолдеры
		        // $query_values['плейсхолдер' => 'полученное значение']
		        foreach ($filters as $filter_name => $value) {
			        if ($filter_name == 'value') {
				        $query_values['$'.$placeholder_num] = $value;
				        $value = '$'.$placeholder_num;
				        $placeholder_num++;
				        }
			        $filter .= " ".$value;
		        }
		        // query_filters['дефолтный номер ключа' => 'имя_фильтра знак плейсхолдер'] 
		        $query_filters[] = $filter;
		    }
	        $query_filters = implode(' AND ', $query_filters);

	        $data = Database::getConnect()->query($query_string.$query_filters, $query_values);
	        return $data;
        }

        if (str_contains($query_string, 'INSERT')) {
        	foreach ($valid_data as $arrays => $filters) {

        		// валидируем фильтры на соответствие атрибутам модели
        		self::validation((array)$filters['filter_name']);
		        if (strlen($filters['symbol']) > 2) {
		        	throw new Exception ('Проверь количество символов');
		        }

		        // query_filters['название ключа' => 'плейсхолдер'], $query_values['плейсхолдер' => 'полученное значение']
				foreach ($filters as $filter_name => $value) {
					if ($filter_name == 'filter_name') {
						$query_filters[$value] = '$'.$placeholder_num;
						$query_values['$'.$placeholder_num] = "'".$filters['value']."'";
						$placeholder_num++;
					}
					// в БД все числа имеют тип данных integer, а при заполнении новых массивов выше у всех значений появляются одинарные кавычки, что недопустимо для integer в postgres'е
					if (is_numeric($value)) {
						$query_values['$'.$placeholder_num - 1] = $filters['value'];
					}
				}
			}
			$query_placeholders = implode(", ", $query_filters);
			$query_filters = implode(", ", array_keys($query_filters));

        	$data = Database::getConnect()->query($query_string." (".$query_filters.") ".'VALUES'." (".$query_placeholders.")", $query_values);
        	return $data;
        }

        if (str_contains($query_string, 'UPDATE') && self::getOne($id)) {
        	foreach ($valid_data as $arrays => $filters) {

        		// валидируем фильтры на соответствие атрибутам модели
        		self::validation((array)$filters['filter_name']);
		        if (strlen($filters['symbol']) > 2) {
		        	throw new Exception ('Проверь количество символов');
		        }
		        $filter = null;

				foreach ($filters as $filter_name => $value) {
			        if ($filter_name == 'value') {
				        $query_values['$'.$placeholder_num] = $value;
				        $value = '$'.$placeholder_num;
				        $placeholder_num++;
				        }
			        $filter .= " ".$value;
		        }
			    // query_filters['дефолтный номер ключа' => 'имя_фильтра знак плейсхолдер'] 
			    $query_filters[] = $filter;
			}
		    $query_filters = implode(', ', $query_filters);

		    $data = Database::getConnect()->query($query_string.$query_filters." ".'WHERE id = '.$id, $query_values);
		    return $data;
        }

    }

	public static function getOne($id)
	{
		self::intValidate($id);
		$query_filters = 'id = $1';
		$query_values[] = $id;
	    $data = Database::getConnect()->query('SELECT * FROM '.static::$table_name.' WHERE '.$query_filters, $query_values);
	    return $data;
	}
	
	public static function getAll($get)
	{
		if ($get == null) {
			$data = Database::getConnect()->query('SELECT * FROM '.static::$table_name, $get);
        	return $data;
		}

		$get = (array)json_decode($get['filter'], true);
		$query_string = 'SELECT * FROM '.static::$table_name.' WHERE ';

		$data = self::filter($get, $query_string);
		return $data;
	}

	public static function create($post)
	{
		$post = (array)json_decode($post['filter'], true);
		$query_string = 'INSERT INTO '.static::$table_name;

		$data = self::filter($post, $query_string);
        return $data;
	}

	public static function update($id)
	{	
		self::intValidate($id);
		$put = (array)json_decode(file_get_contents("php://input"), true);
        $query_string = 'UPDATE '.static::$table_name.' SET ';

	    $data = self::filter($put, $query_string, $id);
	    return $data;
    }

	public static function delete($id)
	{	
		self::intValidate($id);
		$query_filters = '$1';
		$query_values[] = $id;

		if (self::getOne($id)) {
			if (static::$table_name == 'Patients') {
				$query_string = 'DELETE FROM Appointments WHERE patient_id = ';
				$data = Database::getConnect()->query($query_string.$query_filters, $query_values);
			}

			$query_string = 'DELETE FROM '.static::$table_name.' WHERE id = ';

			$data = Database::getConnect()->query($query_string.$query_filters, $query_values);
			return $data;
		}
	}
}
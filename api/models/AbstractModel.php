<?php

/**
 * Require the Database.php file.
 * Require the ValidationTrait.php file.
 */
require_once __DIR__.'/../../Database.php';
require_once __DIR__.'/../../ValidationTrait.php';

abstract class AbstractModel {
	use Validation;

    /**
     * @var null integer
     */
	public $id = null;

    /**
     * Небольшая валидация полученных атрибутов на их фактическое существование у модели
     * @param string $value полученный атрибут
     * @return true
     * @throws Exception
     */
	public static function validation ($value)
	{
		if (!in_array($value, static::$attributes)) {
			throw new Exception ("Ошибка в написании атрибута");
		}
		return true;
	}

    /**
     * @param string $valid_data
     * @param string $query_string
     * @param $query_condition
     * @return array|void
     * @throws Exception
     */
	public static function filter($valid_data, $query_string, $query_condition = null)
    {
        $query_filters = [];
        $query_values = [];
        $placeholder_num = 1;
    	
        foreach ($valid_data as $arrays => $filters) {
        	// валидируем фильтры на соответствие атрибутам модели
        	self::validation($filters['filter_name']);
		    if (strlen($filters['symbol']) > 2) {
		        throw new Exception ('Проверь количество символов');
		    }

		    /* валидация логина (email), пароля (password) и $query_condition будет здесь ?
		     
			$query_string = 'SELECT * FROM '.static::$table_name.' WHERE email = ';
			$data = Database::getConnect()->query($query_string."$1", (array)$post[0]['email']);

			if (!isset($data) ?? $data[0]['password'] !== md5($password)) {
				throw new Exception ("Некорректный логин или пароль");
			}
			*/

		    /* 
		    тут разбираем и формируем входящие данные в нужный для запроса формат - запрос с плейсхолдерами и массив значений
		    $query_values['плейсхолдер' => 'значение']
		    $query_filters['дефолтный номер ключа' => 'имя_фильтра "пробел" знак "пробел" плейсхолдер'] 
		    */

        	$filter = null;
		    // $query_values
		    foreach ($filters as $filter_name => $value) {
			    if ($filter_name == 'value') {
				    $query_values['$'.$placeholder_num] = $value;

				    /*
				    для инсёрта у значений нужны кавычки, но их не должно быть у значений с типом данных integer
				    upd. Вдруг, неожиданно кавычки не понадобились для строк. Возможно прошло какое-то обновление постгреса, пока что закомментил эту часть. 

				    if (str_contains($query_string, 'INSERT') && !is_numeric($value)) {
				        $query_values['$'.$placeholder_num] = "'".$value."'";
				    }
					*/

				    $value = '$'.$placeholder_num;
				    $placeholder_num++;
				}
			    $filter .= " ".$value;
		    }
		    // $query_filters
		    $query_filters[] = $filter;
		}

		// в зависимости от оператора запроса, собираем и формируем данные для запроса, после чего делаем запрос и кладём результат в $data
		if (str_contains($query_string, 'SELECT')) {
        	$query_filters = implode(' AND ', $query_filters);
        	$data = Database::getConnect()->query($query_string.$query_filters, $query_values);
	        return $data;
        }
        if (str_contains($query_string, 'INSERT')) {
        	// для инсёрта query_filters['дефолтный номер ключа' => 'имя_фильтра знак плейсхолдер'] переделываем в query_filters['имя_фильтра' => 'плейсхолдер'] из-за синтаксиса postgres
        	$insert_filters = [];
			foreach ($query_filters as $key => $value) {
				// по непонятной причине первый символ $value - пробел, потому начинаем с "1", а при использовании strpos пробел появляется в конце, "-1" его убирает
	        	$insert_filters[substr($value, 1, strpos($value, " ", 1)-1)] = substr($value, strrpos($value, " ", true));
	        }

			$query_placeholders = implode(", ", $insert_filters);
			$query_filters = implode(", ", array_keys($insert_filters));
	        $data = Database::getConnect()->query($query_string." (".$query_filters.") ".'VALUES'." (".$query_placeholders.")", $query_values);
	        return $data;
        }
        if (str_contains($query_string, 'UPDATE')) {
	        $query_filters = implode(', ', $query_filters);
			$data = Database::getConnect()->query($query_string.$query_filters." ".'WHERE '.$query_condition, $query_values);
			return $data;
        }
    }

    /**
     * Метод для получения одной конкретной сущности
     * @param integer $id поиск данных будет осуществляться по этому атрибуту
     * @return array результат запроса
     * @throws exception если провалена валидация, если был некорректный запрос
     * @var string $query_filters - т.н. "фильтр" с плейсхолдером для pg_prepare()
     * @var string $query_values - реальное значение т.н. "фильтра" для pg_execute()
     */
	public static function getOne($id)
	{
		self::intValidate($id);
		$query_filters = 'id = $1';
		$query_values[] = $id;
	    $data = Database::getConnect()->query('SELECT * FROM '.static::$table_name.' WHERE '.$query_filters, $query_values);
	    return $data;
	}

    /**
     * Метод для получения более одной сущности
     * @param $get
     * @return array|null
     * @throws Exception
     */
	public static function getAll($get)
	{
		if ($get == null) {
			$data = Database::getConnect()->query('SELECT * FROM '.static::$table_name, $get);
        	return $data;
		}

		$query_string = 'SELECT * FROM '.static::$table_name.' WHERE ';

		$data = self::filter($get, $query_string);
		return $data;
	}

	public static function create($post)
	{
		$query_string = 'INSERT INTO '.static::$table_name;

		$data = self::filter($post, $query_string);
        return $data;
	}

	public static function update($put, $query_condition = null, $id = null)
	{	
		if ($id !== null && $query_condition === null) {
			self::getOne($id);
			$query_condition = 'id = '.$id;
		} 
		elseif ($id !== null && $query_condition !== null) {
			$query_condition .= ' AND id = '.$id;
		}

        $query_string = 'UPDATE '.static::$table_name.' SET ';

	    $data = self::filter($put, $query_string, $query_condition);
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
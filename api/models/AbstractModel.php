<?php

/**
 * Require the Database.php file.
 * Require the ValidationTrait.php file.
 */
require_once __DIR__.'/../../Database.php';
require_once __DIR__.'/../../ValidationTrait.php';

/**
 * Абстрактная модель.
 */
abstract class AbstractModel {
	use Validation;

    /**
     * @var null integer
     */
	public $id = null;

    /**
     * Небольшая валидация полученных атрибутов на их фактическое существование у модели
     * @param string $value полученный для валидации атрибут
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
     * @param string $valid_data Данные для последующей работы
     * @param string $query_string Предсформированная строка запроса в БД.
     * @param string $query_condition условие "<...> WHERE $query_condition <...>" для запроса UPDATE.
     * @return array|void
     * @throws Exception
     */
	public static function filter($valid_data, $query_string, $query_condition = null)
    {
        /*
         * Массивы нужны для последующей корректной работы функций pg_prepare и pg_execute
         */
        $query_filters = [];
        $query_values = [];
        $placeholder_num = 1;
    	
        foreach ($valid_data as $arrays => $filters) {
        	// валидируем фильтры на соответствие атрибутам модели
        	self::validation($filters['filter_name']);
		    if (strlen($filters['symbol']) > 2) {
		        throw new Exception ('Проверь количество символов');
		    }

		    /*
		    Здесь старый кусок кода, который был оставлен уже не помню зачем.
		    Когда разберусь зачем он был нужен, перепишу/удалю его.

		    валидация логина (email), пароля (password) и $query_condition будет здесь ?
		     
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

            /*
             * Здесь происходит формирование данных для корректной работы pg_prepare и pg_execute.
             * Массив $query_values заполняется данными с плейсхолдерами в виде ключей.
             * Массив $query_filters заполняется названиями данных в виде ключей и плейсхолдерами на месте значений.
             */
        	$filter = null;

		    foreach ($filters as $filter_name => $value) {
			    if ($filter_name == 'value') {
				    $query_values['$'.$placeholder_num] = $value;

				    /*
				    для инсёрта у значений нужны кавычки, но их не должно быть у значений с типом данных integer
				    upd. Вдруг, неожиданно кавычки не понадобились для строк.
				    Возможно прошло какое-то обновление постгреса, пока что закомментил эту часть.

				    if (str_contains($query_string, 'INSERT') && !is_numeric($value)) {
				        $query_values['$'.$placeholder_num] = "'".$value."'";
				    }
					*/

				    $value = '$'.$placeholder_num;
				    $placeholder_num++;
				}
			    $filter .= " ".$value;
		    }
		    $query_filters[] = $filter;
		}

        /*
         * В зависимости от оператора запроса, собираем и формируем данные для запроса.
         * После этого делаем запрос и кладём результат запроса (данные) в $data.
         */
		if (str_contains($query_string, 'SELECT')) {
        	$query_filters = implode(' AND ', $query_filters);
        	$data = Database::getConnect()->query($query_string.$query_filters, $query_values);
	        return $data;
        }
        if (str_contains($query_string, 'INSERT')) {
            /*
             * Для запроса INSERT есть особенность синтаксиса в postgres.
             * query_filters['дефолтный номер ключа' => 'имя_фильтра знак плейсхолдер'] переделывается в
             * query_filters['имя_фильтра' => 'плейсхолдер']
             */
        	$insert_filters = [];
			foreach ($query_filters as $key => $value) {
                /*
                 * По непонятной причине первый символ $value - пробел, потому начинаем с "1".
                 * При использовании strpos() пробел появляется в конце, "-1" его убирает.
                 */
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
     * Метод для получения одного блока данных
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
     * Метод для получения более одного блока данных.
     * По текущей задумке, если нужны все данные БД, то присылается пустота в $get.
     * @param array $get Данные, по которым будет происходить поиск.
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

    /**
     * Метод создания чего-либо.
     * @param array $post Новые данные
     * @return array|null
     * @throws Exception
     */
	public static function create($post)
	{
		$query_string = 'INSERT INTO '.static::$table_name;

		$data = self::filter($post, $query_string);
        return $data;
	}

    /**
     * Метод обновления данных какой-то сущности.
     * @param array $put Данные для обновления.
     * @param string $query_condition Часть строки запроса с условием: "<...> WHERE $query_condition <...>"
     * @param integer $id id сущности, в которой будет обновление данных
     * @return array|null
     * @throws Exception
     */
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

    /**
     * Метод удаления сущности.
     * @param integer $id id сущности, которую предстоит удалить.
     * @return array|void
     * @throws exception
     */
	public static function delete($id)
	{
        /*
         * Формирование массивов для корректной работы pg_prepare и pg_execute
         */
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
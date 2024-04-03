<?php
require_once __DIR__.'/Database.php';

trait Validation {

	public static function strValidate($valid_data)
    {
	    if (strlen($valid_data) < 1) {
	        throw new exception ("поле не может быть пустым");
	    }
	    if (!ctype_alpha($valid_data)) {
	        throw new exception ("поле содержит цифры");
	    }
        return true;
    }

    public static function intValidate($valid_data)
    {
    	if (!is_numeric($valid_data)) {
    		throw new exception ($valid_data." не является числом");
    	}
    	return true;
    }

    public static function filter($valid_data, $table_name)
    {
        // если входящие данные отсутствуют, возвращаем все записи из таблицы
        if ($valid_data == null) {
            $data = Database::getConnect()->query('SELECT * FROM '.$table_name);
            return $data;
        }

        // тут разбираем и формируем входящие данные в нужный для запроса формат (добавляем кавычки)
        $data_keys = array_keys($valid_data);
        $data_values = array_values($valid_data);
        foreach ($data_values as $key => $value){
            $data_values[$key] = "'".$value."'";
        }

        // тут создаётся строка с будущим запросом
        $query_in_str = null;
        $counter = 0;
        while (count($data_values) > $counter) {
            if ($counter >= 1) {
                $query_in_str .= ' AND ';
            }
            $query_in_str .= $data_keys[$counter]." = ";
            $query_in_str .= $data_values[$counter];
            $counter++;
        }

        $data = Database::getConnect()->query('SELECT * FROM '.$table_name.' WHERE '.$query_in_str);
        return $data;
    }

    public static function duplicateValidate($valid_data, $table_name)
    {
        $possible_double = self::filter($valid_data, $table_name);
        if ($possible_double != null) {
            throw new exception ("Такая сущность уже существует");
        }
        return true;
    }
}
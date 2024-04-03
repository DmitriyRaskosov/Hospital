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

    public static function duplicateValidate($valid_data, $table_name)
    {
    	$data_keys = array_keys($valid_data);
    	$data_values = array_values($valid_data);
    	$possible_double = Database::getConnect()->query('SELECT * FROM '.$table_name.' WHERE '.$data_keys[0].' = '."'".$data_values[0]."'".' AND '.$data_keys[1].' = '."'".$data_values[1]."'");
        if ($possible_double != null) {
            throw new exception ("Такая сущность уже существует");
        }
    }
}
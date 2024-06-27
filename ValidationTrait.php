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
        $possible_double = self::filter($valid_data, $table_name);
        if ($possible_double != null) {
            throw new exception ("Такая сущность уже существует");
        }
        return true;
    }
}
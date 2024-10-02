<?php
require_once __DIR__.'/Database.php';

/**
 * Трейт валидации.
 * Валидирует строки, числа. Может искать дубли данных в БД.
 */
trait Validation {

    /**
     * Метод валидации строк.
     * @param string $valid_data Строка для валидации.
     * @return true
     * @throws exception
     */
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

    /**
     * Метод валидации чисел.
     * @param integer $valid_data Число для валидации.
     * @return true
     * @throws exception
     */
    public static function intValidate($valid_data)
    {
    	if (!is_numeric($valid_data)) {
    		throw new exception ($valid_data." не является числом");
    	}
    	return true;
    }

    /**
     * Метод валидации (нахождения) дублей в БД.
     * Используется при создании новых данных методом create() абстрактной модели.
     * @param array $valid_data Данные, по которым будет произведён поиск.
     * @param string $table_name Название таблицы БД, в которой будет произведён поиск.
     * @return true
     * @throws exception
     */
    public static function duplicateValidate($valid_data, $table_name)
    {
        $possible_double = self::filter($valid_data, $table_name);
        if ($possible_double != null) {
            throw new exception ("Такая сущность уже существует");
        }
        return true;
    }
}
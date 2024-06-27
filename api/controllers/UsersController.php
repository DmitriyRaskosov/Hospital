<?php

require_once 'AbstractController.php';

class UsersController extends AbstractController {

	public static $model_name = 'Users';

	public static function userAuthorization($key)
	{
		$query_string = 'SELECT * FROM '.static::$model_name.' WHERE key = ';
		$data = Database::getConnect()->query($query_string."$1", (array)$key);

		if (!isset($data)) {
			throw new Exception ("Пожалуйста, войдите или зарегистрируйтесь");
		}

		return true;
	}

}
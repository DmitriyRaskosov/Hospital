<?php

require_once 'AbstractController.php';

class UsersController extends AbstractController {

	public static $model_name = 'Users';

	public function userAuthentification($post)
    {
        return static::$model_name::userAuthentification($post);
    }

    public function userAuthorization($header_keys)
	{
		parent::authCheck($header_keys);
		$query_string = 'SELECT * FROM '.static::$model_name.' WHERE key = ';
		$data = Database::getConnect()->query($query_string."$1", (array)$key);

		if (!isset($data)) {
			throw new Exception ("Пожалуйста, войдите или зарегистрируйтесь");
		}

		return true;
	}

}
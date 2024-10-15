<?php
namespace api\controllers;
require_once 'AbstractController.php';

/*
 * Контроллер пользователей.
 */
class UsersController extends AbstractController {

    /**
     * @var string $model_name Наименование таблицы в БД
     */
	public static $model_name = 'Users';

    /**
     * Метод аутентификации пользователя.
     * @param array $post Массив данных для аутентификации
     * @return string временный ключ для авторизации
     */
	public static function userAuthentification($post)
    {
        return Users::userAuthentification($post);
    }

    /**
     * Метод авторизации пользователя.
     * При неудачной авторизации (если истёк срок годности ключа аутентификации), нужен новый ключ аутентификации.
     * Новый ключ аутентификации создаётся в методе модели пользователей.
     * @param array $header_keys массив ключей header.
     * @return bool
     * @throws Exception
     */
    public static function userAuthorization($header_keys)
	{
		if (!array_key_exists('Authorization', $header_keys)) {
            return false;
        }

		$query_string = 'SELECT * FROM Users WHERE key = ';
		$data = Database::getConnect()->query($query_string."$1", (array)$header_keys['Authorization']);

		if (isset($data)) {
			$current_time = new DateTime(date('Y-m-d H:i:s', time()));
			$key_time = new DateTime($data[0]['key_timestamp']);

			$time_diff = $current_time->diff($key_time);
			if ($time_diff >= 7) {
				return false;
			}
		} else {
			return false;
		}
		return true;
	}
}
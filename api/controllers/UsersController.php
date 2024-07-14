<?php

require_once 'AbstractController.php';

class UsersController extends AbstractController {

	public static $model_name = 'Users';

	public static function userAuthentification($post)
    {
        return Users::userAuthentification($post);
    }

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
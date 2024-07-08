<?php

require_once __DIR__.'/AbstractModel.php';

class Users extends AbstractModel {

	public static $table_name = 'Users';

	public static $attributes = ['email', 'password', 'role_mask', 'key', 'key_timestamp'];

	// метод аутентификации пользователя 
	public static function userAuthentification($post)
	{
		// в начале метода создаётся условие " <...> WHERE $query_condition " для запроса UPDATE, который будет вызван в одноимённом родительском методе абстрактной модели;
		$query_condition = null;
		foreach ($post as $arrays => $filters) {
			if ($filters['filter_name'] == 'email') {
				$query_condition = 'email = '."'".$post[$arrays]['value']."'";
				break;
			}
		}
		echo $query_condition;

		// тут происходит генерация нового хеш-ключа и указывается дата и время генерации, результаты помещаются в массив $data_gen с соответствующими ключами;
		$data_gen = [];
		$data_gen['key'] =  md5(bin2hex(random_bytes(5)));
		$data_gen['key_timestamp'] = date('Y-m-d H:i:s', time());

		// здесь данные переделываются в формат декодированного JSON'а, так как метод update родителя, в котором будет происходить вся последующая работа, получает данные из http-метода PUT в виде JSON
		$new_data = [];
		$counter = 0;
		foreach ($data_gen as $key => $value) {
			$new_data[$counter]['filter_name'] = $key;
			$new_data[$counter]['symbol'] = '=';
			$new_data[$counter]['value'] = $value;
			$counter++;
		}

		// вызов метода update родительского класса AbstractModel для обновления хеш-ключа и времени его генерации непосредственно в таблице users БД
		parent::update($new_data, $query_condition);

		// возврат хеш-ключа для того, чтобы видеть, сработал ли код. Пользователю, в конце-концов, будет возвращаться true или какое-то сообщение.
		return $data_gen['key'];
	}
}
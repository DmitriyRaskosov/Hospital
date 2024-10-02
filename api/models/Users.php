<?php

require_once __DIR__.'/AbstractModel.php';

/**
 * Модель пользователей.
 */
class Users extends AbstractModel {

    /**
     * @var string $table_name Наименование таблицы в БД.
     */
	public static $table_name = 'Users';

    /**
     * @var array $attributes Массив названий атрибутов пользователя в БД.
     */
	public static $attributes = ['email', 'password', 'role_mask', 'key', 'key_timestamp'];

    /**
     * Переопределённый метод абстрактного метода модели для создания нового пользователя.
     *
     * @param array $post массив данных нового пользователя
     * @return array|void|null возврат данных нового пользователя
     * todo Возможно изменю возврат булевых вместо данных
     * @throws Exception
     */
	public static function create($post)
	{
        // $query_string - создание строки запроса
		$query_string = 'INSERT INTO '.static::$table_name;
		foreach ($post as $arrays => $filters) {
			if ($filters['filter_name'] == 'password') {
				$post[$arrays]['value'] = md5($post[$arrays]['value']);
				break;
			}
		}
        // вызов родительского метода модели для формирования запроса к БД
		$data = parent::filter($post, $query_string);

        // создание ключа аутентификации
		self::userAuthentification($post);

        return $data;
	}

    /**
     * Метод создания ключа для аутентификации пользователя.
     * @param array $post массив данных нового пользователя
     * @return string возврат ключа для аутентификации
     * @throws \Random\RandomException
     * todo Заменить возврат ключа на какое-то нейтральное сообщение.
     */
	public static function userAuthentification($post)
	{
        /*
         * Здесь создаётся условие "<...> WHERE $query_condition <...>" для запроса UPDATE.
         * Запрос UPDATE будет вызван в одноимённом родительском методе абстрактной модели.
         */
		$query_condition = null;
		foreach ($post as $arrays => $filters) {
			if ($filters['filter_name'] == 'email') {
				$query_condition = 'email = '."'".$post[$arrays]['value']."'";
				break;
			}
		}

        /*
         * Тут происходит генерация нового хеш-ключа и указывается дата и время генерации.
         * Результаты помещаются в массив $data_gen с соответствующими ключами.
         */
		$data_gen = [];
		$data_gen['key'] =  md5(bin2hex(random_bytes(5)));
		$data_gen['key_timestamp'] = date('Y-m-d H:i:s', time());

        /*
         * Здесь данные переделываются в формат декодированного JSON.
         * Это необходимо из-за метода update родителя, в котором будет происходить вся последующая работа.
         * Метод update получает данные из http-метода PUT в виде декодированного JSON.
         */
		$new_data = [];
		$counter = 0;
		foreach ($data_gen as $key => $value) {
			$new_data[$counter]['filter_name'] = $key;
			$new_data[$counter]['symbol'] = '=';
			$new_data[$counter]['value'] = $value;
			$counter++;
		}

        /*
         * Вызов метода update родительского класса AbstractModel для обновления данных для аутентификации.
         * Обновляется сам хеш-ключ и время его генерации в таблице users БД.
         */
		parent::update($new_data, $query_condition);

        /*
         * Возврат хеш-ключа для того, чтобы видеть, сработал ли код.
         */
		return $data_gen['key'];
	}
}
<?php

class Database {
    
    protected static $dbconn;
    public $host = 'localhost';
    public $dbname = 'furniture_shop';
    public $user = 'postgres';
    public $password = 'postgres';

    protected function __construct()
    {
        $this->connect = pg_connect('host='.$this->host." ".'dbname='.$this->dbname." ".'user='.$this->user." ".'password='.$this->password)
        or throw new exception('Не удалось соединиться: '.pg_last_error());

    }

    public static function getConnect() {
        if (self::$dbconn === null) {
            self::$dbconn = new self();
        }
        return self::$dbconn;
    }

    // query - запрос "фильтров" с плейсхолдерами, values - значения "фильтров" запроса (фильтр = значение)
    public function query($query, $values)
    {
        $query_prepared = pg_prepare(self::$dbconn->connect, '', $query);
        $query_result = pg_execute(self::$dbconn->connect, '', $values);

        if (pg_result_error(pg_get_result(self::$dbconn->connect)) != null) {
            throw new exception('Ошибка запроса: '.$error_check);
        }
        while ($temp_result = pg_fetch_assoc($query_result)) {
            $result[] = $temp_result;
        }
        return $result;
    }
}
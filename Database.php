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
        $queryyy = pg_prepare(self::$dbconn->connect, '', $query);
        $query_result = pg_execute(self::$dbconn->connect, '', $values) or throw new exception('Ошибка запроса: '.pg_last_error());
        while ($temp_result = pg_fetch_assoc($query_result)) {
            $result[] = $temp_result;
        }
        return $result;
    }

    public function migration_query($query_string)
    {
        $result = pg_query(self::$dbconn->connect, $query_string);
        return $result;
    }
}
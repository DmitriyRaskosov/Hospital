<?php

class Database {
    
    public $query;

    public function __construct()
    {
        $dbconn = pg_connect()
        or die('Не удалось соединиться: '.pg_last_error());
    }

    public function query($query): array
    {
        $result = pg_query($query) or die('Ошибка запроса: '.pg_last_error());
        return $result;
    }
}
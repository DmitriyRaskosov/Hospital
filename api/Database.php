<?php

class Database {
    
    public $query;

    public function __construct()
    {
        $dbconn = pg_connect('host=localhost dbname=durka user=Dmitriy password=25631940')
        or throw new exception('Не удалось соединиться: '.pg_last_error());
    }

    public function query($query):
    {
        $result = pg_query($query) or throw new exception('Ошибка запроса: '.pg_last_error());
        return pg_fetch_assoc($result);
    }
}
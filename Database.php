<?php

class Database {
    
    public $dbconn;
    public $host = 'localhost';
    public $dbname = 'durka';
    public $user = 'postgres';
    public $password = 'postgres';

    public function __construct()
    {
        $this->dbconn = pg_connect('host='.$this->host." ".'dbname='.$this->dbname." ".'user='.$this->user." ".'password='.$this->password)
        or throw new exception('Не удалось соединиться: '.pg_last_error());
    }

    public function query($query)
    {
        $query_result = pg_query($this->dbconn, $query) or throw new exception('Ошибка запроса: '.pg_last_error());
        while ($temp_result = pg_fetch_assoc($query_result)) {
            $result[] = $temp_result;
        }
        return $result;
    }
}
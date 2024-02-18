<?php

class Database {
    
    public $query;
    public $dbconn;
    public function __construct()
    {
        $this->dbconn = pg_connect('host=localhost dbname=durka user=postgres password=postgres')
        or throw new exception('Не удалось соединиться: '.pg_last_error());
        print_r("\n"); print_r($this->dbconn); print_r("\n");
    }

    public function query($query)
    {
        $query_result = pg_query($this->dbconn, $query) or throw new exception('Ошибка запроса: '.pg_last_error());
        while ($result[] = pg_fetch_assoc($query_result)) {
        }
        print_r("\n"); print_r($result); print_r("\n");
        return $result;
    }

}

$test_db = new Database;

$new_query = $test_db->query('SELECT * FROM Doctors');
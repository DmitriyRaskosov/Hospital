<?php

class Database {
    
    public $query;
    public $dbconn;
    public $host;
    public $dbname;
    public $user;
    public $password;

    public function __construct($host, $dbname, $user, $password)
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->user = $user;
        $this->password = $password;
        $this->dbconn = pg_connect('host='.$this->host." ".'dbname='.$this->dbname." ".'user='.$this->user." ".'password='.$this->password)
        or throw new exception('Не удалось соединиться: '.pg_last_error());
        print_r("\n"); print_r($this->dbconn); print_r("\n");
    }

    public function query($query)
    {
        $query_result = pg_query($this->dbconn, $query) or throw new exception('Ошибка запроса: '.pg_last_error());
        while ($temp_result = pg_fetch_assoc($query_result)) {
            $result[] = $temp_result;
        }
        print_r("\n"); print_r($result); print_r("\n");
        return $result;
    }

}

$test_db = new Database('localhost', 'durka', 'postgres', 'postgres');
$new_query = $test_db->query('SELECT * FROM Doctors');
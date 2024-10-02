<?php

/**
 * Класс подключения к БД.
 * Для pg_connect используются переменные с хардкодом внутри, потому что кроме меня этим проектом никто не пользуется.
 */
class Database {

    /**
     * @var object $dbconn Экземпляр класса.
     */
    protected static $dbconn;

    /**
     * @var string $host Наименование хоста.
     */
    public $host = 'localhost';

    /**
     * @var string $dbname Название БД.
     */
    public $dbname = 'furniture_shop';

    /**
     * @var string $user Логин пользователя.
     */
    public $user = 'postgres';

    /**
     * @var string $password Пароль пользователя.
     */
    public $password = 'postgres';

    /**
     * Здесь Происходит подключение к БД при создании экземпляра класса.
     * @throws exception
     */
    protected function __construct()
    {
        $this->connect = pg_connect('host='.$this->host." ".'dbname='.$this->dbname." ".'user='.$this->user." ".'password='.$this->password)
        or throw new exception('Не удалось соединиться: '.pg_last_error());
    }

    /**
     * Геттер подключения к БД.
     * @return object|self
     */
    public static function getConnect() {
        if (self::$dbconn === null) {
            self::$dbconn = new self();
        }
        return self::$dbconn;
    }

    /**
     * Метод, который отправляет запрос в БД и возвращает результат (данные) запроса по полученным в сигнатуре фильтрам.
     * @param string $query запрос "фильтров" с плейсхолдерами вместо значений
     * @param string $values реальные значения "фильтров" запроса
     * @return array данные, полученные в ходе запроса.
     */
    public function query($query, $values)
    {
        $query_prepared = pg_prepare(self::$dbconn->connect, '', $query);
        $query_result = pg_execute(self::$dbconn->connect, '', $values);

        while ($temp_result = pg_fetch_assoc($query_result)) {
            $result[] = $temp_result;
        }
        return $result;
    }
}
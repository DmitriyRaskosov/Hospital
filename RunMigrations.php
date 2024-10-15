<?php
require_once __DIR__.'/Database.php';

/*
Этот скрипт предназначен для миграции.
Предварительно, скрипт будет состоять из трёх частей внутри:
1. Часть, которая прочитает названия всех файлов и сложит их в массив. 
Очередь чтения файлов будет зависеть от названия самих файлов, потому файлы пронумерованы с начала.
2. Часть, которая будет отвечать за взаимодействия с классом для подключений к БД.
3. Часть, отвечающая за проверку результата успешности выполнения запроса второй частью через код возврата.
Если результат положительный, то скрипт переходит к чтению следующего файла и остальным операциям.
Если результат отрицательный, то миграция прерывается и выбрасывается exception.
*/

class RunMigrations {

	public static $directory;

	// метод, который прочитает названия всех файлов миграции, отформатирует их нужным нам образом и сложит в массив.
	public static function readFiles($directory)
	{
        /*
         * Сначала записываем в $filenames_array названия всех файлов при помощи scandir.
         * Затем убираем первые два значения "." и ".." при помощи array_diff.
         * После - используем array_values для "обнуления" ключей.
         */
		$filenames_array = array_values(array_diff(scandir($directory), [".", ".."]));
		print_r($filenames_array);
		
		return $filenames_array;
	}

    /*
     * Метод, который вызывает подключение к БД, поочерёдно читает файлы и отправляет содержимое запросом в БД.
     * Из-за использования функций pg_prepare и pg_execute для запроса в БД, передаём (array)null в кач-ве значения.
     */
	public static function pushQuery($obj)
	{
		echo $obj->directory;
		$filenames_array = $obj->readFiles($obj->directory);
		$results = [];
		foreach ($filenames_array as $key => $value) {
			$query_string = file_get_contents($obj->directory."/".$value);
			$results[] = Database::getConnect()->query($query_string, (array)null);
		}
		return $results;
	}

}
$test = new RunMigrations();
$test->directory = __DIR__."\migrations";

print_r($test->pushQuery($test));
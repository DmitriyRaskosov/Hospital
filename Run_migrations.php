<?php
require_once 'Database.php';

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

class Run_migrations {

	public static $directory;

	// метод, который прочитает названия всех файлов миграции, отформатирует их нужным нам образом и сложит в массив.
	public static function fileReader($directory)
	{
		// записываем в $filenames_array названия всех файлов при помощи scandir, убираем первые два значения "." и ".." при помощи array_diff и используем array_values для "обнуления" ключей.
		$filenames_array = array_values(array_diff(scandir($directory), [".", ".."]));
		print_r($filenames_array);
		
		return $filenames_array;
	}

	// метод, который получит массив названий файлов миграции, создаст подключение к БД, поочерёдно прочитает каждый файл и отправит содержимое запросом в БД
	public static function queryPusher($obj)
	{
		echo $obj->directory;
		$filenames_array = $obj->fileReader($obj->directory);
		$results = [];
		foreach ($filenames_array as $key => $value) {
			$query_string = file_get_contents($obj->directory."/".$value);
			$results[] = Database::getConnect()->migration_query($query_string);
		}
		return $results;
	}

}
$test = new Run_migrations();
$test->directory = __DIR__."\migrations";

print_r($test->queryPusher($test));
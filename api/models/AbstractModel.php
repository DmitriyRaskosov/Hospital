<?php

require_once __DIR__.'/../../Database.php';

abstract class AbstractModel {

	public $id = null;

	public static $path;

	public static function getOne($id)
	{
	    $db_data = new Database();
	    $data = $db_data->query('SELECT * FROM Patients WHERE id='.$id);
	    return $data;
	}
	
	public static function getAll()
	{
		$db_data = new Database();
		$data = $db_data->query('SELECT * FROM Patients');
		return $data;
	}

	public static function create($post)
	{
		$db_data = new Database();
		$data = $db_data->query('INSERT INTO Patients (first_name, last_name) VALUES'." ("."'".$post['first_name']."'".","."'".$post['last_name']."'".")");
        return $data;
	}

	public static function update($id, $changed_data)
	{
		$data = ((array)json_decode(file_get_contents(static::$path), true));
        $result = 'undefined result';
        foreach ($data as $key => $entity) {
            if ($entity['id'] == $id) {
                $data[$key]['id'] = $id;
                print_r($data[$key]);
                $data[$key] = array_merge($data[$key], $changed_data);
                $result = $data[$key];
                $new_data = json_encode($data);
                $new_data = file_put_contents(static::$path, $new_data);
                break;
            }
        }
    	return $result;
    }

	public static function delete($id)
	{
		$flag_match = 0;
		$data = ((array)json_decode(file_get_contents(static::$path), true));
		foreach ($data as $key => $value) {
			if ($id == $value['id']) {
				unset($data[$key]);
				$flag_match = 1;
				echo "данные удалены"."<br>";
                print_r($data);
				break;
			}
		}
		if ($flag_match != 1) {
			exit ("искомые данные для удаления не найдены");
		}
		if (count($data) >= 1) {
            $new_data = [];
			$new_data[] = json_encode(array_values($data));
	   		$new_data = file_put_contents(static::$path, $new_data);
			return $data;
		} elseif (count($data) < 1) {
			return 'данных больше нет, всё удалено';
		}	
	}
}
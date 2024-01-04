<?php

abstract class AbstractModel {

	public $id = null;

	public static $path;

	public static function getOne($id)
	{
    $data = (array)json_decode(file_get_contents(static::$path), true);
	    $match = 0;
	    foreach ($data as $key => $value) {
	      	if ($id == $value['id']) {
		        $match = 1;
		        $responce[] = $value;
		        break;
	      	}
	    }
	    if ($match == 0) {
	      throw new exception('запись не найдена!');
	    }
	    return $responce;
	}
	
	public static function getAll()
	{
		return ((array)json_decode(file_get_contents(static::$path), true));
	}

	public static function create($post)
	{
		$data = ((array)json_decode(file_get_contents(static::$path), true));
        print_r($data);
        $max_id = null;
        foreach ($data as $key => $value) {
            if (isset($value['id'])) {
                if ($max_id < $value['id']) {
                    $max_id = $value['id'];
                }
            } else {
                $max_id = 0;
            }
        }
        $new_id = $max_id + 1;
        $post['id'] = $new_id;
	    $new_appointment[] = (array) $post;
	    $new_data = array_merge($data, $new_appointment);

	    $new_data = json_encode($new_data);
	    $new_data = file_put_contents(static::$path, $new_data);
	    return $new_appointment;
	}

	public static function update($id, $changed_data)
	{
		$data = ((array)json_decode(file_get_contents(static::$path), true));
        $result = 'undefined result';
        print_r($data);
        foreach ($data as $key => $entity) {
            if ($entity['id'] == $id) {
                print_r($changed_data);
                $data[$key]['id'] = $id;
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
            print_r($data);

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
            print_r($new_data);
	   		$new_data = file_put_contents(static::$path, $new_data);
			return $data;
		} elseif (count($data) < 1) {
			return 'данных больше нет, всё удалено';
		}	
	}
}
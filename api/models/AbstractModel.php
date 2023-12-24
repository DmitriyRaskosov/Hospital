<?php

abstract class AbstractModel {

	public $id = null;

	public static $path;

	public function getOne($id)
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
	
	public function getAll()
	{
		return ((array)json_decode(file_get_contents(static::$path), true));
	}

	public function createId()
	{
		$data = ((array)json_decode(file_get_contents(static::$path), true));
		$max_num = null;
		foreach ($data as $key => $value) {
			if (isset($value['id'])) {
				if ($max_num < $value['id']) {
					$max_num = $value['id'];
				}
			} else {
				$max_num = 0;
			}	
		}
        return $max_num + 1;
	}

	public function create($name, $date, $doctor_type)
	{	
		$data = ((array)json_decode(file_get_contents(static::$path), true));
	    $new_appointment[] = (array) $object;
	    $new_data = array_merge($data, $new_appointment);

	    $new_data = json_encode($new_data);
	    $new_data = file_put_contents(static::$path, $new_data);
	    return $new_appointment;
	}

	public function update($id, array $changed_data)
	{
		$data = ((array)json_decode(file_get_contents(static::$path), true));
        $result = 'undefined result';
        foreach ($data as $key => $entity) {
            if ($entity['id'] == $id) {
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

	public function delete($id)
	{
		$flag_match = 0;
		$data = ((array)json_decode(file_get_contents(static::$path), true));

		foreach ($data as $key => $value) {
            print_r($value);
			if ($id == $value['id']) {
				unset($data[$key]);
				$flag_match = 1;
				echo "данные удалены"."<br>";
				break;
			}
		}
		if ($flag_match != 1) {
			exit ("искомые данные для удаления не найдены");
		}
		if (count($data) >= 1) {
			$new_data = json_encode($data);
	   		$new_data = file_put_contents(static::$path, $new_data);
			return $data;
		} elseif (count($data) < 1) {
			return 'данных больше нет, всё удалено';
		}	
	}
}
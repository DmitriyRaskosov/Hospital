<?php

abstract class AbstractModel {

	public $id = null;

	public function getOne($id, $path)
	{	
		$data = (array)json_decode(file_get_contents($path), true);
		$match = 0;
		foreach ($data as $key => $value) {
			if ($id == $value['id']) {
				$match = 1;
				$responce[] = $value;
				return $responce;
			}
		}
		if ($match == 0) {
			$responce[] = ['result' => "Запись не найдена!"];
			return $responce;
		}
	}

	public function getAll($path)
	{
		return ((array)json_decode(file_get_contents($path), true));
	}

	public function createId($path)
	{
		$data = ((array)json_decode(file_get_contents($path), true));
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
		$new_id = $max_num + 1;
		return $new_id;
	}

	public function create($object, $path)
	{	
		$data = ((array)json_decode(file_get_contents($path), true));
	    $new_appointment[] = (array) $object;
	    $new_data = array_merge($data, $new_appointment);

	    $new_data = json_encode($new_data);
	    $new_data = file_put_contents('../../data/appointments.json', $new_data);
	    return $new_appointment;
	}

	public function update($id, $date, $path)
	{
		$data = ((array)json_decode(file_get_contents($path), true));
		foreach ($data as $key => $value) {
			if ($id == $value['id']) {
				$data[$key]['date'] = $date;
				$new_data = json_encode($data);
	    		$new_data = file_put_contents('../../data/appointments.json', $new_data);
				return $data[$key]['date'];
			}
		}
	}

	public function delete($id, $path)
	{
		$flag_match = 0;
		$data = ((array)json_decode(file_get_contents($path), true));

		foreach ($data as $key => $value) {
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
	   		$new_data = file_put_contents('../../data/appointments.json', $new_data);
			return $data;
		} elseif (count($data) < 1) {
			return 'данных больше нет, всё удалено';
		}	
	}
}
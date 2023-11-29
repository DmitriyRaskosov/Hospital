<?php

abstract class AbstractModel {

	public $id = null;

	public static function getOne($id, $data)
	{
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

	// метод getAll отсутствует здесь за ненадобностью - каждый потомок самостоятельно берёт все данные из нужного файла

	public function createId($data)
	{
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


	public function update($id, $date, $data)
	{
		foreach ($data as $key => $value) {
			if ($id == $value['id']) {
				$data[$key]['date'] = $date;
				break;
			}
		}
		return $updated_data;
	}

	public function delete($id, $data)
	{
		$flag_match = 0;

		foreach ($data as $key => $value) {
			if ($id == $value['id']) {
				unset($data[$key]);
				$flag_match = 1;
				return $data;
			}
		}
		if ($flag_match == 0) {
			$responce[] = ['result' => "Запись не найдена!"];
			return $responce;
		}
	}
}
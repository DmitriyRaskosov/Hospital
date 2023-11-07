<?php

class Model
{
	public function getOne($id, $data)
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

	public function getAll($data)
	{
		$data = json_encode($data);
		return $data;
	}
}
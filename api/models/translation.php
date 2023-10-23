<?php

header('Content-Type: application/json; charset=utf-8');

function getOne($en, $data)
{
	$match = 0;
	foreach ($data as $key => $value) {
		if ($en == $value['en']) {
			$match = 1;
			$responce[] = $value;
			$responce = json_encode($responce);
			return $responce;
		}
	}
	if ($match == 0) {
		$responce[] = ['result' => "Перевод не найден!"];
		$responce = json_encode($responce);
		return $responce;
	}
}


function getAll($data)
{
	$data = json_encode($data);
	return $data;
}


function create($en, $ru, $data)
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
	$new_translation = [
		'id' => $new_id,
		'en' => $en,
		'ru' => $ru
	];

	$responce[] = $new_translation;
	$responce = json_encode($responce);
	return $responce;
}


function update($prev_en, $new_en, $ru, $data)
{
	foreach ($data as $key => $value) {
		if ($prev_en == $value['en']) {
			$data[$key]['en'] = $new_en;
			$data[$key]['ru'] = $ru;
			break;
		}
	}
	$updated_data = json_encode($data);
	return $updated_data;
}


function delete($en, $data)
{
	$flag_match = 0;
	$result = [];
	foreach ($data as $key => $value) {
		if ($en == $value['en']) {
			unset($data[$key]);
			$flag_match = 1;
			$data = array_values($data);
			$data = json_encode($data);
			return $data;
		}
	}
	if ($flag_match == 0) {
		$responce[] = ['result' => "Перевод не найден!"];
		$responce = json_encode($responce);
		return $responce;
	}
}
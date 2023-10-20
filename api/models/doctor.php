<?php

header('Content-Type: application/json; charset=utf-8');

function doctor($id, $data) 
{
	$match = 0;
	foreach ($data as $key => $value) {
		if ($id == $value['id']) {
			$match = 1;
			$responce[] = $value;
			$responce = json_encode($responce);
			return $responce;
		}
	}
	if ($match == 0) {
		$responce[] = ['result' => "Запись не найдена!"];
		$responce = json_encode($responce);
		return $responce;
	}
}


function doctors($data)
{
	$data = json_encode($data);
	return $data;
}


function create($name, $doctor_type, $cost, $data)
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
	$new_doctor = [
		'id' => $new_id,
		'name' => $name,
		'doctor_type' => $doctor_type,
		'cost' => $cost
	];

	$responce[] = $new_doctor;
	$responce = json_encode($responce);
	return $responce;
}


function update($id, $cost, $data)
{
	foreach ($data as $key => $value) {
		if ($id == $value['id']) {
			$data[$key]['cost'] = $cost;
			break;
		}
	}
	$updated_data = json_encode($data);
	return $updated_data;
}


function delete_doctor($id, $data)
{
	$flag_match = 0;

	foreach ($data as $key => $value) {
		if ($id == $value['id']) {
			unset($data[$key]);
			$flag_match = 1;
			$data = json_encode($data);
			return $data;
		}
	}
	if ($flag_match == 0) {
		$responce[] = ['result' => "Доктор не найден!"];
		$responce = json_encode($responce);
		return $responce;
	}
}
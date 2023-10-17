<?php

header('Content-Type: application/json; charset=utf-8');

function appointment($id, $data) 
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

// кажется бессмысленным, но я просто привёл всё к более-менее единому формату + возможно от этой функции будет требоваться что-то ещё.
function appointments($data)
{
	$data = json_encode($data);
	return $data;
}


function create_appointment($name, $date, $doctor_type, $data)
{
	$max_num = null;
	foreach ($data as $key => $value) {
		if ($max_num < $value['id']) {
			$max_num = $value['id'];
		}
	}

	$new_id = $max_num + 1;
	$new_appointment = [
		'id' => $new_id,
		'name' => $name,
		'date' => $date,
		'doctor_type' => $doctor_type
	];

	$responce[] = $new_appointment;
	$responce = json_encode($responce);
	return $responce;
}


function update_appointment($id, $date, $data)
{
	foreach ($data as $key => $value) {
		if ($id == $value['id']) {
			$data[$key]['date'] = $date;
			break;
		}
	}
	$updated_data = json_encode($data);
	return $updated_data;
}


function delete_appointment($id, $data)
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
		$responce[] = ['result' => "Запись не найдена!"];
		$responce = json_encode($responce);
		return $responce;
	}
}
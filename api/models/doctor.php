<?php

header('Content-Type: application/json; charset=utf-8');

function doctor($id) 
{
	$doctors = file_get_contents('../../data/doctors.json');
	$doctors= (array)json_decode($doctors, true);

	$match = 0;
	foreach ($doctors as $key => $value) {
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

$test = doctor(1);
print_r($test);


function doctors()
{
	$doctors = file_get_contents('../../data/doctors.json');
	return $doctors;
}

$test = doctors();
print_r($test);


function create_doctor($name, $doctor_type, $cost)
{
	$doctors = file_get_contents('../../data/doctors.json');
	$doctors = (array)json_decode($doctors, true);

	$max_num = null;
	foreach ($doctors as $key => $value) {
		if ($max_num < $value['id']) {
			$max_num = $value['id'];
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

	$doctors[] = $new_doctor;
	$doctors = json_encode($doctors);
	file_put_contents('../../data/doctors.json', $doctors);
	
	$responce = json_encode($responce);
	return $responce;
}

$test = create_doctor('sirgay', 'endocrinologist', '5000');
print_r($test);


function update_doctor($id, $cost)
{
	$doctors = file_get_contents('../../data/doctors.json');
	$doctors = (array)json_decode($doctors, true);

	foreach ($doctors as $key => $value) {
		if ($id == $value['id']) {
			$doctors[$key]['cost'] = $cost;
			$responce[] = $doctors[$key];
			$responce = json_encode($responce);
			break;
		}
	}

	$doctors = json_encode($doctors);
	file_put_contents('../../data/doctors.json', $doctors);

	return $responce;
}

$test = update_doctor(1, '4999');
print_r($test);


function delete_doctor($id)
{
	$doctors = file_get_contents('../../data/doctors.json');
	$doctors = (array)json_decode($doctors, true);

	$flag_match = 0;

	foreach ($doctors as $key => $value) {
		if ($id == $value['id']) {
			unset($doctors[$key]);
			$flag_match = 1;
			$responce[] = ['result' => "Ты уволил доктора, больше некому щупать твою простату, сладенький!"];
			$responce = json_encode($responce);

			$doctors = json_encode($doctors);
			file_put_contents('../../data/doctors.json', $doctors);

			return $responce;
		}
	}
	if ($flag_match == 0) {
		$responce[] = ['result' => "Доктор не найден!"];
		$responce = json_encode($responce);
		return $responce;
	}
}

$test = delete_doctor(2);
print_r($test);
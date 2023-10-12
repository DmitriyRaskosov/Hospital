<?php

header('Content-Type: application/json; charset=utf-8');

function appointment($id) 
{
	$appointments = file_get_contents('../../data/appointments.json');
	$appointments = (array)json_decode($appointments, true);

	$match = 0;
	foreach ($appointments as $key => $value) {
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

$test = appointment(1);
print_r($test);


function appointments()
{
	$appointments = file_get_contents('../../data/appointments.json');
	return $appointments;
}

$test = appointments();
print_r($test);


function create_appointment($name, $date, $doctor_type)
{
	$appointments = file_get_contents('../../data/appointments.json');
	$appointments = (array)json_decode($appointments, true);

	$max_num = null;
	foreach ($appointments as $key => $value) {
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

	$appointments[] = $new_appointment;
	$appointments = json_encode($appointments);
	file_put_contents('../../data/appointments.json', $appointments);

	$responce = json_encode($responce);
	return $responce;
}

$test = create_appointment('sirgay', '20.03.2020', 'endocrinologist');
print_r($test);


function update_appointment($id, $date)
{
	$appointments = file_get_contents('../../data/appointments.json');
	$appointments = (array)json_decode($appointments, true);

	foreach ($appointments as $key => $value) {
		if ($id == $value['id']) {
			$appointments[$key]['date'] = $date;
			$responce[] = $appointments[$key];
			$responce = json_encode($responce);
			break;
		}
	}

	$appointments = json_encode($appointments);
	file_put_contents('../../data/appointments.json', $appointments);

	return $responce;
}

$test = update_appointment(3, '30-21-2020');
print_r($test);


function delete_appointment($id)
{
	$appointments = file_get_contents('../../data/appointments.json');
	$appointments = (array)json_decode($appointments, true);

	$flag_match = 0;

	foreach ($appointments as $key => $value) {
		if ($id == $value['id']) {
			unset($appointments[$key]);
			$flag_match = 1;
			$responce[] = ['result' => "Запись удалена!"];
			$responce = json_encode($responce);

			$appointments = json_encode($appointments);
			file_put_contents('../../data/appointments.json', $appointments);

			return print_r($responce);
		}
	}
	if ($flag_match == 0) {
		$responce[] = ['result' => "Запись не найдена!"];
		$responce = json_encode($responce);
		return print_r($responce);
	}
}

$test = delete_appointment(2);
print_r($test);
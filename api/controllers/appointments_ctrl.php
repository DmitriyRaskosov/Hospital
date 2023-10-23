<?php

header('Content-Type: application/json; charset=utf-8');

include_once '../models/appointment.php';
include_once '../translator.php';

// validation
/*
!isset($_GET['id']) || !(int)$_GET['id'] ? throw new exception('ID не указан, не является числовым значением или равен нулю') : NULL;
!isset($_POST['name']) || strlen($_POST['name']) <= 0 ? throw new exception('Имя не указано') : NULL;
!isset($_POST['date']) || strlen($_POST['date']) <= 0 ? throw new exception('Дата записи не указана') : NULL;
!isset($_POST['doctor_type']) || strlen($_POST['doctor_type']) <= 0 ? throw new exception('Врач не указан') : NULL;
*/
/*
include '../translator.php';
$data = add_translation($data);
*/

$request = $_REQUEST;
echo $request;
$data = file_get_contents('../../data/appointments.json');
$data = (array)json_decode($data, true);


// получить конкретную запись
if ($request['request_type'] == 'appointment') {
	$responce = appointment($request['id'], $data);
	print_r(add_translation($responce));
}

// получить все записи
if ($request['request_type'] == 'appointments') {
	$responce = appointments($data);
	print_r(add_translation($responce));
}

// создать новую запись
if ($request['request_type'] == 'create') {
	$created_appointment = create($request['name'], $request['date'], $request['doctor_type'], $data);
	print_r(add_translation($created_appointment));

	$created_appointment = (array)json_decode($created_appointment, true);
	foreach ($created_appointment as $key => $value) {
		$data[] = $created_appointment[$key];
	}
	$data = json_encode($data);
	file_put_contents('../../data/appointments.json', $data);
}

// обновить дату существующей записи
if ($request['request_type'] == 'update') {
	$updated_data = update($request['id'], $request['date'], $data);
	$updated_data = (array)json_decode($updated_data, true);

	$updated_appointment = appointment($request['id'], $updated_data);
	print_r(add_translation($updated_appointment));
	
	$updated_data = json_encode($updated_data);
	file_put_contents('../../data/appointments.json', $updated_data);
}

// удалить запись
if ($request['request_type'] == 'delete') {
	$responce = [];
	$result = delete($request['id'], $data);
	$result = (array)json_decode($result, true);
	if (count($result) > 0 && count($result[0]) != 1) {
		foreach ($result as $key => $value) {
			if (count($value) != 1) {
				$responce[] = ['result' => "Запись удалена!"];
				$responce = json_encode($responce);

				$data = json_encode($result);
				file_put_contents('../../data/appointments.json', $data);

				print_r($responce);
				break;
			}
		}
	} elseif (count($result) == 1) { 
		$result = json_encode($result);
		print_r($result);
	} else { // Когда все записи будут удалены, тогда будет этот ответ. Он же удалит последнюю запись.
		$responce[] = ['result' => "Запись удалена, больше записей нет"];
		$responce = json_encode($responce);

		$data = json_encode($result);
		file_put_contents('../../data/appointments.json', $data);

		print_r($responce);
	}
}
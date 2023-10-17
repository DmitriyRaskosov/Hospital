<?php

header('Content-Type: application/json; charset=utf-8');

include_once '../models/appointment.php';
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

$data = file_get_contents('../../data/appointments.json');
$data = (array)json_decode($data, true);


// получить конкретную запись
if ($request['request_type'] == 'appointment') {
	print_r(appointment($request['id'], $data));
}

// получить все записи
if ($request['request_type'] == 'appointments') {
	print_r(appointments($data));
}

// создать новую запись
if ($request['request_type'] == 'create') {
	$created_appointment = create_appointment($request['name'], $request['date'], $request['doctor_type'], $data);
	print_r($created_appointment);

	$created_appointment = (array)json_decode($created_appointment, true);
	foreach ($created_appointment as $key => $value) {
		$data[] = $created_appointment[$key];
	}
	$data = json_encode($data);
	file_put_contents('../../data/appointments.json', $data);
}

// обновить дату существующей записи
if ($request['request_type'] == 'update') {
	$updated_data = update_appointment($request['id'], $request['date'], $data);
	$updated_data = (array)json_decode($updated_data, true);
	print_r(appointment($request['id'], $updated_data));
	
	$updated_data = json_encode($updated_data);
	file_put_contents('../../data/appointments.json', $updated_data);
}

// удалить запись
if ($request['request_type'] == 'delete') {
	$result = delete_appointment($request['id'], $data);
	$result = (array)json_decode($result, true);

	foreach ($result as $key => $value) {
		if (count($value) != 1) {
			$responce[] = ['result' => "Запись удалена!"];
			$responce = json_encode($responce);
			print_r($responce);

			$data = json_encode($result);
			file_put_contents('../../data/appointments.json', $data);
		} else {
			$result = json_encode($result);
			print_r($result);
		}
	}
}
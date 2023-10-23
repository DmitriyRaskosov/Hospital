<?php

header('Content-Type: application/json; charset=utf-8');

include_once '../models/doctor.php';
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

$data = file_get_contents('../../data/doctors.json');
$data = (array)json_decode($data, true);


// получить конкретного врача
if ($request['request_type'] == 'doctor') {
	$responce = doctor($request['id'], $data);
	print_r(add_translation($responce));
}

// получить список врачей
if ($request['request_type'] == 'doctors') {
	$responce = doctors($data);
	print_r(add_translation($responce));
}

// записать данные нового врача
if ($request['request_type'] == 'create') {
	$created_doctor = create($request['name'], $request['doctor_type'], $request['cost'], $data);
	print_r(add_translation($created_doctor));

	$created_doctor = (array)json_decode($created_doctor, true);
	foreach ($created_doctor as $key => $value) {
		$data[] = $created_doctor[$key];
	}
	$data = json_encode($data);
	file_put_contents('../../data/doctors.json', $data);
}

// обновить стоимость приёма конкретного врача
if ($request['request_type'] == 'update') {
	$updated_data = update($request['id'], $request['cost'], $data);
	$updated_data = (array)json_decode($updated_data, true);

	$updated_doctor = doctor($request['id'], $updated_data);
	print_r(add_translation($updated_doctor));
	
	$updated_data = json_encode($updated_data);
	file_put_contents('../../data/doctors.json', $updated_data);
}

// удалить данные врача
if ($request['request_type'] == 'delete') {
	$responce = [];
	$result = delete($request['id'], $data);
	$result = (array)json_decode($result, true);
	if (count($result) > 0 && count($result[0]) != 1) {
		foreach ($result as $key => $value) {
			if (count($value) != 1) {
				$responce[] = ['result' => "Данные врача удалены!"];
				$responce = json_encode($responce);

				$data = json_encode($result);
				file_put_contents('../../data/doctors.json', $data);

				print_r($responce);
				break;
			}
		}
	} elseif (count($result) == 1) { // При попытке удалить данные врача, которые уже были удалены, ответом пользователю будет "Доктор не найден!" из функции delete_doctor
		$result = json_encode($result);
		print_r($result);
	} else { // Когда данные всех врачей будут удалены, тогда будет этот ответ. Он же удалит данные последнего врача.
		$responce[] = ['result' => "Данные врача удалены, врачи закончились, остались Малахов и Малышева, брать будете?"];
		$responce = json_encode($responce);

		$data = json_encode($result);
		file_put_contents('../../data/doctors.json', $data);

		print_r($responce);
	}
}
<?php
header('Content-Type: application/json; charset=utf-8');

// validation
if (!isset($_GET['id']) || !(int)$_GET['id']) {
	throw new exception('ID не указан, не является числовым значением или равен нулю');
}

$received_id = $_GET['id'];

// downloading all data
$appointments = file_get_contents('../data/appointments.json');
$appointments = (array)json_decode($appointments, true);

// deleting the request date and responce to user
$flag_match = 0;
foreach ($appointments as $key => $value) {
	if ($received_id == $value['id']) {
		unset($appointments[$key]);
		$flag_match = 1;
		$responce_to_user = ['result' => "Запись удалена!"];
		$responce_to_user = json_encode($responce_to_user);
		print_r($responce_to_user);
		break;
	}
}
if ($flag_match == 0) {
	$responce_to_user = ['result' => "Запись не найдена!"];
	$responce_to_user = json_encode($responce_to_user);
	print_r($responce_to_user);
}

// uploading new data
$appointments = json_encode($appointments);
file_put_contents('../data/appointments.json', $appointments);
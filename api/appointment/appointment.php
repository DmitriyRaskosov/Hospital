<?php
header('Content-Type: application/json; charset=utf-8');

// validation
if (!isset($_GET['id']) || !(int)$_GET['id']) {
	throw new exception('ID не указан, не является числовым значением или равен нулю');
}

$received_id = $_GET['id'];

// downloading all data
$appointments = file_get_contents('../../data/appointments.json');
$appointments = (array)json_decode($appointments, true);

// searching and show result to user
$match = 0;
foreach ($appointments as $key => $value) {
	if ($received_id == $value['id']) {
		$match = 1;
		$responce_to_user = $value;
		$responce_to_user = json_encode($responce_to_user);
		print_r($responce_to_user);
		break;
	}
}
if ($match == 0) {
	$responce_to_user = ['result' => "Запись не найдена!"];
	$responce_to_user = json_encode($responce_to_user);
	print_r($responce_to_user);
}
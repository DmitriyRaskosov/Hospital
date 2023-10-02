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

// searching and show result to user
$flag_match = 0;
foreach ($appointments as $key => $value) {
	if ($received_id == $value['id']) {
		$flag_match = 1;
		print_r($value);
		break;
	}
}
if ($flag_match == 0) {
	echo "Запись не найдена!";
}
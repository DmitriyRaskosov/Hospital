<?php
header('Content-Type: application/json; charset=utf-8');

include '../translator.php';

// validation
if (!isset($_GET['id']) || !(int)$_GET['id']) {
	throw new exception('ID не указан, не является числовым значением или равен нулю');
}

$received_id = $_GET['id'];

// downloading all data
$doctors = file_get_contents('../../data/doctors.json');
$doctors = (array)json_decode($doctors, true);

// searching and show result to user
$match = 0;
foreach ($doctors as $key => $value) {
	if ($received_id == $value['id']) {
		$match = 1;
		$responce_to_user[] = $value;

		$responce_to_user = json_encode($responce_to_user);
		$responce_to_user = add_translation($responce_to_user);
		print_r($responce_to_user);
		break;
	}
}
if ($match == 0) {
	$responce_to_user[] = ['result' => "Доктор не найден!"];
	$responce_to_user = json_encode($responce_to_user);
	print_r($responce_to_user);
}
<?php
header('Content-Type: application/json; charset=utf-8');

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
		$responce_to_user = $value;

		$translations = file_get_contents('../../data/translations.json');
		$translations = (array)json_decode($translations, true);

		foreach ($translations as $tr_key => $tr_value) {
			if ($tr_value['en'] == $responce_to_user['doctor_type']) {
				$responce_to_user['doctor_type_ru'] = $tr_value['ru'];
				break;
			}
		}

		$responce_to_user = json_encode($responce_to_user);
		print_r($responce_to_user);
		break;
	}
}
if ($match == 0) {
	$responce_to_user = ['result' => "Доктор не найден!"];
	$responce_to_user = json_encode($responce_to_user);
	print_r($responce_to_user);
}
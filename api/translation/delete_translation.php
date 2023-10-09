<?php
header('Content-Type: application/json; charset=utf-8');

// validation
if (!isset($_GET['id']) || !(int)$_GET['id']) {
	throw new exception('ID не указан, не является числовым значением или равен нулю');
}

$received_id = $_GET['id'];

// downloading all data
$translations = file_get_contents('../../data/translations.json');
$translations = (array)json_decode($translations, true);

// deleting the requested translation and responce to user
$flag_match = 0;
foreach ($translations as $key => $value) {
	if ($received_id == $value['id']) {
		unset($translations[$key]);
		$flag_match = 1;
		$responce_to_user = ['result' => "Перевод удалён!"];
		$responce_to_user = json_encode($responce_to_user);
		print_r($responce_to_user);
		break;
	}
}
if ($flag_match == 0) {
	$responce_to_user = ['result' => "Перевод не найден!"];
	$responce_to_user = json_encode($responce_to_user);
	print_r($responce_to_user);
}

// uploading new data
$translations = json_encode($translations);
file_put_contents('../../data/translations.json', $translations);
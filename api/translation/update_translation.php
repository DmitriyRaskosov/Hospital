<?php
header('Content-Type: application/json; charset=utf-8');

// validation
if (!isset($_GET['id']) || !(int)$_GET['id']) {
	throw new exception('ID не указан, не является числовым значением или равен нулю');
}
if (!isset($_POST['ru']) || strlen($_POST['ru']) <= 0) {
	throw new exception('Слово на русском отсутствует');
}
if (!isset($_POST['en']) || strlen($_POST['en']) <= 0) {
	throw new exception('Слово на английском отсутствует');
}

$upd_id = $_GET['id'];
$upd_en_word = $_POST['en'];
$upd_ru_word = $_POST['ru'];

// downloading all data
$translations = file_get_contents('../../data/translations.json');
$translations = (array)json_decode($translations, true);

// updating data and show it to user
foreach ($translations as $key => $value) {
	if ($upd_id == $value['id']) {
		$translations[$key]['ru'] = $_POST['ru'];
		$translations[$key]['en'] = $_POST['en'];
		$responce_to_user[] = $translations[$key];
		$responce_to_user = json_encode($responce_to_user);
		print_r($responce_to_user);
		break;
	}
}

// uploading new data
$translations = json_encode($translations);
file_put_contents('../../data/translations.json', $translations);
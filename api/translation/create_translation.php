<?php
header('Content-Type: application/json; charset=utf-8');

// validation

if (!isset($_POST['ru']) || strlen($_POST['ru']) <= 0) {
	throw new exception('Слово на русском отсутствует');
}
if (!isset($_POST['en']) || strlen($_POST['en']) <= 0) {
	throw new exception('Слово на английском отсутствует');
}

// downloading all data
$translations = file_get_contents('../../data/translations.json');
$translations = (array)json_decode($translations, true);

// getting the last assigned ID
function getLastId($translations)
{
	$max_num = null;
	foreach ($translations as $key => $value) {
		if ($max_num < $value['id']) {
			$max_num = $value['id'];
		}
	}
	return $max_num;
}

// making new appointment and show it to user
$new_id = getLastId($translations) + 1;
$new_translation = [
	'id' => $new_id,
	'ru' => $_POST['ru'],
	'en' => $_POST['en']
];
$responce_to_user = $new_translation;
$responce_to_user = json_encode($responce_to_user);
print_r($responce_to_user);

// uploading new data
$translations[] = $new_translation;
$translations = json_encode($translations);
file_put_contents('../../data/translations.json', $translations);
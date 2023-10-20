<?php

header('Content-Type: application/json; charset=utf-8');

include_once '../models/translation.php';

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
$data = file_get_contents('../../data/translations.json');
$data = (array)json_decode($data, true);


// получить конкретный перевод
if ($request['request_type'] == 'translation') {
	$responce = translation($request['en'], $data);
	print_r($responce);
}

// получить список существующих переводов
if ($request['request_type'] == 'translations') {
	$responce = translations($data);
	print_r($responce);
}

// создать новую переведённую пару слов en -> ru
if ($request['request_type'] == 'create') {
	$created_translate = create($request['en'], $request['ru'], $data);
	print_r($created_translate);

	$created_translate = (array)json_decode($created_translate, true);
	foreach ($created_translate as $key => $value) {
		$data[] = $created_translate[$key];
	}
	$data = json_encode($data);
	file_put_contents('../../data/translations.json', $data);
}

// обновить существующий перевод английского слова - ищем по нужному английскому слову, изменить можно как английское значение перевода, так и русское
if ($request['request_type'] == 'update') {
	$updated_data = update($request['prev_en'], $request['new_en'], $request['ru'], $data);
	$updated_data = (array)json_decode($updated_data, true);

	$updated_translate = translation($request['new_en'], $updated_data);
	print_r($updated_translate);
	
	$updated_data = json_encode($updated_data);
	file_put_contents('../../data/translations.json', $updated_data);
}

// удалить перевод
if ($request['request_type'] == 'delete') {
	print_r (delete_request());
}

function delete_request() 
{
	global $request;
	global $data;
	$responce = [];
	$result = delete($request['en'], $data);
	$result = (array)json_decode($result, true);
	if (count($result) > 0 && count($result[0]) != 1) {
		foreach ($result as $key => $value) {
			if (count($value) != 1) {
				$responce[] = ['result' => "Перевод удалён!"];
				$responce = json_encode($responce);

				$data = json_encode($result);
				file_put_contents('../../data/translations.json', $data);

				return $responce;
			}
		}
	} elseif (count($result) == 1) {
		$result = json_encode($result);
		return $result;
	} else { 
		$responce[] = ['result' => "Перевод удалён, переводов больше нет"];
		$responce = json_encode($responce);

		$data = json_encode($result);
		file_put_contents('../../data/translations.json', $data);

		return $responce;
	}
}
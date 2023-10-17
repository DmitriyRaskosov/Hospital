<?php

header('Content-Type: application/json; charset=utf-8');

function translation($en)
{
	$translations = file_get_contents('../../data/translations.json');
	$translations = (array)json_decode($translations, true);

	$match = 0;
	foreach ($translations as $key => $value) {
		if ($en == $value['en']) {
			$match = 1;
			$responce[] = $value;
			$responce = json_encode($responce);
			return $responce;
		}
	}
	if ($match == 0) {
		$responce[] = ['result' => "Перевод не найден!"];
		$responce = json_encode($responce);
		return $responce;
	}
}


function translations()
{
	$translations = file_get_contents('../../data/translations.json');
	return $translations;
}


function create_translate($en, $ru)
{
	$translations = file_get_contents('../../data/translations.json');
	$translations = (array)json_decode($translations, true);

	$max_num = null;
	foreach ($translations as $key => $value) {
		if ($max_num < $value['id']) {
			$max_num = $value['id'];
		}
	}

	$new_id = $max_num + 1;
	$new_translation = [
		'id' => $new_id,
		'en' => $en,
		'ru' => $ru
	];

	$responce[] = $new_translation;

	$translations[] = $new_translation;
	$translations = json_encode($translations);
	file_put_contents('../../data/translations.json', $translations);

	$responce = json_encode($responce);
	return $responce;
}


function update_translation($en, $ru)
{
	$translations = file_get_contents('../../data/translations.json');
	$translations = (array)json_decode($translations, true);

	foreach ($translations as $key => $value) {
		if ($en == $value['en']) {
			$translations[$key]['en'] = $en;
			$translations[$key]['ru'] = $ru;
			$responce[] = $translations[$key];
			$responce = json_encode($responce);
			break;
		}
	}

	$translations = json_encode($translations);
	file_put_contents('../../data/translations.json', $translations);

	return $responce;
}


function delete_translation($en)
{
	$translations = file_get_contents('../../data/translations.json');
	$translations = (array)json_decode($translations, true);

	$flag_match = 0;

	foreach ($translations as $key => $value) {
		if ($en == $value['en']) {
			unset($translations[$key]);
			$flag_match = 1;
			$responce[] = ['result' => "Перевод удалён!"];
			$responce = json_encode($responce);

			$translations = json_encode($translations);
			file_put_contents('../../data/translations.json', $translations);

			return $responce;
		}
	}
	if ($flag_match == 0) {
		$responce[] = ['result' => "Перевод не найден!"];
		$responce = json_encode($responce);
		return $responce;
	}
}
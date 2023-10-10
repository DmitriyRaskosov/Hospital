<?php

function add_translation($input) 
{
	$translations = file_get_contents('../../data/translations.json');
	$translations = (array)json_decode($translations, true);

	$input = (array)json_decode($input, true);
	$output = [];
	
	foreach ($input as $input_key => $input_value) {
		foreach ($input_value as $one_key => $one_value) {

			$output[$input_key][$one_key] = $one_value;

			if ($one_key !== 'id') {
				foreach ($translations as $tr_arr_key => $tr_arr_value) { 
					foreach ($tr_arr_value as $tr_key => $tr_value) {
						if ($one_value == $tr_value) {
							$output[$input_key][$one_key.'_ru'] = $tr_arr_value['ru'];
						}
					}
 				}
			}
		}
	}

	$output = json_encode($output);
	return $output;
}
<?php

require_once 'AbstractModel.php';

class Translations extends AbstractModel {

	public $en;
	public $ru;
	public static $path = "../../data/translations.json";

	/*
		Метод принимает на вход слово на русском и отдаёт это же слово на английском если перевод слова содержится в translations.json
	*/
	public static function returnTranslation($ru)
	{
		$flag = 0;
		$data = parent::getAll();
		foreach ($data as $value) {
			if ($value['ru'] == $ru) {
                $result = $value['en'];
                $flag = 1;
                break;
			}
		}
        if ($flag == 0) {
            $result = 'Перевод этого слова отсутствует';
        }
		return $result;
	}
}
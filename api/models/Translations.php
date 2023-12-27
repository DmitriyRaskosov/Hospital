<?php

require_once 'AbstractModel.php';

class Translations extends AbstractModel {

	public $en;
	public $ru;
	public static $path = "../../data/translations.json";

	public function __construct($en, $ru) 
	{
        $this->id = parent::createId();
		$this->en = $en;
		$this->ru = $ru;
	}


	/*
		Метод принимает на вход слово на русском и отдаёт это же слово на английском если перевод слова содержится в translations.json
	*/
	public function returnTranslation($ru)
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
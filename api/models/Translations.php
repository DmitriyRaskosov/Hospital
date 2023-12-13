<?php

require_once 'AbstractModel.php';

class Translations extends AbstractModel {

	public $en;
	public $ru;
	public static $path = "../../data/translations.json";

	public function __construct($en, $ru) 
	{
		$this->en = $en;
		$this->ru = $ru;
		$this->id = parent::createId();
	}


	/*
		Метод принимает на вход слово на русском и отдаёт это же слово на английском если перевод слова содержится в translations.json
	*/
	public function returnTranslation($ru)
	{	
		$flag = null;
		$counter = 1;
		$getData = parent::getAll($counter);
		foreach ($getData as $key => $value) {
			if ($value['ru'] !== $ru) {
				$counter++;
			} else {
				$result = $value['en'];
				break;
			}	
		}
		return $result;
	}
}

$test = new Translations('Igorrr', 'Игорь');
print_r($test);

//print_r($test->returnTranslation('терапевт'));

//print_r($test->getOne(5));

//print_r($test->getAll());

//print_r($test->create($test));


$test->en = 'Igordasdasdsd';
$test->ru = 'Игорь';
$change_arr = [
	'en' => $test->en, 
	'ru' => $test->ru
];

print_r($test->update(3, $change_arr));


//print_r($test->delete($test, 6));
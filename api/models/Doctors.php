<?php

require_once 'AbstractModel.php';

class Doctors extends AbstractModel {

	public $name;
	public $doctor_type;
	public $cost;
	public static $path = "../../data/doctors.json";

	public function __construct($name, $doctor_type, $cost)	
	{
        $this->id = parent::createId();
		$this->name = $name;
		$this->doctor_type = $doctor_type;
		$this->cost = $cost;
	}
}

$test = new Doctors('Igorrr', 'therapist', '5000');
print_r($test);

print_r($test->getOne(4));

//print_r($test->getAll());

//print_r($test->create($test));

/*
$test->date = 102;
print_r($test->update($test));
*/

//print_r($test->delete($test, 6));
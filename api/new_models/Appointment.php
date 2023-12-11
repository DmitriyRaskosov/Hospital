<?php

require_once 'AbstractModel.php';

class Appointments extends AbstractModel {
	
	public $name;
	public $date;
	public $doctor_type;
	public static $path = "../../data/appointments.json";

	public function __construct($name,  $date, $doctor_type)	{
		$this->name = $name;
		$this->date = $date;
		$this->doctor_type = $doctor_type;
		$this->id = parent::createId(self::$path);	
	}
}

	

$test = new Appointments('Igor', '10-12-2021', 'therapist');
print_r($test);

//print_r($test->getOne(2));

print_r($test->getAll());

//print_r($test->create($test));

/*
$test->date = 102;
print_r($test->update($test));
*/

//print_r($test->delete($test, 6));
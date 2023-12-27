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
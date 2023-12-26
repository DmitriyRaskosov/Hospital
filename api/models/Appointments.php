<?php

require_once 'AbstractModel.php';

class Appointments extends AbstractModel {
	
	public $name;
	public $date;
	public $doctor_type;
	public static $path = "../../data/appointments.json";

	public function __construct($name,  $date, $doctor_type) 
	{
        $this->id = parent::createId();
		$this->name = $name;
		$this->date = $date;
		$this->doctor_type = $doctor_type;
	}
}
<?php

require_once 'AbstractModel.php';

class Appointments extends AbstractModel {
	
	public $name;
	public $date;
	public $doctor_type;
	public static $path = "../../data/appointments.json";

}
<?php

require_once 'AbstractModel.php';

class Doctors extends AbstractModel {

	public $name;
	public $doctor_type;
	public $cost;
	public static $path = __DIR__."/../../data/doctors.json";

}
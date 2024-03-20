<?php

require_once 'AbstractModel.php';

class Appointments extends AbstractModel {
	
	// app_date - timestamp
	public static $attributes = [
		'patient_id' => null, 
		'doctor_id' => null,
		'app_date' => null
	];

	public static $table_name = 'Appointments';

}
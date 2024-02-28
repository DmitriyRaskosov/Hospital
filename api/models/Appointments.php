<?php

require_once 'AbstractModel.php';

class Appointments extends AbstractModel {
	
	public static $attributes = [
		'first_name' => null, 
		'last_name' => null
	];

	public static $table_name = 'Patients';

}
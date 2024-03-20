<?php

require_once 'AbstractModel.php';

class Patients extends AbstractModel {
	
	public static $attributes = [
		'first_name' => null, 
		'last_name' => null
	];

	public static $table_name = 'Patients';

}
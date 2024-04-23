<?php

require_once 'AbstractModel.php';

class Doctors extends AbstractModel {

	public static $attributes = [
		'first_name' => null,
		'last_name' => null,
		'specialization' => null,
		'cost' => null,
		'work_begin' => null,
		'work_end' => null,
		'id' => null
	];

	public static $table_name = 'Doctors';

}
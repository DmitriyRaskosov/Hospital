<?php
header('Content-Type: application/json; charset=utf-8');

$appointments = file_get_contents('../data/appointments.json');
$appointments = (array)json_decode($appointments, true);

foreach ($appointments as $key => $value) {
	if ($_GET['id'] == $value['id']) {
		print_r($value);
		break;
	}
}
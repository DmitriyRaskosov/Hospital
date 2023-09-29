<?php

$del_id = $_GET['id'];

$appointments = file_get_contents('../data/appointments.json');
$appointments = (array)json_decode($appointments, true);

foreach ($appointments as $key => $value) {
	if ($del_id == $value['id']) {
		unset($appointments[$key]);
		break;
	}
}

$appointments = json_encode($appointments);
file_put_contents('../data/appointments.json', $appointments);
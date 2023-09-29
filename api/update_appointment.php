<?php

$upd_id = $_GET['id'];
$upd_date = $_GET['date'];

$appointments = file_get_contents('../data/appointments.json');
$appointments = (array)json_decode($appointments, true);

foreach ($appointments as $key => $value) {
	if ($upd_id == $value['id']) {
		$appointments[$key]['appointment_date'] = $_GET['date'];
		break;
	}
}

$appointments = json_encode($appointments);
file_put_contents('../data/appointments.json', $appointments);
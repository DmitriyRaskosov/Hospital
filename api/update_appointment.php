<?php
header('Content-Type: application/json; charset=utf-8');

// validation
if (!isset($_GET['id']) || !(int)$_GET['id']) {
	throw new exception('ID не указан, не является числовым значением или равен нулю');
}
if (!isset($_POST['appointment_date'])) {
	throw new exception('хуй, а не дата');
}

$upd_id = $_GET['id'];
$upd_date = $_POST['appointment_date'];

// downloading all data
$appointments = file_get_contents('../data/appointments.json');
$appointments = (array)json_decode($appointments, true);

// updating data and show it to user
foreach ($appointments as $key => $value) {
	if ($upd_id == $value['id']) {
		$appointments[$key]['appointment_date'] = $_POST['appointment_date'];
		$update_appointment = $appointments[$key]['appointment_date'];
		print_r($value);
		break;
	}
}

// uploading new data
$appointments = json_encode($appointments);
file_put_contents('../data/appointments.json', $appointments);
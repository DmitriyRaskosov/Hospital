<?php
header('Content-Type: application/json; charset=utf-8');

if (!isset($_POST['name'])) {
	throw new exception('хуй, а не имя');
}
if (!isset($_POST['date'])) {
	throw new exception('хуй, а не дата');
}
if (!isset($_POST['doctor_type'])) {
	throw new exception('хуй, а не доктор');
}


$appointments = file_get_contents('../data/appointments.json');
$appointments = (array)json_decode($appointments, true);

function getLastId($appointments)
{
	$max_num = null;
	foreach ($appointments as $key => $value) {
		if ($max_num < $value['id']) {
			$max_num = $value['id'];
		}
	}
	return $max_num;
}

$new_id = getLastId($appointments) + 1;
$new_appointment = [
	'id' => $new_id,
	'patient_name' => $_POST['name'],
	'appointment_date' => $_POST['date'],
	'doctor_type' => $_POST['doctor_type']
];

$appointments[] = $new_appointment;


$appointments = json_encode($appointments);
file_put_contents('../data/appointments.json', $appointments);
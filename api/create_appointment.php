<?php
header('Content-Type: application/json; charset=utf-8');

// validation
// doesn't validating any spec. char. and data type for now
if (!isset($_POST['patient_name']) || strlen($_POST['patient_name']) <= 0) {
	throw new exception('Имя не указано');
}
if (!isset($_POST['appointment_date']) || strlen($_POST['appointment_date']) <= 0) {
	throw new exception('Дата записи не указана');
}
if (!isset($_POST['doctor_type']) || strlen($_POST['doctor_type']) <= 0) {
	throw new exception('Врач не указан');
}

// downloading all data
$appointments = file_get_contents('../data/appointments.json');
$appointments = (array)json_decode($appointments, true);

// getting the last assigned ID
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

// making new appointment and show it to user
$new_id = getLastId($appointments) + 1;
$new_appointment = [
	'id' => $new_id,
	'patient_name' => $_POST['patient_name'],
	'appointment_date' => $_POST['appointment_date'],
	'doctor_type' => $_POST['doctor_type']
];
print_r($new_appointment);

// uploading new data
$appointments[] = $new_appointment;
$appointments = json_encode($appointments);
file_put_contents('../data/appointments.json', $appointments);
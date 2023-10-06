<?php
header('Content-Type: application/json; charset=utf-8');

// validation
// doesn't validating any spec. char. and data type for now
if (!isset($_POST['name']) || strlen($_POST['name']) <= 0) {
	throw new exception('Имя не указано');
}
if (!isset($_POST['date']) || strlen($_POST['date']) <= 0) {
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
	'name' => $_POST['name'],
	'date' => $_POST['date'],
	'doctor_type' => $_POST['doctor_type']
];
$responce_to_user = $new_appointment;
$responce_to_user = json_encode($responce_to_user);
print_r($responce_to_user);

// uploading new data
$appointments[] = $new_appointment;
$appointments = json_encode($appointments);
file_put_contents('../data/appointments.json', $appointments);
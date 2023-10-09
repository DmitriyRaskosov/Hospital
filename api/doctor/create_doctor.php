<?php
header('Content-Type: application/json; charset=utf-8');

// validation
if (!isset($_POST['name']) || strlen($_POST['name']) <= 0) {
	throw new exception('Имя не указано');
}
if (!isset($_POST['cost']) || strlen($_POST['cost']) <= 0) {
	throw new exception('Стоимость услуг не указана');
}

$doctor_types = ['therapist', 'endocrinologist', 'cardiologist', 'pediatrician', 'surgeon', 'psychiatrist', 'dermatologist'];

if (!isset($_POST['doctor_type']) || strlen($_POST['doctor_type']) <= 0) {
	throw new exception('Специальность врача не указана');
} else {
	if (!in_array($_POST['doctor_type'], $doctor_types)) {
		throw new exception('В названии специальности допущена ошибка');
	}
}

// downloading all data
$doctors = file_get_contents('../../data/doctors.json');
$doctors = (array)json_decode($doctors, true);

// getting the last assigned ID
function getLastId($doctors)
{
	$max_num = null;
	foreach ($doctors as $key => $value) {
		if ($max_num < $value['id']) {
			$max_num = $value['id'];
		}
	}
	return $max_num;
}

// making new doctor's card and show it
$new_id = getLastId($doctors) + 1;
$new_doctor = [
	'id' => $new_id,
	'name' => $_POST['name'],
	'doctor_type' => $_POST['doctor_type'],
	'cost' => $_POST['cost']
];
$responce_to_user = $new_doctor;
$responce_to_user = json_encode($responce_to_user);
print_r($responce_to_user);

// uploading new data
$doctors[] = $new_doctor;
$doctors = json_encode($doctors);
file_put_contents('../../data/doctors.json', $doctors);
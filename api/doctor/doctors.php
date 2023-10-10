<?php
header('Content-Type: application/json; charset=utf-8');

include '../translator.php';

$data = file_get_contents('../../data/doctors.json');
$data = add_translation($data);

echo $data;
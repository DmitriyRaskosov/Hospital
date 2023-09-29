<?php

$upd_id = $_GET['id'];

$appointments = file_get_contents('../data/appointments.json');
$appointments = (array)json_decode($appointments, true);


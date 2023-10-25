<?php

header('Content-Type: application/json; charset=utf-8');

include_once 'translator.php';

preg_match(("#api/(appointments|doctors|translations).?([0-9]+)?#"), $_SERVER['REQUEST_URI'], $model_match);

$request = $_REQUEST;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	if (isset($model_match[1])) {
		if ($model_match[1] == 'appointments') {
			include_once 'models/appointment.php';

			if (isset($model_match[2])) {
				$request['request_type'] = 'appointment';
				$request['id'] = $model_match[2];
			}
			else {
				$request['request_type'] = 'appointments';
			}
		}
		include_once 'controllers/appointments_ctrl.php';
	} else {
		throw new exception ('искомый параметр не задан, либо задан с ошибкой');
	}
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($model_match[1])) {
		if ($model_match[1] == 'appointments') {
			include_once 'models/appointment.php';

			$request['request_type'] = 'create';
		}
		include_once 'controllers/appointments_ctrl.php';
	} else {
		throw new exception ('искомый параметр не задан, либо задан с ошибкой');
	}
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
	$request = (array)json_decode(file_get_contents("php://input"));
	if (isset($model_match[1]) && isset($model_match[2])) {
		if ($model_match[1] == 'appointments') {
			include_once 'models/appointment.php';

			$request['request_type'] = 'update';
			$request['id'] = $model_match[2];
		}
		include_once 'controllers/appointments_ctrl.php';
	} else {
		throw new exception ('искомый параметр не задан, либо задан с ошибкой');
	}
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
	if (isset($model_match[1])) {
		if ($model_match[1] == 'appointments') {
			include_once 'models/appointment.php';

			$request['request_type'] = 'delete';
			$request['id'] = $model_match[2];
		}
		include_once 'controllers/appointments_ctrl.php';
	} else {
		throw new exception ('искомый параметр не задан, либо задан с ошибкой');
	}
}
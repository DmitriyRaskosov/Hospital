<?php

include_once ('classes/controller_app.php');

$uri_in_array = explode('/', $_SERVER['REQUEST_URI']);

$request = [];
$request['method'] = $_SERVER['REQUEST_METHOD'];
$request['ctrl_request'] = $uri_in_array[3];
if (isset($uri_in_array[4]) && $uri_in_array[4] != null) {
	$request['id'] = $uri_in_array[4];
}

print_r($request);

if ($request['ctrl_request'] == 'appointments') {
	$result = ControllerAppoinment::getData($request);
	print_r($result);
}
<?php

include_once ('classes/controller_app.php');

$uri_in_array = explode('/', $_SERVER['REQUEST_URI']);

// запрос пользователя в виде массива, из которого можно будет понять, что именно пользователь хочет сделать
$request = [];
$request['method'] = $_SERVER['REQUEST_METHOD'];
$request['ctrl_request'] = $uri_in_array[3];
if (isset($uri_in_array[4]) && $uri_in_array[4] != null) {
	$request['id'] = $uri_in_array[4];
}
print_r($request);

// данные, передаваемые пользователем; кода будет больше, но пока вот так - парсинг будет здесь
$input_data = $_REQUEST;
print_r($input_data);



if ($request['ctrl_request'] == 'appointments') {
	$result = ControllerAppoinment::getData($request);
	print_r($result);
}
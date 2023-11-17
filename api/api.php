<?php

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
	include_once ('classes/controller_app.php');
}
if ($request['ctrl_request'] == 'doctors') {
	include_once ('classes/controller_doc.php');
}
if ($request['ctrl_request'] == 'translations') {
	include_once ('classes/controller_tr.php');
}


if ($request['method'] == 'GET') {
	if (!isset($request['id'])) {
		echo 'вызов метода getData и метода getAll';
	} elseif (isset($request['id'])) {
		echo 'вызов метода getData и метода getOne';
	}
}
if ($request['method'] == 'POST') {
	echo 'вызов метода createData';
}
if ($request['method'] == 'PUT') {
	echo 'вызов метода updateData';
}
if ($request['method'] == 'DELETE') {
	echo 'вызов метода deleteData';
}
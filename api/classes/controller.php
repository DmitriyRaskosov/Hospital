<?php

abstract class Controller
{
	// $data = (array)json_decode(file_get_contents('../../data/'), true);
	public static function getData ($request) {
		if ($request['method'] == 'GET') {
			if (!isset($request['id'])) {
				echo 'вызов метода getAll';
			} elseif (isset($request['id'])) {
				echo 'вызов метода getOne';
			}
		}
	}

	public function createData () {
		if ($request['method'] == 'POST') {
			echo 'вызов метода create';
		}
	}
	public function updateData () {
		if ($request['method'] == 'PUT') {
			echo 'вызов метода update';
		}
	}
	public function deleteData () {
		if ($request['method'] == 'DELETE') {
			echo 'вызов метода delete';
		}
	}
}
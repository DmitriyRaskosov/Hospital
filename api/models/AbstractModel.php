<?php

require_once __DIR__.'/../../Database.php';

abstract class AbstractModel {

	public $id = null;

	public static $path;

	public static function getOne($id)
	{
	    $db_data = new Database();
	    $data = $db_data->query('SELECT * FROM Patients WHERE id='.$id);
	    return $data;
	}
	
	public static function getAll()
	{
		$db_data = new Database();
		$data = $db_data->query('SELECT * FROM Patients');
		return $data;
	}

	public static function create($post)
	{
		$db_data = new Database();
		$data = $db_data->query('INSERT INTO Patients (first_name, last_name) VALUES'." ("."'".$post['first_name']."'".","."'".$post['last_name']."'".")");
        return $data;
	}

	public static function update($changed_data)
	{
		$db_data = new Database();
        $data = $db_data->query('UPDATE Patients SET last_name = '."'".$changed_data['new_last_name']."'"." ".'WHERE '.'last_name = '."'".$changed_data['last_name']."'");
    	return $data;
    }

	public static function delete($patient)
	{
		$db_data = new Database();
		$id = $db_data->query('SELECT id FROM Patients WHERE last_name = '."'".$patient['last_name']."'");
		$id = $id[0]['id'];
		$result = $db_data->query('DELETE FROM Appointments WHERE patient_id = '.$id[0]);
		$result = $db_data->query('DELETE FROM Patients WHERE id = '.$id[0]);
		return $result;
	}
}
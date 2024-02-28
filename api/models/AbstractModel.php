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

	public static function update($id, $changed_data)
	{
		$db_data = new Database();
        $data = $db_data->query('UPDATE Patients SET '.array_key_first($changed_data)." = "."'".current($changed_data)."'"." ".'WHERE id = '.$id);
    	return $data;
    }

	public static function delete($id)
	{
		$db_data = new Database();

		$result = $db_data->query('DELETE FROM Appointments WHERE patient_id = '.$id);
		$result = $db_data->query('DELETE FROM Patients WHERE id = '.$id);

		return $result;
	}
}
<?php

require_once 'AbstractModel.php';

class Appointments extends AbstractModel {
	
	public $name;
	public $date;
	public $doctor_type;
	public $path = "../../data/appointments.json";

	public function __construct($name, $date, $doctor_type)
	{
		$this->name = $name;
		$this->date = $date;
		$this->doctor_type = $doctor_type;
		$this->id = parent::createId($this->path);	
	}


	public function getOne($id, $path = null)
	{
		return parent::getOne($id, $this->path);
	}

	public function getAll($path = null)
	{
		return parent::getAll($this->path);
	}

	public function create($object, $path = null)
	{
	    return parent::create($object, $this->path);
	}

	public function update($object, $id = null, $date = null, $path = null)
	{
		$new_date = parent::update($this->id, $this->date, $this->path);
	    return 'данные обновлены, новая дата записи: '.$new_date;
	}

	public function delete($object, $id, $path = null)
	{
		return parent::delete($id, $this->path);
	}
}

	

$test = new Appointments('Igor', '10-12-2021', 'therapist');
//print_r($test);

//print_r($test->getOne(2));

//print_r($test->getAll());

//print_r($test->create($test));

/*
$test->date = 102;
print_r($test->update($test));
*/

print_r($test->delete($test, 6));
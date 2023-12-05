<?php

require_once 'AbstractModel.php';

class Appointments extends AbstractModel {
	
	public $name;
	public $date;
	public $doctor_type;

	public function __construct($name, $date, $doctor_type)
	{
		$this->name = $name;
		$this->date = $date;
		$this->doctor_type = $doctor_type;
		$this->id = parent::createId((array)json_decode(file_get_contents('../../data/appointments.json'), true));
	}


	public static function getOne($id, $data = null)
	{
		$data = (array)json_decode(file_get_contents('../../data/appointments.json'), true);
		return parent::getOne($id, $data);
	}

	public function getAll()
	{
		$data = (array)json_decode(file_get_contents('../../data/appointments.json'), true);
		return $data;
	}

	public function create($object)
	{
	    $data = (array)json_decode(file_get_contents('../../data/appointments.json'), true);
	    $new_appointment[] = (array) $object;
	    $new_data = array_merge($data, $new_appointment);

	    $data = json_encode($new_data);
	    $data = file_put_contents('../../data/appointments.json', $data);
	    return $new_appointment;
	}

	public function update($object, $id = null, $date = null, $data = null)
	{
		$data = (array)json_decode(file_get_contents('../../data/appointments.json'), true);
		$new_data = parent::update($this->id, $this->date, $data);

		$new_data = json_encode($new_data);
	    $new_data = file_put_contents('../../data/appointments.json', $new_data);
	    return 'данные обновлены, новая дата записи: '.$this->date;
	}

	public function delete($object, $id = null, $data = null)
	{
		$data = (array)json_decode(file_get_contents('../../data/appointments.json'), true);
		$result = parent::delete($id, $data);

		$result = json_encode($result);
	    $result = file_put_contents('../../data/appointments.json', $result);
	}
}

	

$test = new Appointments('Igor', '10-12-2021', 'therapist');

//print_r($test->getOne(2));

print_r($test->getAll());

//print_r($test->create($test));

/*
$test->date = 102;
print_r($test->date)."<br>";
print_r($test->update($test));
*/

print_r($test->delete($test, 3));
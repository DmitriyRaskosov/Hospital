<?php
require_once __DIR__.'/../controllers/AbstractController.php';
require_once __DIR__.'/../models/Appointments.php';

class AppointmentsController extends AbstractController {

    public static $model_name = 'Appointments';

    public function validation ()
    {
        foreach ($array as $key => $value) {
            if ($key == 'doctor_id') {
                $data = Database::getConnect()->query('SELECT * FROM '.'Doctors'.' WHERE id='.$value);
            }
            if ($key == 'app_date') {
                if (!is_int($value)) {
                    throw new Exception ($key." неправильно указано");
                }
                $data = Database::getConnect()->query('SELECT * FROM '.static::$table_name.' WHERE doctor_id='.$value);
            }
            if ($data == false) {
                throw new Exception ($key." не существует");
            }
        }


        return true;
    }

}
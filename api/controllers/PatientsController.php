<?php
require_once __DIR__.'/../controllers/AbstractController.php';
require_once __DIR__.'/../models/Patients.php';

class PatientsController extends AbstractController {

    public static $model_name = 'Patients';

    public static function validate($valid_data)
    {
        foreach ($valid_data as $key => $value) {
            if (strlen($value) < 1) {
                throw new exception ("имя / фамилия не могут быть пустыми");
            }
            if (ctype_alpha($value) == false) {
                throw new exception ("имя / фамилия не должны содержать цифры");
            }
        }
        return true;
    }

    public function create($post)
    {
        self::validate($post);
        return parent::create($post);
    }
}
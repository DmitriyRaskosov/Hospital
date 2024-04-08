<?php
require_once __DIR__.'/../controllers/AbstractController.php';
require_once __DIR__.'/../models/Patients.php';

class PatientsController extends AbstractController {

    public static $model_name = 'Patients';

    public function create($post)
    {
        parent::strValidate($post['first_name']);

        parent::strValidate($post['last_name']);

        //parent::duplicateValidate($post, self::$model_name);
        
        return parent::create($post);
    }

    public function update($id, $changed_data)
    {
        foreach ($changed_data as $key => $value) {
            if ($key == 'first_name' || $key == 'last_name') {
                parent::strValidate($value);
            }
        }
        return parent::update($id, $changed_data);
    }
}
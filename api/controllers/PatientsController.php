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

    public function update($id)
    {
        return parent::update($id);
    }
}
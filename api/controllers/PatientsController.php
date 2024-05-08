<?php
require_once __DIR__.'/../controllers/AbstractController.php';
require_once __DIR__.'/../models/Patients.php';

class PatientsController extends AbstractController {

    public static $model_name = 'Patients';

    public function create($post)
    {
        // убираем один уровень вложенности и валидируем данные
        foreach ($post as $filters_num => $filters_value) {
            parent::strValidate($filters_value['first_name']);
            parent::strValidate($filters_value['last_name']);
        }

        //parent::duplicateValidate($post, self::$model_name);
        
        return parent::create($post);
    }

    public function update($put, $id)
    {
        return parent::update($put, $id);
    }
}
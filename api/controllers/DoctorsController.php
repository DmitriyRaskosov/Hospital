<?php
require_once __DIR__.'/../controllers/AbstractController.php';
require_once __DIR__.'/../models/Doctors.php';

class DoctorsController extends AbstractController {

    public static $model_name = 'Doctors';
    protected static $specializations_list = ['therapist', 'surgeon', 'psychiatrist', 'dentist', 'endocrinologist'];

    protected static function specializationValidate($specialization)
    {
        parent::strValidate($specialization);
        if (!in_array($specialization, self::$specializations_list)) {
            throw new exception ("Такая специальность отсутствует в списке доступных специальностей");
        }
        return true;
    }

    protected static function costValidate($cost) 
    {
        parent::intValidate($cost);
        if ($cost < 500 || $cost > 10000) {
            throw new exception ("Введена некорректная стоимость услуг");
        }
        return true;
    }

    public function create($post)
    {
        // убираем один уровень вложенности и валидируем данные
        foreach ($post as $filters_num => $filters_value) {
            parent::strValidate($filters_value['first_name']);
            parent::strValidate($filters_value['last_name']);
            self::specializationValidate($filters_value['specialization']);
            self::costValidate($filters_value['cost']);
            //parent::intValidate($filters_value['work_begin']);
            //parent::intValidate($filters_value['work_end']);
        }

        /*
        $duplicate_check['first_name'] = $post['first_name'];
        $duplicate_check['last_name'] = $post['last_name'];
        $duplicate_check['specialization'] = $post['specialization'];
        parent::duplicateValidate($duplicate_check, self::$model_name);
        */

        return parent::create($post);
        
    }

    public function update($put, $id)
    {
        /*
        foreach ($put as $key => $value) {
            if ($key == 'first_name' || $key == 'last_name') {
                parent::strValidate($value);
            } elseif ($key == 'specialization') {
                self::specializationValidate($value);
            } elseif ($key == 'cost') {
                self::costValidate($value);
            } elseif ($key == 'work_begin' || $key == 'work_end') {
                parent::intValidate($value);
            }
        }
        */
        return parent::update($put, $id);
        
    }
}
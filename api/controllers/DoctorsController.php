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
        parent::strValidate($post['first_name']);

        parent::strValidate($post['last_name']);

        $duplicate_check['first_name'] = $post['first_name'];
        $duplicate_check['last_name'] = $post['last_name'];
        $duplicate_check['specialization'] = $post['specialization'];
        parent::duplicateValidate($duplicate_check, self::$model_name);

        self::specializationValidate($post['specialization']);

        self::costValidate($post['cost']);

        parent::intValidate($post['work_begin']);

        parent::intValidate($post['work_end']);

        return parent::create($post);
    }

    public function update($id, $changed_data)
    {
        foreach ($changed_data as $key => $value) {
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
        return parent::update($id, $changed_data);
    }
}
<?php
require_once __DIR__.'/../controllers/AbstractController.php';
require_once __DIR__.'/../models/Doctors.php';

class DoctorsController extends AbstractController {

    public static $model_name = 'Doctors';
    protected static $specializations_list = ['therapist', 'surgeon', 'psychiatrist', 'dentist', 'endocrinologist'];

    public function create($post)
    {
        $duplicate_check['first_name'] = $post['first_name'];
        $duplicate_check['last_name'] = $post['last_name'];
        parent::duplicateValidate($duplicate_check, self::$model_name);
        
        $post = array_chunk($post, 1);

        // first_name
        parent::strValidate($post[0]);

        // last_name
        parent::strValidate($post[1]);

        // specialization
        parent::strValidate($post[2]);
        foreach (self::$specializations_list as $key => $value) {
            $exist_check = 0;
            if ($value == $post[2][0]) {
                $exist_check = 1;
                break;
            }
        }
        if ($exist_check == 0) {
            throw new exception ("Такая специальность отсутствует в списке доступных специальностей");
        }

        // cost
        parent::intValidate($post[3][0]);
        if ($post[3][0] < 500 || $post[3][0] > 10000) {
            throw new exception ("Введена некорректная стоимость услуг");
        }

        // work_begin 
        parent::intValidate($post[4][0]);

        //work_end
        parent::intValidate($post[5][0]);

        return parent::create($post);
    }

    public function update($id, $changed_data)
    {
        self::validate($changed_data);
        return parent::update($id, $changed_data);
    }
}
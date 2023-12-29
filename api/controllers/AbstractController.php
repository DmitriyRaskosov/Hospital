<?php

require_once __DIR__.'/../models/AbstractModel.php';

abstract class AbstractController {

    public static $model_name = 'AbstractModel';

    public function getOne($id)
    {
        $model_name = self::$model_name;
        return $model_name::getOne();
    }

    public function getAll()
    {
        $model_name = self::$model_name;
        return $model_name::getAll();
    }

    public function create($id)
    {

        return $model_name::create($id);
    }

    public function update($id)
    {

        return $model_name::update($id);
    }

    public function delete($id)
    {

        return $model_name::delete($id);
    }
}
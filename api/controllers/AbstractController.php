<?php

require_once __DIR__.'/../models/AbstractModel.php';

abstract class AbstractController {

    public static $model_name = 'AbstractModel';

    public function getOne($id)
    {
        $model_name = static::$model_name;
        return $model_name::getOne();
    }

    public function getAll()
    {
        $model_name = static::$model_name;
        return $model_name::getAll();
    }

    public function create($post)
    {
        $model_name = static::$model_name;
        return $model_name::create($post);
    }

    public function update($id)
    {
        $model_name = static::$model_name;
        return $model_name::update($id, $_POST);
    }

    public function delete($id)
    {
        $model_name = static::$model_name;
        return $model_name::delete($id);
    }
}
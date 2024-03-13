<?php

require_once __DIR__.'/../models/AbstractModel.php';

abstract class AbstractController {

    public static $model_name = 'AbstractModel';

    public function getOne($id)
    {
        $model_name = static::$model_name;
        return $model_name::getOne($id);
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

    public function update($id, $changed_data)
    {
        $model_name = static::$model_name;
        return $model_name::update($id, $changed_data);
    }

    public function delete($id)
    {
        $model_name = static::$model_name;
        return $model_name::delete($id);
    }
}
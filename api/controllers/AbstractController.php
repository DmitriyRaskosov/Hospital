<?php

require_once __DIR__.'/../models/AbstractModel.php';

abstract class AbstractController {

    public static $model_name = 'AbstractModel';

    public function getOne($id, $db_data)
    {
        $model_name = static::$model_name;
        return $model_name::getOne($id, $db_data);
    }

    public function getAll($db_data)
    {
        $model_name = static::$model_name;
        return $model_name::getAll($db_data);
    }

    public function create($post, $db_data)
    {
        $model_name = static::$model_name;
        return $model_name::create($post, $db_data);
    }

    public function update($id, $changed_data, $db_data)
    {
        $model_name = static::$model_name;
        return $model_name::update($id, $changed_data, $db_data);
    }

    public function delete($id, $db_data)
    {
        $model_name = static::$model_name;
        return $model_name::delete($id, $db_data);
    }
}
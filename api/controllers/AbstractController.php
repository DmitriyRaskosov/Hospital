<?php
require_once __DIR__.'/../models/AbstractModel.php';
require_once __DIR__.'/../../Database.php';
require_once __DIR__.'/../../ValidationTrait.php';

abstract class AbstractController {
    use Validation;

    public static $model_name = 'AbstractModel';

    public function getOne($id)
    {
        $model_name = static::$model_name;
        return $model_name::getOne($id);
    }

    public function getAll($get)
    {
        $model_name = static::$model_name;
        return $model_name::getAll($get);
    }

    public function create($post)
    {
        $model_name = static::$model_name;
        return $model_name::create($post);
    }

    public function update($id)
    {
        $model_name = static::$model_name;
        return $model_name::update($id);
    }

    public function delete($id)
    {
        $model_name = static::$model_name;
        return $model_name::delete($id);
    }
}
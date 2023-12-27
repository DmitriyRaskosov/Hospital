<?php

require_once __DIR__.'/../models/AbstractModel.php';

abstract class AbstractController {

    public static $model_name = 'AbstractModel';

    public function getOne($id)
    {
        $model = new self::$model_name();
        return $model->getOne($id);
    }

    public function getAll()
    {
        $model = new self::$model_name();
        return $model->getAll();
    }

    public function create($id)
    {
        $model = new self::$model_name();
        return $model->create($id);
    }

    public function update($id)
    {
        $model = new self::$model_name();
        return $model->update($id);
    }

    public function delete($id)
    {
        $model = new self::$model_name();
        return $model->delete($id);
    }
}
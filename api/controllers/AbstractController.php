<?php

abstract class AbstractController {

    public function getOne ($id, $model_name)
    {
        $model = new $model_name;
        return $model->getOne($id);
    }

    public function getAll ($model_name)
    {
        $model = new $model_name;
        return $model->getAll($id);
    }

    public function create ($model_name)
    {
        $model = new $model_name;
        return $model->create($id);
    }

    public function update ($id, $model_name)
    {
        $model = new $model_name;
        return $model->update($id);
    }

    public function delete ($id, $model_name)
    {
        $model = new $model_name;
        return $model->delete($id);
    }
}
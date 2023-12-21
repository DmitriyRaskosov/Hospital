<?php

class Api {

    public $request = [];
    public $req_controller;
    public $req_model_method;
    // запрос пользователя в виде массива, из которого можно будет понять, что именно пользователь хочет сделать
    public function requestCreator()
    {
        $this->request['method'] = $_SERVER['REQUEST_METHOD'];
        $uri_in_array = explode('/', $_SERVER['REQUEST_URI']);
        $this->request['ctrl_request'] = $uri_in_array[3];
        $this->req_controller = $uri_in_array[3];
        if (isset($uri_in_array[4]) && $uri_in_array[4] != null) {
            $request['id'] = $uri_in_array[4];
        }
        return $this->request;
    }

    // здесь вызываем контроллер и передаём ему вызов метода из модели, при необходимости передаём id и др. данные
    public function requiredOutput($controller, $method, $id = null)
    {
        require_once 'controllers/'.$controller.'.php';

        if ($method == 'GET') {
            // команда контроллеру на вызов метода getAll, если $id = null
            
            if ($id != null) {
                // команда контроллеру на вызов метода getOne
            }
        }
        if ($method == 'POST') {
            // команда контроллеру на вызов метода create
        }
        if ($method == 'PUT') {
            // команда контроллеру на вызов метода update
        }
        if ($method == 'DELETE') {
            // команда контроллеру на вызов метода delete
        }
    }
}

$test = new Api;

print_r($test->requestCreator());

print_r($test->request);
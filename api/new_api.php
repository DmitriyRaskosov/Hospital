<?php
require_once 'controllers/AppointmentsController.php';
require_once 'controllers/DoctorsController.php';
require_once 'controllers/TranslationsController.php';

// преобразуем URI в массив, где данные будут начиная со второго (1) ключа.
$uri_in_array = explode('/', $_SERVER['REQUEST_URI']);
class Api {

    public $request_method;
    public $ctrl_request;
    public $id;
    // запрос пользователя в виде массива, из которого можно будет понять, что именно пользователь хочет сделать

    public function __construct($method, $request_uri, $id = null)
    {
        $this->request_method = $method;
        $this->ctrl_request = $request_uri[3];
        if (isset($id)) {
            $this->id = $id;
        }
    }
    // здесь вызываем контроллер и передаём ему вызов метода из модели, при необходимости передаём id и др. данные
    public function requiredOutput($req_controller, $method, $id = null)
    {
        $controller = new $req_controller."Controller"();

        if ($method == 'GET') {
            // команда контроллеру на вызов метода getAll, если $id = null
            if ($id != null) {
                // команда контроллеру на вызов метода getOne
                $result = $controller->getOne($id);
                echo json_encode($result);
                return true;
            }
            $result = $controller->getAll();
            echo json_encode($result);
            return true;

        }
        if ($method == 'POST') {
            // команда контроллеру на вызов метода create
            $result = $controller->create();
            echo json_encode($result);
            return true;
        }
        if ($method == 'PUT') {
            // команда контроллеру на вызов метода update
            if (!isset($id)) {
                throw new exception ('Необходимый для работы id отсутствует');
            }
            $result = $controller->update($id);
            echo json_encode($result);
            return true;
        }
        if ($method == 'DELETE') {
            // команда контроллеру на вызов метода delete
            if (!isset($id)) {
                throw new exception ('Необходимый для работы id отсутствует');
            }
            $result = $controller->delete($id);
            echo json_encode($result);
            return true;
        }
    }
}

$test = new Api($_SERVER['REQUEST_METHOD'], $uri_in_array);

print_r($test);
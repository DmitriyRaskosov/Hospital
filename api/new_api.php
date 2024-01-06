<?php
require_once 'controllers/AppointmentsController.php';
require_once 'controllers/DoctorsController.php';
require_once 'controllers/TranslationsController.php';
require_once 'models/Appointments.php';
require_once 'models/Doctors.php';
require_once 'models/Translations.php';

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
            $this->id = $request_uri[4];
        }
    }
    // здесь вызываем контроллер и передаём ему вызов метода из модели, при необходимости передаём id и др. данные
    public function requiredOutput()
    {
        // Создаем экземпляр нужного нам контроллера
        $controller_name = $this->ctrl_request.'Controller';
        $controller = new $controller_name;
        if ($this->request_method == 'GET') {
            // команда контроллеру на вызов метода getAll, если $id = null
            if ($this->id != null) {
                // команда контроллеру на вызов метода getOne
                $result = $controller->getOne($this->id);
                echo json_encode($result);
                return true;
            }
            $result = $controller->getAll();
            echo json_encode($result);
            return true;

        }
        // команда контроллеру на вызов метода create
        elseif ($this->request_method == 'POST') {
            $post = $_POST;
            $result = $controller->create($post);
            echo json_encode($result);
            return true;
        }
        // команда контроллеру на вызов метода update
        elseif ($this->request_method == 'PUT') {
            $input_put = (array)json_decode(file_get_contents("php://input"), true);
            $changed_data = $input_put[0];
            $result = $controller->update($this->id, $changed_data);
            echo json_encode($result);
            return true;
        }
        // команда контроллеру на вызов метода delete
        elseif ($this->request_method == 'DELETE') {
            if (!isset($this->id)) {
                throw new Exception('Необходимый для работы id отсутствует');
            }
            $result = $controller->delete($this->id);
            echo json_encode($result);
            return true;
        }
        else {
            // Обработка ошибки "неизвестный https-метод"
        }
        return false;
    }
}

// преобразуем URI в массив, где данные будут начиная со второго (1) ключа.
$uri_in_array = explode('/', $_SERVER['REQUEST_URI']);
$test = new Api($_SERVER['REQUEST_METHOD'], $uri_in_array, $uri_in_array);
print_r($test);
$test->requiredOutput($test);
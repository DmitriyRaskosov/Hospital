<?php
require_once 'controllers/UsersController.php';
require_once 'models/Users.php';
require_once 'TranslatorTrait.php';
require_once __DIR__.'/../Database.php';


class Api {
    use Translator;
    protected static $instance;

    // запрос пользователя в виде массива, из которого можно будет понять, что именно пользователь хочет сделать
    protected function __construct($method, $request_uri)
    {
        $this->request_method = $method;
        $this->ctrl_request = $request_uri[3];
    }

    // попытка в singleton
    public static function getInstance($uri_in_array) {
        if (self::$instance === null) {
            self::$instance = new self($_SERVER['REQUEST_METHOD'], $uri_in_array);
        }
        return self::$instance;
    }

    public static function json_decoder($encoded_data) 
    {
        $decoded_json = (array)json_decode($encoded_data, true);
        print_r($decoded_json);
        return $decoded_json;
    }

    // здесь вызываем контроллер и передаём ему вызов метода из модели, при необходимости передаём id и др. данные
    public function requiredOutput()
    {
        // Создаем экземпляр нужного нам контроллера
        $controller_name = self::$instance->ctrl_request.'Controller';
        $controller = new $controller_name;
        $get = $_GET;
        $post = $_POST;
        $put = file_get_contents("php://input");

        if (self::$instance->request_method == 'GET') {
            $result = $controller->userAuthentification($get['email'], $get['password']);
            echo json_encode($result);
            return true;
        }

        /*
        if (self::$instance->request_method == 'GET') {
            // команда контроллеру на вызов метода getAll, если $id = null
            if (isset($get['id']) AND $get['id'] != null) {
                // команда контроллеру на вызов метода getOne
                $result = $controller->getOne($get['id']);
                echo json_encode($result);
                return true;
            }
            if (isset($get['filter'])) {
                $get = self::json_decoder($get['filter']);
            }
            $result = $controller->getAll($get);
            echo json_encode($result);
            return true;

        }
        // команда контроллеру на вызов метода create
        elseif (self::$instance->request_method == 'POST') {
            $post = self::json_decoder($post['filter']);
            $result = $controller->create($post);
            echo json_encode($result);
            return true;
        }
        // команда контроллеру на вызов метода update
        elseif (self::$instance->request_method == 'PUT') {  
            if (!isset($get['id'])) {
                throw new Exception('Необходимый для работы id отсутствует');
            }
            $put = self::json_decoder($put);
            $result = $controller->update($put, $get['id']);
            echo json_encode($result);
            return true;
        }
        // команда контроллеру на вызов метода delete
        elseif (self::$instance->request_method == 'DELETE') {
            if (!isset($get['id'])) {
                throw new Exception('Необходимый для работы id отсутствует');
            }
            $result = $controller->delete($get['id']);
            echo json_encode($result);
            return true;
        }
        else {
            // Обработка ошибки "неизвестный https-метод"
        }
        */
        //return false;
    }
}

// преобразуем URI в массив, где данные будут начиная со второго (1) ключа.
$uri_in_array = explode('/', $_SERVER['REQUEST_URI']);
$test = Api::getInstance($uri_in_array);
print_r($test);
$test->requiredOutput($test);
/*
$translation = $test->getTranslation('педиатр');
print_r($translation);
*/
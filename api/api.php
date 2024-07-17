<?php
require_once 'controllers/UsersController.php';
require_once 'controllers/DeliveryController.php';
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
        if (isset($request_uri[4]) && $request_uri[4] == 'auth') {
            $this->auth = $request_uri[4];
        }
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

    // авторизация пользователя - проверка наличия и срока годности хеш-ключа, true / false
    public static function checkAuth()
    {
        return UsersController::userAuthorization(self::$headers['Authorization']);
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
        $headers = apache_request_headers();    
        
        if (self::$instance->request_method == 'GET') {

            if ($controller_name == 'deliveryController') {
                $result = DeliveryController::getCoordinates($get);
                echo json_encode($result);
                return true;
            }

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

            if (self::$instance->ctrl_request == 'users' && isset(self::$instance->auth)) {
                $auth_data = self::json_decoder($post['auth']);
                
                $new_auth_key = UsersController::userAuthentification($auth_data);
                $headers['Authorization'] = $new_auth_key;
                echo $headers['Authorization'];
            } else {
                if (self::checkAuth() == false) {
                    throw new Exception('Пожалуйста, войдите или зарегистрируйтесь');
                }
            }

            $create_data = self::json_decoder($post['filter']);
            $result = $controller->create($create_data);

            echo json_encode($result);
            return true;
        }
        // команда контроллеру на вызов метода update
        elseif (self::$instance->request_method == 'PUT') {
            if (self::checkAuth() == false) {
                throw new Exception('Пожалуйста, войдите или зарегистрируйтесь');
            }
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
            if (self::checkAuth() == false) {
                throw new Exception('Пожалуйста, войдите или зарегистрируйтесь');
            }
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
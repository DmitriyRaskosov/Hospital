<?php
require_once 'controllers/AppointmentsController.php';
require_once 'controllers/DoctorsController.php';
require_once 'controllers/TranslationsController.php';
require_once 'models/Appointments.php';
require_once 'models/Doctors.php';
require_once 'models/Translations.php';
require_once 'Translator.php';
require_once __DIR__.'/../Database.php';


class Api {
    use Translator;
    protected static $instance;

    // запрос пользователя в виде массива, из которого можно будет понять, что именно пользователь хочет сделать
    protected function __construct($method, $request_uri, $id = null)
    {
        $this->request_method = $method;
        $this->ctrl_request = $request_uri[3];
        if (isset($id)) {
            $this->id = $request_uri[4];
        }
        $this->db_data = new Database();
    }

    // попытка в singleton
    public static function getInstance($uri_in_array) {
        if (self::$instance === null) {
            self::$instance = new self($_SERVER['REQUEST_METHOD'], $uri_in_array, $uri_in_array);
            return self::$instance;
        }
    }

    // здесь вызываем контроллер и передаём ему вызов метода из модели, при необходимости передаём id и др. данные
    public function requiredOutput()
    {
        // Создаем экземпляр нужного нам контроллера
        $controller_name = self::$instance->ctrl_request.'Controller';
        $controller = new $controller_name;
        if (self::$instance->request_method == 'GET') {
            // команда контроллеру на вызов метода getAll, если $id = null
            if (self::$instance->id != null) {
                // команда контроллеру на вызов метода getOne
                $result = $controller->getOne(self::$instance->id, self::$instance->db_data);
                echo json_encode($result);
                return true;
            }
            $result = $controller->getAll(self::$instance->db_data);
            echo json_encode($result);
            return true;

        }
        // команда контроллеру на вызов метода create
        elseif (self::$instance->request_method == 'POST') {
            $post = $_POST;
            $result = $controller->create($post, self::$instance->db_data);
            echo json_encode($result);
            return true;
        }
        // команда контроллеру на вызов метода update
        elseif (self::$instance->request_method == 'PUT') {
            if (!isset(self::$instance->id)) {
                throw new Exception('Необходимый для работы id отсутствует');
            }
            $input_put = (array)json_decode(file_get_contents("php://input"), true);
            $changed_data = $input_put[0];
            $result = $controller->update(self::$instance->id, $changed_data, self::$instance->db_data);
            echo json_encode($result);
            return true;
        }
        // команда контроллеру на вызов метода delete
        elseif (self::$instance->request_method == 'DELETE') {
            if (!isset(self::$instance->id)) {
                throw new Exception('Необходимый для работы id отсутствует');
            }
            $input_put = (array)json_decode(file_get_contents("php://input"), true);
            $result = $controller->delete(self::$instance->id, self::$instance->db_data);
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
$test = Api::getInstance($uri_in_array);
print_r($test);
$test->requiredOutput($test);
/*
$translation = $test->getTranslation('педиатр');
print_r($translation);
*/
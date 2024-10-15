<?php
namespace api;

require_once 'controllers/UsersController.php';
require_once 'controllers/DeliveryController.php';
require_once 'models/Users.php';
require_once 'TranslatorTrait.php';
require_once __DIR__.'/../Database.php';
require_once __DIR__.'/../vendor/autoload.php';

use Swagger\Annotations as SWG;

/**
 * Точка входа
 */
class Api {
    /*
     * Трейт, который давно не актуален и не используется. Раньше что-то переводил.
     * Находится здесь исключительно чтобы я не забывал о существовании трейтов.
     */
    use \Translator;

    /**
     * @var object $instance экземпляр класса
     */
    protected static $instance;

    /**
     * Запрос пользователя в виде массива, из которого можно будет понять, что именно пользователь хочет сделать
     * @param string $method название http-метода, берётся из $_SERVER
     * @param array $request_uri данные из $_SERVER['REQUEST_URI'], разбитые на массив для простоты работы
     */
    protected function __construct($method, $request_uri)
    {
        $this->request_method = $method;
        $this->ctrl_request = $request_uri[3];
        if (isset($request_uri[4]) && $request_uri[4] == 'auth') {
            $this->auth = $request_uri[4];
        }
    }

    /**
     * Попытка в Singleton
     * @param array $uri_in_array данные из $_SERVER['REQUEST_URI'], разбитые на массив для простоты работы
     * @return object|self возвращает результат создания экземпляра класса в виде созданного экземпляра с данными
     * todo Возможно переделаю на return true, возвращал данные таким образом для контроля за результатом работы кода
     */
    public static function getInstance($uri_in_array) {
        if (self::$instance === null) {
            self::$instance = new self($_SERVER['REQUEST_METHOD'], $uri_in_array);
        }
        return self::$instance;
    }

    /**
     * Метод для декодирования данных формата JSON
     * @param json $encoded_data данные формата JSON
     * @return array возврат декодированных данных JSON
     */
    public static function json_decoder($encoded_data) 
    {
        $decoded_json = (array)json_decode($encoded_data, true);
        print_r($decoded_json);
        return $decoded_json;
    }

    /**
     * Метод авторизации сущности пользователя (Users)
     * Метод проверяет наличие хеш-ключа и его срока годности
     * @return bool
     */
    public static function checkAuth()
    {
        return UsersController::userAuthorization(self::$headers['Authorization']);
    }

    /**
     * Метод вызова контроллера в зависимости от http-метода
     * @return true|void
     * @throws Exception
     */
    public function requiredOutput()
    {
        /*
         * Здесь создаётся экземпляр нужного контроллера
         * @var string $controller_name наименование контроллера
         * @var object $controller экземпляр контроллера
         */
        $controller_name = "api\controllers\\".self::$instance->ctrl_request.'Controller';
        $controller = new $controller_name;

        /*
         * Переменные с разными данными из разных http-методов и переменная с заголовками
         */
        $get = $_GET;
        $post = $_POST;
        $put = file_get_contents("php://input");
        $headers = apache_request_headers();
        echo $controller_name;
        if (self::$instance->request_method == 'GET') {

            /*
             * Небольшая вставка процесса обучения работе со сторонними API
             */
            if ($controller_name == 'deliveryController') {
                $result = DeliveryController::getCoordinates($get);
                echo json_encode($result);
                return true;
            }

            /*
             * Команда контроллеру на вызов метода getOne модели, если $id != null
             * Если есть какие-то данные кроме id ($get['filter']), то вызывается метод getAll модели
             */
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

        /*
         * Вызов контроллером метода create модели
         */
        elseif (self::$instance->request_method == 'POST') {

            /*
             * Для юзеров есть отдельный блок аутентификации и авторизации в рамках обучения этой теме
             */
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

        /*
         * Вызов контроллером метода update модели с проверкой авторизации для сущности Users (временно выключена)
         */
        elseif (self::$instance->request_method == 'PUT') {
            /*
            if (self::checkAuth() == false) {
                throw new Exception('Пожалуйста, войдите или зарегистрируйтесь');
            }
            */
            if (!isset($get['id'])) {
                throw new Exception('Необходимый для работы id отсутствует');
            }
            $put = self::json_decoder($put);
            $result = $controller->update($put, $get['id']);
            echo json_encode($result);
            return true;
        }

        /*
         * Вызов контроллером метода delete модели
         */
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
        
        return true;
    }
}

// преобразуем URI в массив, где данные будут начиная со второго (1) ключа.
$uri_in_array = explode('/', $_SERVER['REQUEST_URI']);
$test = Api::getInstance($uri_in_array);
print_r($test);
$test->requiredOutput($test);
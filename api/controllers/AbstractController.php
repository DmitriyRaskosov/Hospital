<?php
namespace api\controllers;
require_once __DIR__.'/../models/AbstractModel.php';
require_once __DIR__.'/../../Database.php';
require_once __DIR__.'/../../ValidationTrait.php';

abstract class AbstractController {
    use \Validation;

    /**
     * @var string $model_name наименование модели, присутствует в каждом контроллере
     */
    public static $model_name = 'AbstractModel';

    /**
     * Метод получения какого-то единственного блока данных
     * @param integer $id поиск блока данных осуществляется по его id
     * @return mixed возврат найденного блока данных
     */
    public function getOne($id)
    {
        $model_name = 'api\models\\'.static::$model_name;
        return $model_name::getOne($id);
    }

    /**
     * Метод получения двух и более блоков данных
     * @param array $get массив данных из полученного "фильтра", по которым будет произведён поиск
     * @return mixed возврат найденных данных
     */
    public function getAll($get)
    {
        $model_name = 'api\models\\'.static::$model_name;
        return $model_name::getAll($get);
    }

    /**
     * Метод создания новых данных
     * @param array $post массив с новыми данными
     * @return mixed возвращает данные
     * todo Возможно переделаю возврат булевых вместо данных
     */
    public function create($post)
    {
        $model_name = static::$model_name;
        return $model_name::create($post);
    }

    /**
     * Метод обновления данных
     * @param array $put массив данных, которые заменят одноимённые
     * @param integer $id id блока данных, в котором будет происходить замена
     * @return mixed возвращает успешно заменённые данные
     * todo Возможно переделаю возврат булевых вместо данных
     */
    public function update($put, $id)
    {
        $model_name = static::$model_name;
        return $model_name::update($put, $id);
    }

    /**
     * Метод удаления данных
     * @param integer $id поиск блока данных осуществляется по его id
     * @return mixed возвращает результат выполнения функции pg_execute
     * todo Возможно переделаю возврат булевых вместо текущего непонятного возврата
     */
    public function delete($id)
    {
        $model_name = static::$model_name;
        return $model_name::delete($id);
    }

}
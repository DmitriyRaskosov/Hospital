<?php
namespace api\controllers;
require_once 'AbstractController.php';

/*
 * Контроллер модели таблицы всех возможных особенностей товара.
 */
class FeaturesController extends AbstractController {

    /**
     * @var string $model_name Наименование таблицы в БД
     */
	public static $model_name = 'Features';

}
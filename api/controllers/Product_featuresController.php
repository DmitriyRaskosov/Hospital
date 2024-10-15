<?php
namespace api\controllers;
require_once 'AbstractController.php';

/*
 * Контроллер модели таблицы особенностей для каждого отдельного товара.
 */
class Product_featuresController extends AbstractController {

    /**
     * @var string $model_name Наименование таблицы в БД
     */
	public static $model_name = 'Product_features';
	
}
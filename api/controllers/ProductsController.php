<?php
namespace api\controllers;
require_once 'AbstractController.php';

/*
 * Контроллер модели существующих товаров.
 */
class ProductsController extends AbstractController {

    /**
     * @var string $model_name Наименование таблицы в БД
     */
	public static $model_name = 'Products';
	
}
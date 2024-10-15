<?php
namespace api\models;
require_once __DIR__.'/AbstractModel.php';

/**
 * Модель существующих товаров.
 */
class Products extends AbstractModel {

    /**
     * @var string $table_name Наименование таблицы в БД.
     */
	public static $table_name = 'Products';

    /**
     * @var array $attributes Наименования товаров.
     */
	public static array $attributes = ['name'];
	
}
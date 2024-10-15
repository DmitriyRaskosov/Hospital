<?php
namespace api\models;
require_once __DIR__.'/AbstractModel.php';

/**
 * Модель особенностей конкретного товара.
 */
class Product_features extends AbstractModel {

    /**
     * @var string $table_name Наименование таблицы в БД
     */
	public static $table_name = 'Product_features';

    /**
     * @var array $attributes Наименования особенностей товара.
     */
	public static array $attributes = ['product_name', 'product_feature', 'feature_value'];
	
}
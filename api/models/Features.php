<?php

require_once __DIR__.'/AbstractModel.php';

/**
 * Модель таблицы всех возможных особенностей товаров.
 */
class Features extends AbstractModel {

    /**
     * @var string $table_name Наименование таблицы в БД
     */
	public static $table_name = 'Features';

    /**
     * @var array $attributes Наименования особенностей товара.
     */
	public static array $attributes = ['feature_name'];

}
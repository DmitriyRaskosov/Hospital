<?php

require_once __DIR__.'/AbstractModel.php';

class Product_features extends AbstractModel {

	public static $table_name = 'Product_features';

	public static $attributes = ['product_name', 'product_feature', 'feature_value'];
	
}
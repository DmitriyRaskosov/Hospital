<?php

require_once __DIR__.'/AbstractModel.php';

class Products extends AbstractModel {

	public static $table_name = 'Products';

	public static $attributes = ['name'];
	
}
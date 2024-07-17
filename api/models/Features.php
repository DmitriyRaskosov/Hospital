<?php

require_once __DIR__.'/AbstractModel.php';

class Features extends AbstractModel {

	public static $table_name = 'Features';

	public static $attributes = ['feature_name'];

}
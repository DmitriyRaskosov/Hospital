<?php

require_once 'AbstractModel.php';

class Translations extends AbstractModel {

	public static $attributes = [
		'en' => null,
		'ru' => null
	];
	
	public static $path = __DIR__."/../../data/translations.json";

}
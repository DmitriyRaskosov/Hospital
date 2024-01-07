<?php

require_once 'AbstractModel.php';

class Translations extends AbstractModel {

	public $en;
	public $ru;
	public static $path = __DIR__."/../../data/translations.json";

}
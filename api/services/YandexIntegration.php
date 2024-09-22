<?php

require_once __DIR__.'/ReadConfigTrait.php';

class YandexIntegration {

	use ReadConfig;

}

$test = new YandexIntegration();

var_dump($test);
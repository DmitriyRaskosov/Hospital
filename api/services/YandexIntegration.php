<?php

require_once __DIR__.'/ReadConfigTrait.php';

/**
 * Класс, который позволяет получить координаты желаемого адреса.
 * Существует в рамках обучения взаимодействию со сторонними API.
 * Вся работа происходит в трейте.
 */
class YandexIntegration {

	use ReadConfig;

}

$test = new YandexIntegration();

var_dump($test);
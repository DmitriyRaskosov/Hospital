<?php

require_once 'AbstractController.php';
require_once __DIR__.'/../services/YandexIntegration.php';

class DeliveryController extends AbstractController {

	public static function getCoordinates($get)
	{
		return YandexIntegration::getCoordinates($get);
	}

}
<?php
namespace api\controllers;

require_once 'AbstractController.php';
require_once __DIR__.'/../services/YandexIntegration.php';

/*
 * Контроллер доставки
 */
class DeliveryController extends AbstractController {

    /*
     * Метод получения координат места доставки при помощи стороннего апи Яндекса.
     */
	public static function getCoordinates($get)
	{
		return \api\services\YandexIntegration::class::getCoordinates($get);
	}

}
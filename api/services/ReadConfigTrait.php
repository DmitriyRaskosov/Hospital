<?php

use GuzzleHttp\Client;

/**
 * Трейт для чтения конфигураций проекта.
 * В данный момент проект содержит всего одну конфигурацию, используемую во взаимодействии со сторонним API Яндекса.
 */
trait ReadConfig {

    /**
     * Метод получения URI для дальнейшего формирования запроса к API.
     * @param array $get Данные, полученные для формирования запроса. Конкретно здесь - адрес.
     * @return array
     */
	private static function getUri($get)
	{
		$string = file_get_contents(__DIR__.'/../configurations/config.env');
		$pass = ltrim(substr($string, strpos($string, '=')+1));

		$get = [
			'apikey' => $pass,
			'geocode' => $get['geocode'],
			'format' => 'json',
		];

		return $get;
	}

    /**
     * Метод, который делает запрос к API и возвращает полученный ответ.
     * @param array $get Данные из $_GET, которые будут использованы в работе метода getUri().
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
	public static function getCoordinates($get)
    {
    	$client = new GuzzleHttp\Client(['base_uri' => 'https://geocode-maps.yandex.ru/1.x/']);
    	$responce = $client->request('GET', 'https://geocode-maps.yandex.ru/1.x/', ['query' => http_build_query(self::getUri($get))]);
    	$decoded_responce = (array)json_decode($responce->getBody(), true);
    	$coordinates = $decoded_responce['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'];
    	return $coordinates;
    }

}
<?php

require_once 'C:/OpenServer/domains/localhost/hospital/vendor/autoload.php';
use GuzzleHttp\Client;

trait ReadConfig {

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

	public static function getCoordinates($get)
    {
    	$client = new GuzzleHttp\Client(['base_uri' => 'https://geocode-maps.yandex.ru/1.x/']);
    	$responce = $client->request('GET', 'https://geocode-maps.yandex.ru/1.x/', ['query' => http_build_query(self::getUri($get))]);
    	$decoded_responce = (array)json_decode($responce->getBody(), true);
    	$coordinates = $decoded_responce['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'];
    	return $coordinates;
    }

}
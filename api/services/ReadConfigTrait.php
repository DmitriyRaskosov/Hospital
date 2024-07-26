<?php

require_once 'C:/OpenServer/vendor/autoload.php';
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

/*
trait ReadConfig {

	public static function getPass()
	{
		$string = file_get_contents(__DIR__.'/../configurations/config.env');
		$pass = ltrim(substr($string, strpos($string, '=')+1));

		return $pass;
	}

	
	// curl
	public static function getCoordinates($get)
	{
		$get = [
			'apikey' => self::getPass(),
			'geocode' => $get['geocode'],
			'format' => 'json',
		];

		
		$curl_handle = curl_init('https://geocode-maps.yandex.ru/1.x/?'.http_build_query($get));
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
		$json = curl_exec($curl_handle);
		curl_close($curl_handle);

		$decoded_json = (array)json_decode($json, true);
		$coordinates = $decoded_json['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'];
		return $coordinates;
		
	}
	

}
*/
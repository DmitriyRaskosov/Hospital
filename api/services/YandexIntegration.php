<?php

class YandexIntegration {

	private static $apikey = 'fb2bf220-834f-47c9-91ff-06cdfe45250d';

	// curl
	public static function getCoordinates($get)
	{
		$get = [
			'apikey' => self::$apikey,
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
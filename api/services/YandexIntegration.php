<?php

class YandexIntegration {

	public static function getPass()
	{
		$string = file_get_contents(__DIR__.'/config.env');
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
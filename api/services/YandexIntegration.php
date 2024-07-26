<?php

require_once __DIR__.'/ReadConfigTrait.php';
//require_once 'C:/OpenServer/vendor/autoload.php';

class YandexIntegration {

	use ReadConfig;
	//use GuzzleHttp\Client;
/*
	protected function __construct()
    {
        $this->client = new GuzzleHttp\Client(['base_uri' => 'https://geocode-maps.yandex.ru/1.x/']);
        $this->responce = self::$client->request('GET', self::getUri());
        $this->decoded_responce = (array)json_decode(self::$responce, true);
        $this->coordinates = self::$decoded_responce['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'];
    }

    public static function getCoordinates()
    {
    	return self::$client->coordinates;
    }
*/
}

$test = new YandexIntegration();

var_dump($test);
<?php
require_once 'abstractPolygon.php';

class Polygon extends AbstractPolygon {

	// представляем трапецию

	public function __construct ($a, $b, $h) {
		$this->parameters['a'] = $a;
		$this->parameters['b'] = $b;
		$this->parameters['h'] = $h;
	}

	// S = ((a+b)/2)*h
	public function area () {
		$parameters = $this->parameters;
		$area = (($parameters['a'] + $parameters['b']) / 2) * $parameters['h'];
		return $area;
	}
}
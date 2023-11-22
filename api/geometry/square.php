<?php

class Square extends AbstractPolygon {

	// а - сторона квадрата

	public function __construct ($a) {
		$this->parameters['a'] = $a;
	}

	// S = a**2
	public function area () {
		$parameters = $this->parameters;
		$area = pow($parameters['a'], 2);
		return $area;
	}
}
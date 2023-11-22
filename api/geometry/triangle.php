<?php

class Triangle extends AbstractPolygon {

	// a, b - стороны

	public function __construct ($a, $h) {
		$this->parameters['a'] = $a;
		$this->parameters['h'] = $h;
	}

	// S = (a*h)/2
	public function area () {
		$parameters = $this->parameters;
		$area = ($parameters['a'] * $parameters['h']) / 2;
		return $area;
	}
}
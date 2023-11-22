<?php

class Polygon90 extends AbstractPolygon {

	// прямоугольный треугольник 
	// a, b - стороны

	public function __construct ($a, $b) {
		$this->parameters['a'] = $a;
		$this->parameters['b'] = $b;
	}

	// S = (a*b)/2
	public function area () {
		$parameters = $this->parameters;
		$area = ($parameters['a'] * $parameters['b']) / 2;
		return $area;
	}
}
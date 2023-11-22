<?php

class Quadrangle extends AbstractPolygon {

	// четырёхугольник (прямоугольник)
	// a, b - стороны

	public function __construct ($a, $b) {
		$this->parameters['a'] = $a;
		$this->parameters['b'] = $b;
	}

	// S = a*b
	public function area () {
		$parameters = $this->parameters;
		$area = $parameters['a'] * $parameters['b'];
		return $area;
	}
}
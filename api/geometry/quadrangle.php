<?php

class Quadrangle {

	// четырёхугольник (прямоугольник)
	// a, b - стороны

	$parameters = ['a' => null, 'b' => null];

	// S = a*b
	public function area ($parameters) {
		$area = $parameters['a'] * $parameters['b'];
	}
}
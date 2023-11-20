<?php

class Polygon90 {

	// прямоугольный треугольник 
	// a, b - стороны

	$parameters = ['a' => null, 'b' => null];

	// S = (a*b)/2
	public function area ($parameters) {
		$area = ($parameters['a'] * $parameters['b']) / 2;
	}
}
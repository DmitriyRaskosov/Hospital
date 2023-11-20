<?php

class Polygon {

	// многоугольников разных дохуя, представляем трапецию
	// a, b - стороны, h - высота

	$parameters = ['a' => null, 'b' => null, 'h' => null];

	// S = ((a+b)/2)*h
	public function area ($parameters) {
		$area = (($parameters['a'] + $parameters['b']) / 2) * $parameters['h'];
	}
}
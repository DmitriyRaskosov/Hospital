<?php

class Triangle {

	// a, b - стороны

	$parameters = ['a' => null, 'h' => null];

	// S = (a*h)/2
	public function area ($parameters) {
		$area = ($parameters['a'] * $parameters['h']) / 2;
	}
}
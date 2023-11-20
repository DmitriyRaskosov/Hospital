<?php

class Square {

	// a, b - стороны

	$parameters = ['a' => null];

	// S = a**2
	public function area ($parameters) {
		$area = pow($parameters['a'], 2);
	}
}
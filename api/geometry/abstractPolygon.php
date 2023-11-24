<?php

abstract class AbstractPolygon {

	// абстрактный класс всех геометрических фигур
	// a, b - стороны, h - высота

	public $parameters = ['a' => null, 'b' => null, 'h' => null];

	// метод расчёта периметра
	private function perimeter ()
	{
		$p = ($this->parameters['b'] + $this->parameters['a']) * 2;
		return $p;
	}

	// метод вызова расчёта периметра согласно условиям (есть ширина или нет и нужно её найти из площади)
	public function perimeter_finder ()
	{
		if ($this->parameters['b'] != null) {
			$p = $this->perimeter();
			return $p;
		}
		if ($this->parameters['b'] == null) {
			$area = $this->area();
			// хз хотим ли мы, чтобы найденная ширина была записана в свойство фигуры - если нет, то будет переменная $b вместо записи в свойство
			$this->parameters['b'] = $area / $this->parameters['a'];
			$p = $this->perimeter();
			return $p;
		}
	}
}
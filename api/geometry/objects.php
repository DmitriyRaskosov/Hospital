<?php

require_once 'polygon.php';

$polygon = new Polygon(2, 3, 5);

print_r($polygon);
print_r($polygon->area()."<br>");

require_once 'polygon90.php';

$polygon90 = new Polygon90(4, 5);

print_r($polygon90);
print_r($polygon90->area()."<br>");

require_once 'quadrangle.php';

$quadrangle = new Quadrangle(2, 5);

print_r($quadrangle);
print_r($quadrangle->area()."<br>");

require_once 'square.php';

$square = new Square(7);

print_r($square);
print_r($square->area()."<br>");

require_once 'triangle.php';

$triangle = new Triangle(2, 3);

print_r($triangle);
print_r($triangle->area()."<br>");

echo $triangle->perimeter_finder();
<?php

require './vendor/autoload.php';

use Fairy\Boundary;
use Fairy\Point;

$points = [
    ['x' => 9.4, 'y' => 12.04],
    ['x' => 6.68, 'y' => 8.61],
    ['x' => 9.05, 'y' => 6.06],
    ['x' => 6.24, 'y' => 3.87],
    ['x' => 10.02, 'y' => 2.55],
    ['x' => 14.06, 'y' => 4.13],
    ['x' => 4.13, 'y' => 7.56],
    ['x' => 11.69, 'y' => 8.35],
];

// 9.97, 4.96  在内
// 15.73, 5.62  在外
echo Boundary::getInstance()
    ->latitudeKey('x')
    ->longitudeKey('y')
    ->contains(new Point(9.97, 4.96), $points) ? '内' : '外';
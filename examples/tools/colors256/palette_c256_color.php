<?php

use AlecRabbit\ConsoleColour\ConsoleColor;

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../data2.php';

$c = new ConsoleColor();

function row($row, ConsoleColor $c, $num = false)
{
    foreach ($row as $index => $color) {
        $textColor = ($index >= 3 && $index <= 8) ? 'color_238' : 'color_252';
        $text = $num ? '  ' . $color . '  ' : '       ';
        echo $c->apply([$textColor, 'bg_color_' . $color], $text);
    }
    echo PHP_EOL;
}

foreach ($colorArray2 as $num => $row) {
    row($row, $c);

    row($row, $c, true);

    row($row, $c);
    if (0 === ($num+1) % 6) {
        echo PHP_EOL;
    }
}


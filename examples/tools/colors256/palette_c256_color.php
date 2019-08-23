<?php

use AlecRabbit\ConsoleColour\ConsoleColor;

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../data2.php';

$c = new ConsoleColor();

echo PHP_EOL;

foreach ($colorArray2 as $num => $row) {
    row($row, $c);

    row($row, $c, true);

    row($row, $c);
    if (0 === ($num+1) % 6) {
        echo PHP_EOL;
    }
}

foreach ($greyScale2 as $num => $row) {
    row($row, $c, false, true);

    row($row, $c, true, true);

    row($row, $c, false, true);
}

function row($row, ConsoleColor $c, $num = false, $bw = false)
{
    foreach ($row as $index => $color) {
        $textColor = textColor($bw, $color, $index);
        $text = $num ? '  ' . $color . '  ' : '       ';
        echo $c->apply([$textColor, 'bg_color_' . $color], $text);
    }
    echo PHP_EOL;
}

function textColor($bw, $color, $index): string
{
    if ($bw) {
        if ((int)$color > 243) {
            $textColor = 'color_238';
        } else {
            $textColor = 'color_252';
        }
    } else {
        $textColor = ($index >= 3 && $index <= 8) ? 'color_238' : 'color_252';
    }
    return $textColor;
}

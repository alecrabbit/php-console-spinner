<?php

use AlecRabbit\ConsoleColour\ConsoleColor;

const CELL_WIDTH = 7;

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../data2.php';

$c = new ConsoleColor();

echo PHP_EOL;

foreach ($colorArray2 as $num => $row) {
    row($row, $c);
    row($row, $c, true);
    row($row, $c);
    if (0 === ($num + 1) % 6) {
        echo PHP_EOL;
    }
}

foreach ($greyScale2 as $num => $row) {
    row($row, $c, false, true);
    row($row, $c, true, true);
    row($row, $c, false, true);
}

echo PHP_EOL;

foreach ($xterm2 as $num => $row) {
    row($row, $c, false, true);
    row($row, $c, true, true);
    row($row, $c, false, true);
}

echo PHP_EOL;

function row($row, ConsoleColor $c, $num = false, $bw = false)
{
    foreach ($row as $index => $color) {
        $textColor = textColor($bw, $color, $index);
        $text =
            $num ?
                str_pad($color, CELL_WIDTH, ' ', STR_PAD_BOTH) :
                str_repeat(' ', CELL_WIDTH);
        echo $c->apply([$textColor, 'bg_color_' . $color], $text);
    }
    echo PHP_EOL;
}

function textColor($bw, $color, $index): string
{
    $i = (int)$color;
    if ($bw) {
        if ($i > 243) {
            $textColor = 'color_238';
        } elseif ($i >= 7 && $i <= 15 && $i !== 8) {
            $textColor = 'color_234';
        }  else {
            $textColor = 'color_252';
        }
    } else {
        $textColor = ($index >= 3 && $index <= 8) ? 'color_238' : 'color_252';
        if ($i >= 160 && $i <= 231) {
            $textColor = 'color_238';
        }
    }
    return $textColor;
}

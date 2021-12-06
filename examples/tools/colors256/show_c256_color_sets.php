<?php

use AlecRabbit\ConsoleColour\ConsoleColor;
use AlecRabbit\SpinnerOld\Core\Contracts\Styles;

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../data.php';

$c = new ConsoleColor();

$sets = [
    'C256_PURPLE_RED' => Styles::C256_PURPLE_RED,
    'C256_ROYAL_BLUE_INDIAN_RED' => Styles::C256_ROYAL_BLUE_INDIAN_RED,
    'C256_RAINBOW' => Styles::C256_RAINBOW,
    'C256_ROYAL_RAINBOW' => Styles::C256_ROYAL_RAINBOW,
    'C256_C_RAINBOW' => Styles::C256_C_RAINBOW,
    'C256_YELLOW_WHITE' => Styles::C256_YELLOW_WHITE,
];
foreach ($sets as $name => $set) {
    echo $name . PHP_EOL;
    foreach ($set as $item) {
        echo
            $c->apply('bg_color_' . $item, '    ') .
            ' ' . str_pad($item, 3, ' ', STR_PAD_LEFT) .
            ' ' . $decoded[(int)$item]['name'] .
            PHP_EOL;
    }
}

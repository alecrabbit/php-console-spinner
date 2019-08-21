<?php

use AlecRabbit\ConsoleColour\ConsoleColor;
use AlecRabbit\Spinner\Core\Contracts\StylesInterface;

require_once __DIR__ . '/../../../vendor/autoload.php';

$c = new ConsoleColor();

$sets = [
    'C256_PURPLE_RED' => StylesInterface::C256_PURPLE_RED,
    'C256_ROYAL_BLUE_INDIAN_RED' => StylesInterface::C256_ROYAL_BLUE_INDIAN_RED,
    'C256_RAINBOW' => StylesInterface::C256_RAINBOW,
    'C256_ROYAL_RAINBOW' => StylesInterface::C256_ROYAL_RAINBOW,
    'C256_YELLOW_WHITE' => StylesInterface::C256_YELLOW_WHITE,
];
foreach ($sets as $name => $set) {
    echo $name . PHP_EOL;
    foreach ($set as $item) {
        showColor($c, $item);
    }
}

function showColor(ConsoleColor $c, $item): void
{
    echo $c->apply('bg_color_' . $item, '    ') . PHP_EOL;
}

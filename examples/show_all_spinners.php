<?php

use AlecRabbit\ConsoleColour\ConsoleColor;
use AlecRabbit\ConsoleColour\Themes;
use AlecRabbit\Control\Cursor;
use AlecRabbit\Spinner\CircleSpinner;
use AlecRabbit\Spinner\ClockSpinner;
use AlecRabbit\Spinner\MoonSpinner;
use AlecRabbit\Spinner\SimpleSpinner;
use AlecRabbit\Spinner\SnakeSpinner;
use AlecRabbit\Spinner\TrigramSpinner;
use function AlecRabbit\typeOf;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/__helper_functions.php';

const ITER = 200;
const MESSAGE = 'Processing';
const MILLISECONDS = 80;

$theme = new Themes();
$microseconds = MILLISECONDS * 1000;
echo Cursor::hide();
echo $theme->comment('Spinners samples(with message"' . MESSAGE . '"):') . PHP_EOL;
showSpinners(
    [
        new CircleSpinner(MESSAGE),
        new ClockSpinner(MESSAGE),
        new MoonSpinner(MESSAGE),
        new SimpleSpinner(MESSAGE),
        new SnakeSpinner(MESSAGE),
    ], $theme,
    $microseconds
);
echo $theme->comment('Spinners samples(without message):') . PHP_EOL;
showSpinners(
    [
        new CircleSpinner(),
        new ClockSpinner(),
        new MoonSpinner(),
        new SimpleSpinner(),
        new SnakeSpinner(),
    ], $theme,
    $microseconds
);
echo Cursor::show();

// ************************ Functions ************************

/**
 * @param array $spinners
 * @param Themes $theme
 * @param $microseconds
 */
function showSpinners(array $spinners, Themes $theme, $microseconds): void
{
    foreach ($spinners as $s) {
        echo $theme->cyan('[' . typeOf($s) . ']:') . PHP_EOL;
        echo PHP_EOL;
        echo Cursor::up();
        echo $s->begin(); // Optional
        for ($i = 1; $i <= ITER; $i++) {
            echo $s->spin();
            usleep($microseconds);
        }
        // Note: we're not erasing spinner here
        // if you want to uncomment next line
        //echo $s->end();
        echo PHP_EOL;
        echo PHP_EOL;
    }
}


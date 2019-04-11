<?php

use AlecRabbit\ConsoleColour\Themes;
use AlecRabbit\Control\Cursor;
use AlecRabbit\Spinner\CircleSpinner;
use AlecRabbit\Spinner\ClockSpinner;
use AlecRabbit\Spinner\Contracts\SpinnerInterface;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\MoonSpinner;
use AlecRabbit\Spinner\SimpleSpinner;
use AlecRabbit\Spinner\SnakeSpinner;

require_once __DIR__ . '/../vendor/autoload.php';

const ITER = 40;
const MESSAGE = 'processing';
const MESSAGE2 = 'computing';

$theme = new Themes();
//echo Cursor::hide();
echo PHP_EOL;
$spinners = [
    Spinner::class,
    CircleSpinner::class,
    ClockSpinner::class,
    MoonSpinner::class,
    SimpleSpinner::class,
    SnakeSpinner::class,
];
foreach ($spinners as $spinner) {
    showSpinners(new $spinner(MESSAGE), true);
    showSpinners(new $spinner(), true);
    showSpinners(new $spinner(MESSAGE2));
    showSpinners(new $spinner());
}

echo PHP_EOL;
echo PHP_EOL;

//echo Cursor::show();

// ************************ Functions ************************

/**
 * @param SpinnerInterface $s
 * @param bool $withPercent
 */
function showSpinners(SpinnerInterface $s, bool $withPercent = false): void
{
    $microseconds = $s->interval() * 1000000;
    echo PHP_EOL;
    echo Cursor::up();
    echo $s->begin(); // Optional
    for ($i = 1; $i <= ITER; $i++) {
        echo $s->spin($withPercent ? $i / ITER : null);
        usleep($microseconds);
    }
    // Note: we're not erasing spinner here
    // if you want to uncomment next line
    echo $s->end();
//    echo PHP_EOL;
//    echo PHP_EOL;
}


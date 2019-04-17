<?php

use AlecRabbit\Cli\Tools\Cursor;
use AlecRabbit\ConsoleColour\Themes;
use AlecRabbit\Spinner\CircleSpinner;
use AlecRabbit\Spinner\ClockSpinner;
use AlecRabbit\Spinner\Core\Contracts\SpinnerInterface;
use AlecRabbit\Spinner\DiceSpinner;
use AlecRabbit\Spinner\DotSpinner;
use AlecRabbit\Spinner\MoonSpinner;
use AlecRabbit\Spinner\PercentSpinner;
use AlecRabbit\Spinner\SectorsSpinner;
use AlecRabbit\Spinner\SimpleSpinner;
use AlecRabbit\Spinner\SnakeSpinner;
use AlecRabbit\Spinner\ZodiacSpinner;

//require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../tests/bootstrap.php';

const ITER = 30;
const MESSAGE = 'message';

$theme = new Themes();
echo Cursor::hide();
echo PHP_EOL;
echo PHP_EOL;
//sleep(1);
$spinners = [
    PercentSpinner::class,
    SimpleSpinner::class,
    DotSpinner::class,
    SnakeSpinner::class,
    CircleSpinner::class,
    ClockSpinner::class,
    MoonSpinner::class,
    ZodiacSpinner::class,
    DiceSpinner::class,
    SectorsSpinner::class,
];

$arr = [
    PercentSpinner::class,
    SnakeSpinner::class,
    ClockSpinner::class,
    MoonSpinner::class,
    ZodiacSpinner::class,
    DiceSpinner::class,
    SectorsSpinner::class,
];

foreach ($spinners as $spinner) {
    if (in_array($spinner, $arr, true)) {
        showSpinners(new $spinner(MESSAGE), true);
        showSpinners(new $spinner(), true);
    }
    if ($spinner !== PercentSpinner::class) {
        showSpinners(new $spinner());
    }
}

echo PHP_EOL;
echo PHP_EOL;

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
    echo $s->end();
}


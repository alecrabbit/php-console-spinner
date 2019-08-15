<?php

use AlecRabbit\Accessories\Pretty;
use AlecRabbit\Cli\Tools\Cursor;
use AlecRabbit\ConsoleColour\Themes;
use AlecRabbit\Spinner\ArrowSpinner;
use AlecRabbit\Spinner\BallSpinner;
use AlecRabbit\Spinner\CircleSpinner;
use AlecRabbit\Spinner\ClockSpinner;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\DiceSpinner;
use AlecRabbit\Spinner\DotSpinner;
use AlecRabbit\Spinner\LineSpinner;
use AlecRabbit\Spinner\MoonSpinner;
use AlecRabbit\Spinner\SectorsSpinner;
use AlecRabbit\Spinner\SimpleSpinner;
use AlecRabbit\Spinner\SnakeSpinner;
use AlecRabbit\Spinner\TimeSpinner;
use function AlecRabbit\typeOf;

require_once __DIR__ . '/../vendor/autoload.php';

const ITER = 30;
const MESSAGE = 'Processing';

$theme = new Themes();
echo Cursor::hide();
echo $theme->comment('Spinners samples(with message"' . MESSAGE . '"):') . PHP_EOL;

showSpinners(
    [
//        new ArrowSpinner(MESSAGE),
//        new BallSpinner(MESSAGE),
//        new CircleSpinner(MESSAGE),
//        new ClockSpinner(MESSAGE),
//        new DiceSpinner(MESSAGE),
//        new DotSpinner(MESSAGE),
//        new LineSpinner(MESSAGE),
//        new MoonSpinner(MESSAGE),
//        new SectorsSpinner(MESSAGE),
//        new SimpleSpinner(MESSAGE),
//        new SnakeSpinner(MESSAGE),
        (new TimeSpinner(MESSAGE))->setTimeFormat('T Y-m-d H:i:s'),
    ], $theme
);
echo $theme->comment('Spinners samples(without message):') . PHP_EOL;
showSpinners(
    [
        new ArrowSpinner(),
        new ClockSpinner(),
        new MoonSpinner(),
        new CircleSpinner(),
        new DiceSpinner(),
        new SectorsSpinner(),
        new SimpleSpinner(),
        new SnakeSpinner(),
    ], $theme
);
echo Cursor::show();

// ************************ Functions ************************

/**
 * @param array $spinners
 * @param Themes $theme
 */
function showSpinners(array $spinners, Themes $theme): void
{
    /** @var Spinner $s */
    foreach ($spinners as $s) {
        $microseconds = $s->interval() * 1000000;
        echo
            $theme->cyan('[' . typeOf($s) . '] ') .
            $theme->dark('(' . Pretty::microseconds($microseconds) . ')') . // Recommended refresh interval
            PHP_EOL;
        echo PHP_EOL;
        echo Cursor::up();
        echo $s->begin(); // Optional
        for ($i = 1; $i <= ITER; $i++) {
            echo $s->spin();
            usleep($microseconds);
        }
        // Note: we're not erasing spinner here
        // uncomment next line if you want to
//        echo $s->end();
        echo PHP_EOL;
        echo PHP_EOL;
    }
}


<?php

use AlecRabbit\Accessories\Pretty;
use AlecRabbit\Cli\Tools\Cursor;
use AlecRabbit\ConsoleColour\Themes;
use AlecRabbit\Spinner\ArrowSpinner;
use AlecRabbit\Spinner\BallSpinner;
use AlecRabbit\Spinner\BlockSpinner;
use AlecRabbit\Spinner\CircleSpinner;
use AlecRabbit\Spinner\ClockSpinner;
use AlecRabbit\Spinner\Core\AbstractSpinner;
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

echo $theme->comment('TimeSpinner(demo time: 10s):') . PHP_EOL;
showSpinners(
    [
        (new TimeSpinner())->setTimeFormat('T Y-m-d H:i:s'),
    ],
    $theme,
    10
);
$classes = [
    ArrowSpinner::class,
    BallSpinner::class,
    BlockSpinner::class,
    CircleSpinner::class,
    ClockSpinner::class,
    DiceSpinner::class,
    DotSpinner::class,
    LineSpinner::class,
    MoonSpinner::class,
    SectorsSpinner::class,
    SimpleSpinner::class,
    SnakeSpinner::class,
];
$spinners = [];
foreach ($classes as $class) {
    $spinners[] = new $class(MESSAGE);
}
echo $theme->comment('Spinners samples(with message"' . MESSAGE . '"):') . PHP_EOL;
showSpinners($spinners, $theme);
$spinners = [];
foreach ($classes as $class) {
    $spinners[] = new $class();
}
echo $theme->comment('Spinners samples(without message):') . PHP_EOL;
showSpinners($spinners, $theme);

echo Cursor::show();


// ************************ Functions ************************

/**
 * @param array $spinners
 * @param Themes $theme
 * @param int $iter
 */
function showSpinners(array $spinners, Themes $theme, int $iter = ITER): void
{
    /** @var AbstractSpinner $s */
    foreach ($spinners as $s) {
        $microseconds = $s->interval() * 1000000;
        echo
            $theme->cyan('[' . typeOf($s) . '] ')  .
            $theme->dark('(Recommended refresh interval: ' . Pretty::microseconds($microseconds) . ')') . // Recommended refresh interval
            PHP_EOL;
        echo PHP_EOL, PHP_EOL;
        echo Cursor::up();
        echo $s->begin(); // Optional
        for ($i = 1; $i <= $iter; $i++) {
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


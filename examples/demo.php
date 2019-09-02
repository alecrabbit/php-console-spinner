<?php

use AlecRabbit\Cli\Tools\Cursor;
use AlecRabbit\ConsoleColour\Themes;
use AlecRabbit\Spinner\ArrowSpinner;
use AlecRabbit\Spinner\BallSpinner;
use AlecRabbit\Spinner\BlockSpinner;
use AlecRabbit\Spinner\CircleSpinner;
use AlecRabbit\Spinner\ClockSpinner;
use AlecRabbit\Spinner\Core\Contracts\SpinnerInterface;
use AlecRabbit\Spinner\DiceSpinner;
use AlecRabbit\Spinner\DotSpinner;
use AlecRabbit\Spinner\EarthSpinner;
use AlecRabbit\Spinner\MoonSpinner;
use AlecRabbit\Spinner\PercentSpinner;
use AlecRabbit\Spinner\SectorsSpinner;
use AlecRabbit\Spinner\Settings\Settings;
use AlecRabbit\Spinner\SimpleSpinner;
use AlecRabbit\Spinner\SnakeSpinner;
use AlecRabbit\Spinner\TimeSpinner;
use function AlecRabbit\brackets;

//require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../tests/bootstrap.php';

const ITER = 30;
const MESSAGES = [
    ['mᚹä漢d字', 8],
    ['message', null],
    ['computing', null],
];

$t = new Themes();
echo Cursor::hide();

$spinners = [
    ArrowSpinner::class,
    BallSpinner::class,
    BlockSpinner::class,
    CircleSpinner::class,
    ClockSpinner::class,
    DiceSpinner::class,
    DotSpinner::class,
    EarthSpinner::class,
    MoonSpinner::class,
    PercentSpinner::class,
    SectorsSpinner::class,
    SimpleSpinner::class,
    SnakeSpinner::class,
    TimeSpinner::class,
];

$arr = [
    BlockSpinner::class,
    ArrowSpinner::class,
    BallSpinner::class,
    EarthSpinner::class,
    PercentSpinner::class,
    SnakeSpinner::class,
    ClockSpinner::class,
    MoonSpinner::class,
    DiceSpinner::class,
    SectorsSpinner::class,
];

$len = count(MESSAGES) - 1;
foreach ($spinners as $spinner) {
    echo $t->bold(PHP_EOL . brackets($spinner) . ' ');
    $m = MESSAGES[rnd($len)];
    [$message, $erLen] = $m;
    if (in_array($spinner, $arr, true)) {
        $s = new Settings();
        $s->setMessage($message);
        showSpinners(new $spinner($s), true);
        showSpinners(new $spinner(), true);
    }
    if ($spinner !== PercentSpinner::class) {
        showSpinners(new $spinner());
    }
    echo Cursor::up();
}

echo PHP_EOL;
echo Cursor::absX(0) . str_repeat(' ', 100);
echo PHP_EOL;

// ************************ Functions ************************

/**
 * @param SpinnerInterface $s
 * @param bool $withPercent
 */
function showSpinners(SpinnerInterface $s, bool $withPercent = false): void
{
    $microseconds = $s->interval() * 1000000;
    echo $s->begin(); // Optional
    for ($i = 1; $i <= ITER; $i++) {
        if ($s instanceof PercentSpinner) {
            $s->spin($withPercent ? $i / ITER : null);
        } else {
            $s
                ->progress($withPercent ? $i / ITER : null)
                ->spin();
        }
        usleep($microseconds);
    }
    echo $s->end();
}

/**
 * @param int $len
 * @return int
 */
function rnd(int $len): int
{
    try {
        return random_int(0, $len);
    } catch (Exception $e) {
        return 0;
    }
}



<?php

use AlecRabbit\Cli\Tools\Cursor;
use AlecRabbit\Cli\Tools\Line;
use AlecRabbit\ConsoleColour\Themes;
use AlecRabbit\Spinner\ArrowSpinner;
use AlecRabbit\Spinner\BallSpinner;
use AlecRabbit\Spinner\BlockSpinner;
use AlecRabbit\Spinner\BouncingBarSpinner;
use AlecRabbit\Spinner\CircleSpinner;
use AlecRabbit\Spinner\ClockSpinner;
use AlecRabbit\Spinner\Core\Contracts\SpinnerInterface;
use AlecRabbit\Spinner\DiceSpinner;
use AlecRabbit\Spinner\DotSpinner;
use AlecRabbit\Spinner\EarthSpinner;
use AlecRabbit\Spinner\MoonSpinner;
use AlecRabbit\Spinner\PercentSpinner;
use AlecRabbit\Spinner\SectorsSpinner;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;
use AlecRabbit\Spinner\Settings\Settings;
use AlecRabbit\Spinner\SimpleSpinner;
use AlecRabbit\Spinner\SnakeSpinner;
use AlecRabbit\Spinner\TimeSpinner;
use AlecRabbit\Spinner\WeatherSpinner;
use function AlecRabbit\brackets;
use function AlecRabbit\str_wrap;
use const AlecRabbit\COLOR256_TERMINAL;
use const AlecRabbit\COLOR_TERMINAL;
use const AlecRabbit\NO_COLOR_TERMINAL;
use const AlecRabbit\TERMINAL_COLOR_MODES;

//require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../tests/bootstrap.php';
require_once __DIR__ . '/__include/__functions.php';
require_once __DIR__ . '/__include/__demo.php';

const COLOR_SUPPORT_LEVELS = [NO_COLOR_TERMINAL, COLOR_TERMINAL, COLOR256_TERMINAL];
const ITER = 50;
const MESSAGES = [
    'mᚹä漢d字',
    'message',
    'computing',
];

$t = new Themes();
echo Cursor::hide();

$spinners = [
    ArrowSpinner::class,
    BallSpinner::class,
    BlockSpinner::class,
    BouncingBarSpinner::class,
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
    WeatherSpinner::class,
];

$arr = [
    ArrowSpinner::class,
    BallSpinner::class,
    BlockSpinner::class,
    BouncingBarSpinner::class,
    ClockSpinner::class,
    DiceSpinner::class,
    EarthSpinner::class,
    MoonSpinner::class,
    PercentSpinner::class,
    SectorsSpinner::class,
    SnakeSpinner::class,
    WeatherSpinner::class,
];


$color = (int)($argv[1] ?? COLOR256_TERMINAL);
if (!in_array($color, COLOR_SUPPORT_LEVELS, true)) {
    echo
        $t->error('  ERROR  ') . ' ' .
        $t->red(basename(__FILE__) . ': Unknown color support level ' . str_wrap($color,'[', ']')) .
        PHP_EOL;
    echo $t->dark('Supported levels: ');
    foreach (COLOR_SUPPORT_LEVELS as $level) {
        echo $t->dark((string)$level) . ' ';
    }
    echo PHP_EOL;
    echo $t->dark('Will use autodetect') . PHP_EOL;
    $color = null;
}
if (null !== $color) {
    echo $t->dark('Color mode: ') . strtolower(TERMINAL_COLOR_MODES[$color]) . PHP_EOL;
}
echo PHP_EOL;

echo $t->dark('Messages(picked randomly):') . PHP_EOL;
foreach (MESSAGES as $m) {
    echo $t->dark(str_wrap($m, '"')) . PHP_EOL;
}
echo PHP_EOL;
echo PHP_EOL;
echo Cursor::up();

$len = count(MESSAGES) - 1;

foreach ($spinners as $spinner) {
    echo Line::erase() . Cursor::absX() . $t->bold(brackets($spinner) . ' ');
    $message = MESSAGES[rnd($len)];
    if (in_array($spinner, $arr, true)) {
        $s = new Settings();
        if (rnd(4) > 2) {
            $s->setMessageSuffix(Defaults::ELLIPSIS);
        }
        $s->setMessage($message);
        showSpinners(new $spinner($s, null, $color), true);
        showSpinners(new $spinner(null, null, $color), true);
    }
    if ($spinner !== PercentSpinner::class) {
        showSpinners(new $spinner(null, null, $color));
    }
}
echo PHP_EOL;
echo PHP_EOL;


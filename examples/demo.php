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
use AlecRabbit\Spinner\DiceSpinner;
use AlecRabbit\Spinner\Dot8BitSpinner;
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
    0 => ArrowSpinner::class,
    1 => BallSpinner::class,
    2 => BlockSpinner::class,
    3 => BouncingBarSpinner::class,
    4 => CircleSpinner::class,
    5 => ClockSpinner::class,
    6 => DiceSpinner::class,
    7 => Dot8BitSpinner::class,
    8 => DotSpinner::class,
    9 => EarthSpinner::class,
    10 => MoonSpinner::class,
    11 => PercentSpinner::class,
    12 => SectorsSpinner::class,
    13 => SimpleSpinner::class,
    14 => SnakeSpinner::class,
    15 => TimeSpinner::class,
    16 => WeatherSpinner::class,
];

$arr = [
    ArrowSpinner::class,
    BallSpinner::class,
    BlockSpinner::class,
    BouncingBarSpinner::class,
    ClockSpinner::class,
    DiceSpinner::class,
    DotSpinner::class,
    EarthSpinner::class,
    MoonSpinner::class,
    PercentSpinner::class,
    SectorsSpinner::class,
    SnakeSpinner::class,
    WeatherSpinner::class,
];


$spinnerIdx = $argv[1] ?? null;
$color = (int)($argv[2] ?? COLOR256_TERMINAL);
if (!in_array($color, COLOR_SUPPORT_LEVELS, true)) {
    echo
        $t->error('  ERROR  ') . ' ' .
        $t->red(basename(__FILE__) . ': Unknown color support level ' . str_wrap($color, '[', ']')) .
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

if (null === $spinnerIdx) {
    foreach ($spinners as $spinner) {
        doDemo($t, $spinner, $len, $arr, $color);
    }
} elseif (array_key_exists($spinnerIdx = (int)$spinnerIdx, $spinners)) {
    doDemo($t, $spinners[$spinnerIdx], $len, $arr, $color);
} else {
    echo
        $t->error('  ERROR  ') . ' ' .
        $t->red(basename(__FILE__) . ': Unknown spinner index ' . str_wrap($spinnerIdx, '[', ']')) .
        PHP_EOL;
}
echo PHP_EOL;
echo PHP_EOL;

/**
 * @param Themes $t
 * @param string $spinnerClass
 * @param int $len
 * @param array $arr
 * @param null|int $color
 */
function doDemo(Themes $t, string $spinnerClass, int $len, array $arr, ?int $color): void
{
    echo Line::erase() . Cursor::absX() . $t->bold(brackets($spinnerClass) . ' ');
    $message = MESSAGES[rnd($len)];
    if (in_array($spinnerClass, $arr, true)) {
        $s = new Settings();
        if (rnd(4) > 2) {
            $s->setMessageSuffix(Defaults::ELLIPSIS);
        }
        $s->setMessage($message);
        showSpinners(new $spinnerClass($s, null, $color), true);
        showSpinners(new $spinnerClass(null, null, $color), true);
    }
    if ($spinnerClass !== PercentSpinner::class) {
        showSpinners(new $spinnerClass(null, null, $color));
    }
}


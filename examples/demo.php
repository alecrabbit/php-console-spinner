<?php

use AlecRabbit\ConsoleColour\Themes;
use AlecRabbit\Control\Cursor;
use AlecRabbit\Spinner\CircleSpinner;
use AlecRabbit\Spinner\ClockSpinner;
use AlecRabbit\Spinner\Contracts\SpinnerInterface;
use AlecRabbit\Spinner\Contracts\SpinnerSymbols;
use AlecRabbit\Spinner\Contracts\StylesInterface;
use AlecRabbit\Spinner\Core\Settings;
use AlecRabbit\Spinner\Core\Spinner;
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

const ITER = 50;
const MESSAGE = 'processing';
const MESSAGE2 = 'computing';

$theme = new Themes();
echo Cursor::hide(); //
echo PHP_EOL;
sleep(1);
$spinners = [
//    PercentSpinner::class,
//    SimpleSpinner::class,
//    Spinner::class,
    DotSpinner::class,
    SnakeSpinner::class,
    CircleSpinner::class,
    ClockSpinner::class,
    DiceSpinner::class,
    SectorsSpinner::class,
    MoonSpinner::class,
    ZodiacSpinner::class,
];

//showSpinners(
//    new Spinner(
//        (new Settings())
//            ->setInterval(0.25)
//            ->setSymbols(SpinnerSymbols::ARROWS)
//            ->setStyles([
//                StylesInterface::COLOR256_SPINNER_STYLES => StylesInterface::C256_RAINBOW,
//                StylesInterface::COLOR_SPINNER_STYLES => StylesInterface::C_LIGHT_CYAN,
//                StylesInterface::COLOR_MESSAGE_STYLES => StylesInterface::C_DARK,
//                StylesInterface::COLOR_PERCENT_STYLES => StylesInterface::C_DARK,
//            ])
//            ->setMessage('mes')
//            ->setSuffix(' ')
//    ), true);

foreach ($spinners as $spinner) {
    showSpinners(new $spinner(MESSAGE), true);
    showSpinners(new $spinner(), true);
    if ($spinner !== PercentSpinner::class) {
        showSpinners(new $spinner(MESSAGE2));
        showSpinners(new $spinner());
    }
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


<?php declare(strict_types=1);

use AlecRabbit\ConsoleColour\Themes;
use AlecRabbit\Control\Cursor;
use AlecRabbit\Spinner\ClockSpinner;
use AlecRabbit\Spinner\Core\AbstractSpinner;
use AlecRabbit\Spinner\MoonSpinner;
use AlecRabbit\Spinner\SimpleSpinner;
use AlecRabbit\Spinner\SnakeSpinner;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/__helper_functions.php';

/**
 * It's a very basic example just to show the concept
 */

const ITERATIONS = 100;
const MILLISECONDS = 80;
$microseconds = MILLISECONDS * 1000;

// Try other spinners(DON'TFORGET TO IMPORT :D):
// CircleSpinner::class
// ClockSpinner::class
// MoonSpinner::class
// SimpleSpinner::class
// SnakeSpinner::class
$spinnerClass = ClockSpinner::class;

$simulatedMessages = [
    0 => 'Initializing',
    3 => 'Starting',
    10 => 'Begin processing',
    12 => 'Gathering data',
    15 => 'Processing',
    30 => 'Processing',
    55 => 'Processing',
    74 => 'Processing',
    78 => 'Processing',
    80 => 'Still processing',
    88 => 'Still processing',
    90 => 'Almost there',
    95 => 'Be patient',
];
echo Cursor::hide();
/** @var AbstractSpinner $s */
$s = new $spinnerClass();
$theme = new Themes(); // for colored output if supported

echo $theme->comment('Long running task example... (Inline Spinner)') . PHP_EOL;
$s->inline(true);
//echo $s->begin(); // Optional, begin() is just an alias for spin()
for ($i = 0; $i < ITERATIONS; $i++) {
    usleep($microseconds);
    if (\array_key_exists($i, $simulatedMessages)) {
        // It's your job to get and echo erase sequence when needed
        echo $s->erase();
        echo PHP_EOL;
        echo $theme->none($simulatedMessages[$i] . '...');
    }
    // It's your job to echo spin() with approx. equal intervals of 80-100ms
    // (for comfortable animation only)
    echo $s->spin($i / ITERATIONS);  // You can pass percentage to spin() method (float from 0 to 1)
}
echo $s->end();
echo PHP_EOL;
echo $theme->none('Done!') . PHP_EOL;

echo PHP_EOL;
echo $theme->comment('Long running task example... (Spinner on the next line)') . PHP_EOL;
$s = new $spinnerClass('processing');

$s->inline(false);
echo PHP_EOL;
//echo $s->begin(); // Optional
for ($i = 0; $i < ITERATIONS; $i++) {
    usleep($microseconds);
    if (\array_key_exists($i, $simulatedMessages)) {
        // It's your job to echo erase sequence when needed
        echo $s->erase();
        echo $theme->none($simulatedMessages[$i] . '...');
        echo PHP_EOL;
    }
    // It's your job to echo spin() with approx. equal intervals of 80-100ms
    // (for comfortable animation only)
    echo $s->spin($i / ITERATIONS);
}
echo $s->end();
echo PHP_EOL;
echo $theme->none('Done!') . PHP_EOL;
//echo "\007"; // Bell just for fun
echo Cursor::show();

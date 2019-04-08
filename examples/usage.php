<?php declare(strict_types=1);

use AlecRabbit\ConsoleColour\Themes;
use AlecRabbit\Control\Cursor;
use AlecRabbit\Spinner\ClockSpinner;
use AlecRabbit\Spinner\MoonSpinner;
use AlecRabbit\Spinner\SimpleSpinner;
use AlecRabbit\Spinner\SnakeSpinner;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/__helper_functions.php';

/**
 * It's a very basic example just to show the concept
 */

const MILLISECONDS = 80;
$microseconds = MILLISECONDS * 1000;

$theme = new Themes();
// Try other spinners(DON'TFORGET TO IMPORT :D):
// CircleSpinner
// ClockSpinner
// MoonSpinner
// SimpleSpinner
// SnakeSpinner
// TrigramSpinner
$s = new SnakeSpinner();
$simulatedMessages = [
    0 => 'Initializing',
    10 => 'Starting',
    15 => 'Begin processing',
    45 => 'Processing',
    49 => 'Gathering data',
    51 => 'Processing',
    90 => 'Processing',
    100 => 'Processing',
    110 => 'Processing',
    120 => 'Still processing',
    150 => 'Still processing',
    170 => 'Almost there',
    190 => 'Be patient',
];
echo Cursor::hide();
echo $theme->comment('Long running task example... (Inline Spinner)') . PHP_EOL;
$s->inline(true);
//echo $s->begin(); // Optional, begin() is just an alias for spin()
for ($i = 0; $i < 200; $i++) {
    usleep($microseconds);
    if (\array_key_exists($i, $simulatedMessages)) {
        // It's your job to get and echo erase sequence when needed
        echo $s->erase();
        echo PHP_EOL;
        echo $theme->debug($simulatedMessages[$i] . '...');
    }
    // It's your job to echo spin() with approx. equal intervals of 80-100ms
    // (for comfortable animation only)
    echo $s->spin();
}
echo $s->end();
echo PHP_EOL;
echo $theme->debug('Done!') . PHP_EOL;

echo PHP_EOL;
echo $theme->comment('Long running task example... (Spinner on the next line)') . PHP_EOL;
$s->inline(false);
echo PHP_EOL;
//echo $s->begin(); // Optional
for ($i = 0; $i < 200; $i++) {
    usleep($microseconds);
    if (\array_key_exists($i, $simulatedMessages)) {
        echo $theme->debug($simulatedMessages[$i] . '...');
        echo PHP_EOL;
    }
    // It's your job to echo spin() with approx. equal intervals of 80-100ms
    // (for comfortable animation only)
    echo $s->spin();
}
echo $s->end();
echo PHP_EOL;
echo $theme->debug('Done!') . PHP_EOL;
//echo "\007"; // Bell just for fun
echo Cursor::show();

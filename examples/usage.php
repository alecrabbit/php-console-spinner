<?php declare(strict_types=1);

use AlecRabbit\ConsoleColour\Themes;
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
echo hideCursorSequence();
echo $theme->comment('Long running task example... (Inline Spinner)') . PHP_EOL;
$s->inline(true);
echo $s->begin();
for ($i = 0; $i < 200; $i++) {
    usleep($microseconds);
    if (\array_key_exists($i, $simulatedMessages)) {
        echo $s->erase(); // It's your job to get erase sequence when needed
        echo PHP_EOL;
        echo $theme->debug($simulatedMessages[$i] . '...');
    }
    echo $s->spin(); // It's your job to call spin() with approx. equal intervals of 80-100ms(comfortable animation)
}
echo $s->end();
echo PHP_EOL;
echo $theme->debug('Done!') . PHP_EOL;

echo PHP_EOL;
echo $theme->comment('Long running task example... (Spinner on the next line)') . PHP_EOL;
$s->inline(false);
echo PHP_EOL;
echo $s->begin();
for ($i = 0; $i < 200; $i++) {
    usleep($microseconds);
    if (\array_key_exists($i, $simulatedMessages)) {
        echo $theme->debug($simulatedMessages[$i] . '...');
        echo PHP_EOL;
    }
    echo $s->spin(); // It's your job to call spin() with approx. equal intervals of 80-100ms(comfortable animation)
}
echo $s->end();
echo PHP_EOL;
echo $theme->debug('Done!') . PHP_EOL;
//echo "\007"; // Bell just for fun
echo showCursorSequence();

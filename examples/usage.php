<?php declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use AlecRabbit\ConsoleColour\Themes;
use AlecRabbit\Control\Cursor;
use AlecRabbit\Spinner\ClockSpinner;
use AlecRabbit\Spinner\Core\AbstractSpinner;
use AlecRabbit\Spinner\SnakeSpinner;

/**
 * It's a very basic example just to show the concept
 */

const ITERATIONS = 100;
const MILLISECONDS = 80;
const MICROSECONDS = MILLISECONDS * 1000;
const SIMULATED_MESSAGES = [
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

//$microseconds = MILLISECONDS * 1000;

// Try different  spinners:
// CircleSpinner::class
// ClockSpinner::class
// MoonSpinner::class
// SimpleSpinner::class
// SnakeSpinner::class
// DON'T FORGET TO IMPORT!
$spinnerClass = SnakeSpinner::class;

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
$theme = new Themes(); // for colored output if supported

echo $theme->comment('Long running task example...') . PHP_EOL;

echo Cursor::hide();
display(new $spinnerClass(), $theme, true);
echo PHP_EOL;
display(new $spinnerClass('processing'), $theme, false);

echo Cursor::show();
echo "\007"; // Bell just for fun


// ************************ Functions ************************
/**
 * @param AbstractSpinner $s
 * @param Themes $theme
 * @param bool $inline
 */
function display(AbstractSpinner $s, Themes $theme, bool $inline): void
{
    echo $theme->lightCyan($inline ? 'Inline Spinner' : 'Spinner on the next line') . ':' . PHP_EOL;
    if (!$inline) {
        echo PHP_EOL;
    }

    $s->inline($inline);
    echo $s->begin(); // Optional, begin() is just an alias for spin()
    for ($i = 0; $i < ITERATIONS; $i++) {
        usleep(MICROSECONDS);
        if (\array_key_exists($i, SIMULATED_MESSAGES)) {
            // It's your job to get and echo erase sequence when needed
            echo $s->erase();
            if ($inline) {
                echo PHP_EOL; // for inline mode
            }
            echo $theme->none(SIMULATED_MESSAGES[$i] . '...');
            if (!$inline) {
                echo PHP_EOL;
            }
        }
        // It's your job to echo spin() with approx. equal intervals of 80-100ms
        // (for comfortable animation only)
        echo $s->spin($i / ITERATIONS);  // You can pass percentage to spin() method (float from 0 to 1)
    }
    echo $s->end();
    if (!$inline) {
        echo PHP_EOL;
    }
    echo $theme->none('Done!') . PHP_EOL;
}


//echo PHP_EOL;
//echo $theme->comment('Long running task example... (Spinner on the next line)') . PHP_EOL;
//$s = new $spinnerClass('processing');
//
//$s->inline(false);
//echo PHP_EOL;
////echo $s->begin(); // Optional
//for ($i = 0; $i < ITERATIONS; $i++) {
//    usleep($microseconds);
//    if (\array_key_exists($i, $simulatedMessages)) {
//        // It's your job to echo erase sequence when needed
//        echo $s->erase();
//        echo $theme->none($simulatedMessages[$i] . '...');
//        echo PHP_EOL;
//    }
//    // It's your job to echo spin() with approx. equal intervals of 80-100ms
//    // (for comfortable animation only)
//    echo $s->spin($i / ITERATIONS);
//}
//echo $s->end();
//echo PHP_EOL;
//echo $theme->none('Done!') . PHP_EOL;


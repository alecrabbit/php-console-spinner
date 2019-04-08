<?php declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use AlecRabbit\ConsoleColour\Themes;
use AlecRabbit\Control\Cursor;
use AlecRabbit\Spinner\Core\AbstractSpinner;
use AlecRabbit\Spinner\SnakeSpinner;

/**
 * It's a very basic example just to show the concept
 */

const ITERATIONS = 300; // Play with this value 100..500
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

//// Try different  spinners:
// CircleSpinner::class
// ClockSpinner::class
// MoonSpinner::class
// SimpleSpinner::class
// SnakeSpinner::class
// DON'T FORGET TO IMPORT!
$spinnerClass = SnakeSpinner::class;

$theme = new Themes(); // for colored output if supported

echo $theme->comment('Long running task example...') . PHP_EOL;
echo $theme->dark('Using spinner: ') . $spinnerClass . PHP_EOL;

echo Cursor::hide();

display(
    new $spinnerClass(),
    $theme,
    true,
    'Inline Spinner(No custom message):'
);

display(
    new $spinnerClass(),
    $theme,
    false,
    'Spinner on the next line(No custom message):' . PHP_EOL
);

display(
    new $spinnerClass('processing'),
    $theme,
    false,
    'Spinner on the next line(With custom message "processing"):' . PHP_EOL
);

echo Cursor::show();

echo "\007Bell!" . PHP_EOL; // just for fun

// ************************ Functions ************************
/**
 * @param AbstractSpinner $s
 * @param Themes $theme
 * @param bool $inline
 * @param string $message
 */
function display(AbstractSpinner $s, Themes $theme, bool $inline, string $message): void
{
    echo $theme->lightCyan('Example: ' . $message) . PHP_EOL;
    $simulatedMessages = getSimulatedMessages();

    $s->inline($inline);
    echo $s->begin(); // Optional, begin() is just an alias for spin()
    for ($i = 0; $i < ITERATIONS; $i++) {
        usleep(MICROSECONDS);
        if (\array_key_exists($i, $simulatedMessages)) {
            // It's your job to get and echo erase sequence when needed
            echo $s->erase();
            if ($inline) {
                echo PHP_EOL; // for inline mode
            }
            echo $theme->none($simulatedMessages[$i] . '...');
            if (!$inline) {
                echo PHP_EOL;
            }
        }
        // It's your job to echo spin() with approx. equal intervals of 80-100ms
        // (for comfortable animation only)
        echo $s->spin($i / ITERATIONS);  // You can pass percentage to spin() method (float from 0 to 1)
    }
    echo $s->end();
    if ($inline) {
        echo PHP_EOL;
    }
    echo $theme->none('Done!') . PHP_EOL . PHP_EOL;
}

/**
 * @return array
 */
function getSimulatedMessages(): array
{
    $c = ITERATIONS / 100;
    $simulated = [];
    foreach (SIMULATED_MESSAGES as $key => $message) {
        $simulated[(int)$key * $c] = $message;
    }
    return $simulated;
}

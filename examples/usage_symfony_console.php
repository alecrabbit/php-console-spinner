<?php declare(strict_types=1);

//require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../tests/bootstrap.php';
// Please note helpers are used
require_once __DIR__ . '/__helper_functions.php';

use AlecRabbit\Cli\Tools\Cursor;
use AlecRabbit\ConsoleColour\Themes;
use AlecRabbit\Spinner\Core\Adapters\SymfonyOutputAdapter;
use AlecRabbit\Spinner\SnakeSpinner;
use Symfony\Component\Console\Output\ConsoleOutput;

const ITERATIONS = 100; // Play with this value 100..500
const MESSAGES = [
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

$spinnerClass = SnakeSpinner::class; // DON'T FORGET TO IMPORT! :)

$theme = new Themes(); // for colored output if supported

echo $theme->comment('Long running task example...') . PHP_EOL;

echo Cursor::hide();
echo PHP_EOL;

$message = 'computing';

echo $theme->dark('Using spinner: ') . $spinnerClass . PHP_EOL;
echo PHP_EOL;

display(
    new $spinnerClass(),
    $theme,
    true,
    ['Inline Spinner', '(With percentage, No message)']
);

$output = new SymfonyOutputAdapter(new ConsoleOutput());
display(
    new $spinnerClass($message, $output),
    $theme,
    false,
    ['Next Line Spinner', '(With percentage, With message)'],
    $output
);


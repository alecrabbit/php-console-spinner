<?php /** @noinspection PhpComposerExtensionStubsInspection */
declare(strict_types=1);

//require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../tests/bootstrap.php';

use AlecRabbit\ConsoleColour\Contracts\Styles;
use AlecRabbit\ConsoleColour\Themes;
use AlecRabbit\Control\Cursor;
use AlecRabbit\Spinner\Core\Contracts\StylesInterface;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\MoonSpinner;
use AlecRabbit\Spinner\SnakeSpinner;

/**
 * It's a very basic example just to show the concept
 */

const ITERATIONS = 100; // Play with this value 100..500
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

$spinnerClass = MoonSpinner::class; // DON'T FORGET TO IMPORT! :)

$theme = new Themes(); // for colored output if supported

echo $theme->comment('Long running task example...') . PHP_EOL;
echo $theme->dark('Using spinner: ') . $spinnerClass . PHP_EOL;

echo Cursor::hide();
echo PHP_EOL;

display(
    new class('computing') extends SnakeSpinner
    {
        protected const
            STYLES =
            [
                StylesInterface::MESSAGE_STYLES =>
                    [
                        StylesInterface::COLOR256 => StylesInterface::DISABLED,
                        StylesInterface::COLOR => [Styles::LIGHT_YELLOW],
                    ],
                StylesInterface::PERCENT_STYLES =>
                    [
                        StylesInterface::COLOR256 => StylesInterface::DISABLED,
                        StylesInterface::COLOR => [Styles::RED],
                    ],
            ];
    },
    $theme,
    false,
    'Custom SnakeSpinner on the next line(With custom styled percentage and custom styled message "computing"):' . PHP_EOL
);

display(
    new $spinnerClass(),
    $theme,
    true,
    'Inline Spinner(With percentage, No custom message):'
);

display(
    new $spinnerClass(),
    $theme,
    false,
    'Spinner on the next line(With percentage, No custom message):' . PHP_EOL
);

display(
    new $spinnerClass('processing'),
    $theme,
    false,
    'Spinner on the next line(With percentage, With custom message "processing"):' . PHP_EOL
);


running(
    new $spinnerClass(),
    $theme);

//echo "\007Bell!" . PHP_EOL; // just for fun

// ************************ Functions ************************
/**
 * @param Spinner $s
 * @param Themes $theme
 */
function running(Spinner $s, Themes $theme): void
{
    echo $theme->cyan('Example: Entering long running state... ') . PHP_EOL;
    echo $theme->warning('Use Ctrl + C to exit.') . PHP_EOL;
    echo PHP_EOL;
    $microseconds = (int)($s->interval() * 1000000);
    $run = true;
    pcntl_signal(SIGINT, static function () use (&$run) {
        $run = false;
    });
    echo $s->begin(); // Optional, begin() does same as spin() but also Cursor::hide(),
    while ($run) {
        usleep($microseconds);
        pcntl_signal_dispatch();
        echo $s->spin();
    }
    echo $s->end();
    echo PHP_EOL;
}

/**
 * @param Spinner $s
 * @param Themes $theme
 * @param bool $inline
 * @param string $message
 */
function display(Spinner $s, Themes $theme, bool $inline, string $message): void
{
    echo $theme->lightCyan('Example: ' . $message) . PHP_EOL;
    $simulatedMessages = getSimulatedMessages();

    $s->inline($inline);
    $microseconds = (int)($s->interval() * 1000000);
    echo $s->begin(); // Optional, begin() does same as spin() but also Cursor::hide(),
    for ($i = 0; $i < ITERATIONS; $i++) {
        usleep($microseconds);
        if (array_key_exists($i, $simulatedMessages)) {
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

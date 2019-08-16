<?php declare(strict_types=1);

//require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../tests/bootstrap.php';
// Please note helpers are used
require_once __DIR__ . '/__include/__helper_functions.php';

use AlecRabbit\Cli\Tools\Cursor;
use AlecRabbit\ConsoleColour\Contracts\Styles;
use AlecRabbit\ConsoleColour\Themes;
use AlecRabbit\Spinner\ArrowSpinner;
use AlecRabbit\Spinner\Core\Contracts\StylesInterface;
use AlecRabbit\Spinner\Core\Contracts\Frames;
use AlecRabbit\Spinner\Core\Settings;
use AlecRabbit\Spinner\PercentSpinner;
use AlecRabbit\Spinner\SnakeSpinner;

const ITERATIONS = 200; // Play with this value 100..500

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

$message = 'Working';
display(
    new class($message) extends ArrowSpinner
    {
        protected const
            STYLES =
            [
                StylesInterface::MESSAGE_STYLES =>
                    [
                        StylesInterface::COLOR256 => StylesInterface::DISABLED,
                        StylesInterface::COLOR => [Styles::LIGHT_BLUE],
                    ],
                StylesInterface::PERCENT_STYLES =>
                    [
                        StylesInterface::COLOR256 => StylesInterface::C256_BG_YELLOW_WHITE,
                        StylesInterface::COLOR => [Styles::RED],
                    ],
            ];
    },
    $theme,
    false,
    [
        'Extended inline ArrowSpinner.',
        '(With styled process messages and styled percentage)',
        '',
    ],
    null,
    true
);
$settings = new Settings();

$settings
    ->setSymbols(Frames::BALL_VARIANT_0)
    ->setMessage(' ')
    ->setMessageSuffix(' ')
    ->setStyles([
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
    ]);

display_new(
    new class($settings) extends ArrowSpinner
    {
    },
    $theme,
    false,
    [
        'Extended ArrowSpinner on the next line.',
        '(With styled message "' . $message . '" and styled percentage)',
        '',
    ]
);

echo $theme->dark('Using spinner: ') . $spinnerClass . PHP_EOL;
echo PHP_EOL;

display(
    new PercentSpinner(),
    $theme,
    true,
    ['Inline Spinner', '(With percentage, No message)']
);

display(
    new $spinnerClass(),
    $theme,
    false,
    ['Spinner on the next line', '(With percentage, No message)', '']
);

$message = 'processing';
display(
    new $spinnerClass($message),
    $theme,
    false,
    ['Spinner on the next line', '(With percentage and message "' . $message . '")', '']
);


longRun(
    new $spinnerClass(),
    $theme);

//echo "\007Bell!" . PHP_EOL; // just for fun
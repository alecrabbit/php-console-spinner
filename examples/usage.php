<?php declare(strict_types=1);

/**
 * This example is intended to show how output of your app may look like
 * and is NOT a code example. Although you can use it as such.
 */

//require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../tests/bootstrap.php';
// Please note helpers are used
require_once __DIR__ . '/__include/__helper_functions.php';

use AlecRabbit\Cli\Tools\Cursor;
use AlecRabbit\ConsoleColour\Contracts\Styles;
use AlecRabbit\ConsoleColour\Themes;
use AlecRabbit\Spinner\ArrowSpinner;
use AlecRabbit\Spinner\Core\Contracts\StylesInterface;
use AlecRabbit\Spinner\LineSpinner;
use AlecRabbit\Spinner\SnakeSpinner;

const ITERATIONS = 100; // Play with this value 100..500

//// Try different  spinners:
// CircleSpinner::class
// ClockSpinner::class
// MoonSpinner::class
// SimpleSpinner::class
// SnakeSpinner::class

$spinnerClass = LineSpinner::class; // DON'T FORGET TO IMPORT! :)

$themes = new Themes(); // for colored output if supported

echo $themes->comment('Long running task example...') . PHP_EOL;

//echo $themes->dark('Using spinner: ') . $spinnerClass . PHP_EOL;
//echo PHP_EOL;
//
//display(
//    new $spinnerClass(),
//    $theme,
//    true,
//    ['Inline Spinner', '(With percentage, No message)']
//);
//
//display(
//    new $spinnerClass(),
//    $theme,
//    false,
//    ['Spinner on the next line', '(With percentage, No message)', '']
//);
//
//$message = 'processing';
//display(
//    new $spinnerClass($message),
//    $theme,
//    false,
//    ['Spinner on the next line', '(With percentage and message "' . $message . '")', '']
//);

display(
    new class(' ') extends ArrowSpinner
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
    $themes,
    true,
    [
        'Extended SnakeSpinner on the next line.',
        '(With styled messages and styled percentage)',
        '',
    ],
    null,
    true
);

$message = 'computing';


display(
    new class($message) extends SnakeSpinner
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
    $themes,
    false,
    [
        'Extended SnakeSpinner on the next line.',
        '(With styled message "' . $message . '" and styled percentage)',
        '',
    ]
);

longRun(
    new $spinnerClass(),
    $themes);

//echo "\007Bell!" . PHP_EOL; // just for fun
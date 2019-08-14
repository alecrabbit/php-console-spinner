<?php declare(strict_types=1);

//require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../tests/bootstrap.php';
// Please note helpers are used
require_once __DIR__ . '/__include/__helper_functions.php';

use AlecRabbit\Cli\Tools\Cursor;
use AlecRabbit\ConsoleColour\Contracts\Styles;
use AlecRabbit\ConsoleColour\Themes;
use AlecRabbit\Spinner\Core\Contracts\Symbols;
use AlecRabbit\Spinner\Core\Contracts\StylesInterface;
use AlecRabbit\Spinner\MoonSpinner;

const ITERATIONS = 200; // Play with this value 100..500

//// Try different  spinners:
// CircleSpinner::class
// ClockSpinner::class
// MoonSpinner::class
// SimpleSpinner::class
// SnakeSpinner::class

$spinnerClass = MoonSpinner::class; // DON'T FORGET TO IMPORT! :)

$themes = new Themes(); // for colored output if supported

echo $themes->comment('Long running task example...') . PHP_EOL;

$message = 'mᚹä漢d字'; // Random characters
$settings =
    (new \AlecRabbit\Spinner\Core\Settings())
        ->setSymbols(Symbols::BALL_VARIANT_0)
        ->setStyles(
            [
                StylesInterface::MESSAGE_STYLES =>
                    [
                        StylesInterface::COLOR256 => StylesInterface::DISABLED,
                        StylesInterface::COLOR => [Styles::LIGHT_YELLOW],
                    ],
                StylesInterface::PERCENT_STYLES =>
                    [
                        StylesInterface::COLOR256 => StylesInterface::C256_RAINBOW,
                        StylesInterface::COLOR => [Styles::RED],
                    ],
            ]
        )
        ->setMessage($message, 8);

display(
    new MoonSpinner($settings), // MoonSpinner overridden by $settings
    $themes,
    true,
    [
        'Overridden MoonSpinner on the next line.',
        '(With styled message "' . $message . '" and styled percentage)',
        '',
    ]
);
//echo "\007Bell!" . PHP_EOL; // just for fun
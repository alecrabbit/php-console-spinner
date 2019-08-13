<?php declare(strict_types=1);

//require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../tests/bootstrap.php';
// Please note helpers are used
require_once __DIR__ . '/__include/__helper_functions.php';

use AlecRabbit\Cli\Tools\Cursor;
use AlecRabbit\ConsoleColour\Contracts\Styles;
use AlecRabbit\ConsoleColour\Themes;
use AlecRabbit\Spinner\ArrowSpinner;
use AlecRabbit\Spinner\BallSpinner;
use AlecRabbit\Spinner\Core\Contracts\StylesInterface;
use AlecRabbit\Spinner\MoonSpinner;
use AlecRabbit\Spinner\PercentSpinner;
use AlecRabbit\Spinner\SnakeSpinner;

const ITERATIONS = 200; // Play with this value 100..500

//// Try different  spinners:
// CircleSpinner::class
// ClockSpinner::class
// MoonSpinner::class
// SimpleSpinner::class
// SnakeSpinner::class

$spinnerClass = MoonSpinner::class; // DON'T FORGET TO IMPORT! :)

$theme = new Themes(); // for colored output if supported

echo $theme->comment('Long running task example...') . PHP_EOL;

echo Cursor::hide();
echo PHP_EOL;

$message = 'ᚹädm漢字';
//$message = 'prcessing';
$settings = (new \AlecRabbit\Spinner\Core\Settings())->setMessage($message, 3);

display(
    new MoonSpinner($settings),
    $theme,
    true,
    [
        'Extended SnakeSpinner on the next line.',
        '(With styled message "' . $message . '" and styled percentage)',
        '',
    ]
);
//echo "\007Bell!" . PHP_EOL; // just for fun
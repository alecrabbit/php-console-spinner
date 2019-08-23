<?php /** @noinspection PhpComposerExtensionStubsInspection */
declare(strict_types=1);

if (!extension_loaded('pcntl')) {
    echo 'This example requires pcntl extension.' . PHP_EOL;
    exit(1);
}

//require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../tests/bootstrap.php';

use AlecRabbit\ConsoleColour\Themes;
use AlecRabbit\Spinner\SnakeSpinner;
use React\EventLoop\Factory;

// coloring output
$t = new Themes();
echo $t->dark('Use CTRL+C to exit.'), PHP_EOL;

$loop = Factory::create();

// Add SIGINT signal handler
$loop->addSignal(
    SIGINT,
    $func = static function ($signal) use ($loop, $t, &$func) {
        echo PHP_EOL, $t->dark('Exiting... (CTRL+C to force)'), PHP_EOL;
        $loop->removeSignal(SIGINT, $func);
        $loop->stop();
    }
);


$progress = null;
$index = 0;
$message = '  ';
$messages = [
    0 => 'Initializing',
    3 => 'Starting',
    10 => 'Begin processing',
    12 => 'Gathering data',
    14 => 'Processing',
    74 => 'Processing',
    78 => 'Processing',
    80 => 'Still processing',
    88 => 'Still processing',
    90 => 'Almost there',
    95 => 'Be patient',

];
$s = new SnakeSpinner($message);

// Add periodic timer to redraw our spinner
$loop->addPeriodicTimer($s->interval(), static function () use ($s, &$progress, &$message) {
    $s->spin($progress / 100, $message);
});

// Add periodic timer to increment $progress
$loop->addPeriodicTimer(0.2, static function () use ($loop, $s, &$progress) {
    if (null === $progress) {
        $progress = 0;
    }
    if (++$progress > 100) {
        $loop->stop();
    }
});

$loop->addPeriodicTimer(0.3, static function () use ($loop, $s, &$index, &$message, &$messages) {
    if (\array_key_exists($index, $messages)) {
        $message = $messages[$index];
    }
    $index++;
});

$s->begin(); // Hides cursor and write first frame to output

// Starting the loop
$loop->run();

$s->end(); // Cleaning up

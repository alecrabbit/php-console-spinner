<?php /** @noinspection PhpComposerExtensionStubsInspection */
declare(strict_types=1);

if (!extension_loaded('pcntl')) {
    echo 'This example requires pcntl extension.' . PHP_EOL;
    exit(1);
}

//require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../tests/bootstrap.php';

use AlecRabbit\ConsoleColour\Contracts\BG;
use AlecRabbit\ConsoleColour\Contracts\Color;
use AlecRabbit\ConsoleColour\Contracts\Effect;
use AlecRabbit\ConsoleColour\Themes;
use AlecRabbit\Spinner\ArrowSpinner;
use AlecRabbit\Spinner\Core\Contracts\Juggler;
use AlecRabbit\Spinner\Core\Contracts\Styles;
use AlecRabbit\Spinner\Settings\Settings;
use React\EventLoop\Factory;
use const AlecRabbit\COLOR_TERMINAL;

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
$messages = [
    0 => 'Initializing',
    3 => 'Starting',
//    4 => "\e[0mOverride message \e[93mcoloring\e[0m by \e[1mown styles",
    4 => "\e[0mOverride message \e[38;5;211;48;5;237mcoloring\e[0m by \e[1mown styles",
//    4 => 'Override message coloring by own styles',
    10 => 'Begin processing ang this message continues further',
    14 => 'Gathering data',
    16 => 'Processing',
    25 => null,
    44 => 'Processing',
    78 => 'Processing',
    82 => "\e[0m\e[91mStill processing",
//    82 => 'Still processing',
    90 => "\e[0m\e[93mBe patient",
//    90 => 'Be patient',
    95 => "\e[0m\e[33mAlmost there",
//    95 => 'Almost there',
    100 => "\e[0m\e[92mDone",
//    100 => 'Done',
];

//$s = new BlockSpinner();
//$s = new ClockSpinner((new Settings())->setInterval(1)); // Slow ClockSpinner example
$settings = new Settings();
$s =
    new ArrowSpinner(       // Slow BlockSpinner with custom styles example
        $settings
            ->setStyles(
                [
                    Juggler::FRAMES_STYLES =>
                        [
                            Juggler::COLOR256 => Styles::C256_BG_RAINBOW,
                            Juggler::COLOR => [[Color::WHITE, BG::RED, Effect::BOLD, Effect::ITALIC]],
                            Juggler::FORMAT => ' %s ',
                            Juggler::SPACER => '',
                        ],
                    Juggler::MESSAGE_STYLES =>
                        [
                            Juggler::COLOR => [[Color::YELLOW, BG::BLUE, Effect::BOLD,]],
                            Juggler::FORMAT => '%s',
                            Juggler::SPACER => '',
                        ],
                    Juggler::PROGRESS_STYLES =>
                        [
                            Juggler::COLOR => [[Color::WHITE, BG::RED, Effect::BOLD, Effect::ITALIC]],
                            Juggler::FORMAT => ' %s ',
                            Juggler::SPACER => '',
                        ],
                ]
            ),
        null,
        COLOR_TERMINAL
    );

// Add periodic timer to redraw our spinner
$loop->addPeriodicTimer($s->interval(), static function () use ($s) {
    $s->spin();
});

// Add periodic timer to randomly echo timestamps - simulating messages from your app
$loop->addPeriodicTimer(1, static function () use ($s, $t) {
    if (random_int(0, 1000) > 570) {
        $s->erase();
        echo PHP_EOL . $t->dark(date('H:i:s')) . ' Simulated message.';
        $s->spin(); // optional
    }
});

// Add periodic timer to increment $progress
$loop->addPeriodicTimer(0.5, static function () use ($s, $loop, &$progress) {
    if (null === $progress) {
        $progress = 0;
    }
    if (++$progress > 100) {
        $loop->stop();
    }
    if (70 <= $progress && $progress <= 79) {
        $s->progress(null);
    } else {
        $s->progress($progress / 100);
    }
});

$loop->addPeriodicTimer(0.3, static function () use ($s, &$progress, &$messages) {
    $progress = $progress ?? 0;
    if (null !== $progress && \array_key_exists($progress, $messages)) {
        $s->message($messages[$progress]);
    }
});

$s->begin(); // Hides cursor and write first frame to output

// Starting the loop
$loop->run();

$s->end(); // Cleaning up

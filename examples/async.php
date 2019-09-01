<?php /** @noinspection PhpComposerExtensionStubsInspection */
declare(strict_types=1);

/*
 * This demo shows how your app may look like.
 * It can print out your data and same time change spinner messages.
 *
 * Please ignore code quality :)
 */

//require_once __DIR__ . '/../vendor/autoload.php';         // Uncomment this if you didn't clone this repository
require_once __DIR__ . '/../tests/bootstrap.php';           // and comment this one

require_once __DIR__ . '/__include/__ext_check.php';

__check_for_extension('pcntl', 'ext-pcntl is required', __FILE__);

use AlecRabbit\Accessories\MemoryUsage;
use AlecRabbit\Accessories\Pretty;
use AlecRabbit\ConsoleColour\Contracts\BG;
use AlecRabbit\ConsoleColour\Contracts\Color;
use AlecRabbit\ConsoleColour\Contracts\Effect;
use AlecRabbit\ConsoleColour\Themes;
use AlecRabbit\Spinner\Core\Contracts\Juggler;
use AlecRabbit\Spinner\Core\Contracts\Styles;
use AlecRabbit\Spinner\DiceSpinner;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;
use AlecRabbit\Spinner\Settings\Settings;
use AlecRabbit\Spinner\SnakeSpinner;
use AlecRabbit\Spinner\TimeSpinner;
use React\EventLoop\Factory;
use function AlecRabbit\Helpers\swap;
use const AlecRabbit\COLOR_TERMINAL;

// coloring output
$t = new Themes();

// Welcoming message
echo $t->lightCyan('Async spinner demo.') . PHP_EOL;
// Show initial memory usage
memory($t);
echo PHP_EOL;

// For fake data
$faker = Faker\Factory::create();

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
    6 => 'Long message: this message continues further',
    9 => 'Gathering data',
    16 => 'Processing',
    25 => null,
    44 => 'Processing',
    79 => "\e[0mOverride \e[1mmessage coloring\e[0m by \e[38;5;211;48;5;237mown styles",
    82 => "\e[0m\e[91mStill processing",
    90 => "\e[0m\e[93mBe patient",
    95 => "\e[0m\e[33mAlmost there",
    100 => "\e[0m\e[92mDone",
];

//$s = new TimeSpinner();
//$s = new ClockSpinner((new Settings())->setInterval(1)); // Slow ClockSpinner example
$settings = new Settings();
$s =
    new SnakeSpinner(       // Slow BlockSpinner with custom styles example
        $settings
//            ->setMessageSuffix(Defaults::DOTS_SUFFIX)
//            ->setStyles(
//                [
//                    Juggler::FRAMES_STYLES =>
//                        [
//                            Juggler::COLOR256 => Styles::C256_BG_RAINBOW,
//                            Juggler::COLOR => [[Color::WHITE, BG::RED, Effect::BOLD,]],
//                            Juggler::FORMAT => ' %s  ',
//                            Juggler::SPACER => '',
//                        ],
//                    Juggler::MESSAGE_STYLES =>
//                        [
//                            Juggler::COLOR => [[Color::YELLOW, BG::RED, Effect::BOLD,]],
//                            Juggler::FORMAT => '%s ',
//                            Juggler::SPACER => '',
//                        ],
//                    Juggler::PROGRESS_STYLES =>
//                        [
//                            Juggler::COLOR => [[Color::WHITE, BG::RED, Effect::BOLD, Effect::ITALIC]],
//                            Juggler::FORMAT => '%s ',
//                            Juggler::SPACER => '',
//                        ],
//                ]
//            ),
//        null,
//        COLOR_TERMINAL
    );

$inline = false;
$s->inline($inline);
// Add periodic timer to redraw our spinner
$loop->addPeriodicTimer($s->interval(), static function () use ($s) {
    $s->spin();
});

// Add periodic timer to simulate messages from your app
$loop->addPeriodicTimer(0.2, static function () use ($s, $t, $inline, $faker, &$progress) {

    if ((16 < $progress) && (random_int(0, 100) > 50)) {
        $s->erase();
        simulateMessage($inline, $t, $faker);
        $s->last(); // optional, for smooth animation
    }
});

// Add periodic timer to print out memory usage - examples of messages form other part of app
$loop->addPeriodicTimer(8, static function () use ($s, $t, $inline, $faker, &$progress) {
    if (16 < $progress) {
        $s->erase();
        memory($t);
        $s->last(); // optional
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

echo $t->dark('Use CTRL+C to exit.') . PHP_EOL . PHP_EOL;

echo 'Searching for accepted payments...' . PHP_EOL;

$s->begin(); // Hides cursor and write first frame to output

// Starting the loop
$loop->run();

$s->end(); // Cleaning up

/**
 * @param bool $inline
 * @param Themes $t
 * @param $faker
 * @throws Exception
 */
function simulateMessage(bool $inline, Themes $t, $faker): void
{
    $header = '';
    $footer = PHP_EOL;
    if ($inline) {
        swap($header, $footer);
    }
    echo $header .
//        $t->dark(date('H:i:s')) .
        ' ' .
        $t->italic(str_pad($faker->company(), 35)) . ' ' .
        $t->bold(amount()) . ' ' .
        $t->dark($faker->iban()). ' ' .
        $footer;
}

/**
 * @param Themes $t
 */
function memory(Themes $t): void
{
    echo $t->dark((string)MemoryUsage::getReport()) . PHP_EOL;
}

/**
 * @return string
 * @throws Exception
 */
function amount(): string
{
    return
        str_pad(
            number_format(random_int(1, 1000) * random_int(1, 1000) / 100, 2) . '$',
            10,
            Defaults::ONE_SPACE_SYMBOL,
            STR_PAD_LEFT
        );
}

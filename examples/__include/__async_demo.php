<?php declare(strict_types=1);

use AlecRabbit\Accessories\MemoryUsage;
use AlecRabbit\ConsoleColour\Contracts\BG;
use AlecRabbit\ConsoleColour\Contracts\Color;
use AlecRabbit\ConsoleColour\Contracts\Effect;
use AlecRabbit\ConsoleColour\Themes;
use AlecRabbit\Spinner\ClockSpinner;
use AlecRabbit\Spinner\Core\Contracts\Frames;
use AlecRabbit\Spinner\Core\Contracts\Juggler;
use AlecRabbit\Spinner\Core\Contracts\OutputInterface;
use AlecRabbit\Spinner\Core\Contracts\Styles;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\DiceSpinner;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;
use AlecRabbit\Spinner\Settings\Settings;
use AlecRabbit\Spinner\SnakeSpinner;
use AlecRabbit\Spinner\TimeSpinner;
use AlecRabbit\Spinner\WeatherSpinner;
use function AlecRabbit\Helpers\swap;
use const AlecRabbit\COLOR256_TERMINAL;
use const AlecRabbit\COLOR_TERMINAL;

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
    echo $header . ' ' .
        $t->italic(str_pad($faker->company(), 35)) . ' ' .
        $t->bold(amount()) . ' ' .
        $t->dark($faker->iban()) . ' ' .
        $footer;
}

/**
 * @param Themes $t
 * @param bool $inline
 * @param resource $stream
 */
function memory(Themes $t, bool $inline, $stream): void
{
    $header = '';
    $footer = PHP_EOL;
    if ($inline) {
        swap($header, $footer);
    }

    $stream->write($header . $t->dark(date('H:i:s ') . MemoryUsage::getReport()) . $footer);
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

/**
 * Creates and returns spinner
 *
 * @param int $variant
 * @param OutputInterface|null $output
 * @return Spinner
 */
function spinnerFactory(int $variant = 0, OutputInterface $output = null): Spinner
{
    $settings = new Settings();
    $settings->setJugglersOrder([Juggler::FRAMES, Juggler::PROGRESS, Juggler::MESSAGE]);
    $color = null;
    switch ($variant) {
        case 1:
            return
                new ClockSpinner(
                    $settings
                        ->setMessageSuffix(Defaults::ELLIPSIS)
                        ->setInterval(1),
                    $output,
                    $color
                );
            break;
        case 2:
            return
                new SnakeSpinner(
                    $settings
                        ->setStyles(
                            [
                                Juggler::FRAMES_STYLES =>
                                    [
                                        Juggler::COLOR256 => Styles::C256_BG_RAINBOW,
                                        Juggler::COLOR => [[Color::WHITE, BG::RED, Effect::BOLD,]],
                                        Juggler::FORMAT => ' %s  ',
                                        Juggler::SPACER => '',
                                    ],
                                Juggler::MESSAGE_STYLES =>
                                    [
                                        Juggler::COLOR => [[Color::YELLOW, BG::RED, Effect::BOLD,]],
                                        Juggler::FORMAT => '%s ',
                                        Juggler::SPACER => '',
                                    ],
                                Juggler::PROGRESS_STYLES =>
                                    [
                                        Juggler::COLOR => [[Color::WHITE, BG::RED, Effect::BOLD, Effect::ITALIC]],
                                        Juggler::FORMAT => '%s ',
                                        Juggler::SPACER => '',
                                    ],
                            ]
                        ),
                    $output,
                    COLOR_TERMINAL
                );
            break;
        case 3:
            return
                new DiceSpinner(null, $output, $color);
            break;
        case 4:
            return new TimeSpinner(null, $output, $color);
            break;
        case 5:
            return
                new SnakeSpinner(
                    $settings
                        ->setInterval(0.12)
                        ->setFrames(Frames::FEATHERED_ARROWS),
                    $output,
                    $color
                );
            break;
        case 6:
            return
                new SnakeSpinner(
                    $settings
                        ->setInterval(0.12)
                        ->setStyles(
                            [
                                Juggler::PROGRESS_STYLES =>
                                    [
                                        Juggler::FORMAT => '[%4s]',
                                    ],
                            ]
                        )
                        ->setFrames(Frames::DOTS_VARIANT_3),
                    $output,
                    $color
                );
            break;
        case 7:
            return new ClockSpinner($settings->setDoNotHideCursor(), $output, $color);
            break;
        case 8:
            return new WeatherSpinner(null, $output, $color);
            break;
        case 9:
            return
                new SnakeSpinner(
                    $settings
                        ->setInterval(0.08)
                        ->setFrames(Frames::SNAKE_VARIANT_3),
                    $output,
                    $color
                );
            break;
        default:
            return new SnakeSpinner($settings->setMessageSuffix(Defaults::ELLIPSIS), $output, $color);
            break;
    }
}

/**
 * @param int $colorSupport
 * @return array
 */
function messages(int $colorSupport): array
{
    if (0 < $colorSupport) {
        return [
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
    }
    return [
        0 => 'Initializing',
        3 => 'Starting',
        6 => 'Long message: this message continues further',
        9 => 'Gathering data',
        16 => 'Processing',
        25 => null,
        44 => 'Processing',
        79 => 'Override message coloring by own styles(but not now)',
        82 => 'Still processing',
        90 => 'Be patient',
        95 => 'Almost there',
        100 => 'Done',
    ];

}

function showHelpMessage($file, $argv): void
{
    if (\in_array('-h', $argv, true) || \in_array('--help', $argv, true)) {
        echo 'Usage:
    ' . basename($file) . ' [type] [inline]' . PHP_EOL . '
    type        spinner type int 0..5
    inline      enable inline mode int 1' . PHP_EOL;
        exit;
    }
}



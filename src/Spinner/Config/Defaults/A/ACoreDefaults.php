<?php

declare(strict_types=1);
// 10.03.23
namespace AlecRabbit\Spinner\Config\Defaults\A;

use AlecRabbit\Spinner\Config\Defaults\Contract\IClasses;
use AlecRabbit\Spinner\Config\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Config\Defaults\Contract\ITerminal;
use AlecRabbit\Spinner\Config\Defaults\Mixin\DefaultConst;
use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Loop\ReactLoopProbe;
use AlecRabbit\Spinner\Core\Loop\RevoltLoopProbe;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Core\Terminal\SymfonyTerminalProbe;
use AlecRabbit\Spinner\Factory\FrameFactory;

/** @internal */
abstract class ACoreDefaults implements IDefaults
{
    use DefaultConst;

    protected static int $millisecondsInterval;
    protected static float|int $shutdownDelay;
    protected static float|int $shutdownMaxDelay;
    protected static bool $isModeSynchronous;
    protected static bool $hideCursor;
    protected static string $messageOnFinalize;
    protected static string $messageOnExit;
    protected static string $messageOnInterrupt;
    protected static string $percentNumberFormat;
    protected static bool $createInitialized;
    protected static array $colorSupportLevels;
    protected static ?IPattern $mainStylePattern = null;
    protected static ?IPattern $mainCharPattern = null;
    protected static ?IFrame $mainLeadingSpacer = null;
    protected static ?IFrame $mainTrailingSpacer = null;
    protected static ?IFrame $defaultLeadingSpacer = null;
    protected static ?IFrame $defaultTrailingSpacer = null;
    protected static IClasses $classes;
    protected static ITerminal $terminal;
    protected static bool $autoStart;
    protected static bool $attachSignalHandlers;
    /**
     * @var resource
     */
    protected static $outputStream;
    protected static iterable $loopProbes;
    protected static iterable $terminalProbes;


    public function reset(): void
    {
        static::$outputStream = static::defaultOutputStream();
        static::$loopProbes = static::defaultLoopProbes();
        static::$terminalProbes = static::defaultTerminalProbes();
        static::$classes = static::getClassesInstance();
        static::$terminal = static::getTerminalInstance();

        static::$shutdownDelay = static::SHUTDOWN_DELAY;
        static::$shutdownMaxDelay = static::SHUTDOWN_MAX_DELAY;
        static::$messageOnFinalize = static::MESSAGE_ON_FINALIZE;
        static::$messageOnExit = static::MESSAGE_ON_EXIT;
        static::$messageOnInterrupt = static::MESSAGE_ON_INTERRUPT;
        static::$hideCursor = static::TERMINAL_HIDE_CURSOR;
        static::$colorSupportLevels = static::TERMINAL_COLOR_SUPPORT_LEVELS;
        static::$isModeSynchronous = static::SPINNER_MODE_IS_SYNCHRONOUS;
        static::$createInitialized = static::SPINNER_CREATE_INITIALIZED;
        static::$percentNumberFormat = static::PERCENT_NUMBER_FORMAT;
        static::$millisecondsInterval = static::INTERVAL_MS;
        static::$autoStart = static::AUTO_START;
        static::$attachSignalHandlers = static::ATTACH_SIGNAL_HANDLERS;

        static::$mainStylePattern = null;
        static::$mainCharPattern = null;
        static::$mainLeadingSpacer = null;
        static::$mainTrailingSpacer = null;

        static::$defaultLeadingSpacer = FrameFactory::createEmpty();
        static::$defaultTrailingSpacer = FrameFactory::createSpace();
    }

    /**
     * @return resource
     */
    protected static function defaultOutputStream()
    {
        return STDERR;
    }

    protected static function defaultLoopProbes(): iterable
    {
        // @codeCoverageIgnoreStart
        yield from [
            RevoltLoopProbe::class,
            ReactLoopProbe::class,
        ];
        // @codeCoverageIgnoreEnd
    }

    protected static function defaultTerminalProbes(): iterable
    {
        // @codeCoverageIgnoreStart
        yield from [
            SymfonyTerminalProbe::class,
        ];
        // @codeCoverageIgnoreEnd
    }

    protected static function getClassesInstance(): AClasses
    {
        return AClasses::getInstance();
    }

    protected static function getTerminalInstance(): ITerminal
    {
        return ATerminal::getInstance(static::$terminalProbes);
    }
}
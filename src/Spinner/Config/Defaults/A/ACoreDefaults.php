<?php
declare(strict_types=1);
// 10.03.23
namespace AlecRabbit\Spinner\Config\Defaults\A;

use AlecRabbit\Spinner\Config\Defaults\Contract\IClasses;
use AlecRabbit\Spinner\Config\Defaults\Contract\ITerminal;
use AlecRabbit\Spinner\Config\Defaults\Mixin\DefaultConst;
use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Loop\ReactLoopProbe;
use AlecRabbit\Spinner\Core\Loop\RevoltLoopProbe;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Core\Terminal\SymfonyTerminalProbe;
use AlecRabbit\Spinner\Factory\FrameFactory;

abstract class ACoreDefaults
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
        self::$outputStream = self::defaultOutputStream();
        self::$loopProbes = self::defaultLoopProbes();
        self::$terminalProbes = self::defaultTerminalProbes();
        self::$classes = self::getClassesInstance();
        self::$terminal = self::getTerminalInstance();

        self::$shutdownDelay = self::SHUTDOWN_DELAY;
        self::$shutdownMaxDelay = self::SHUTDOWN_MAX_DELAY;
        self::$messageOnFinalize = self::MESSAGE_ON_FINALIZE;
        self::$messageOnExit = self::MESSAGE_ON_EXIT;
        self::$messageOnInterrupt = self::MESSAGE_ON_INTERRUPT;
        self::$hideCursor = self::TERMINAL_HIDE_CURSOR;
        self::$colorSupportLevels = self::TERMINAL_COLOR_SUPPORT_LEVELS;
        self::$isModeSynchronous = self::SPINNER_MODE_IS_SYNCHRONOUS;
        self::$createInitialized = self::SPINNER_CREATE_INITIALIZED;
        self::$percentNumberFormat = self::PERCENT_NUMBER_FORMAT;
        self::$millisecondsInterval = self::INTERVAL_MS;
        self::$autoStart = self::AUTO_START;
        self::$attachSignalHandlers = self::ATTACH_SIGNAL_HANDLERS;

        self::$mainStylePattern = null;
        self::$mainCharPattern = null;
        self::$mainLeadingSpacer = null;
        self::$mainTrailingSpacer = null;

        self::$defaultLeadingSpacer = FrameFactory::createEmpty();
        self::$defaultTrailingSpacer = FrameFactory::createSpace();
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
        return ATerminal::getInstance(self::$terminalProbes);
    }
}
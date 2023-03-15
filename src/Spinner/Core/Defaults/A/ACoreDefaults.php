<?php

declare(strict_types=1);
// 10.03.23
namespace AlecRabbit\Spinner\Core\Defaults\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaultsClasses;
use AlecRabbit\Spinner\Core\Defaults\Mixin\DefaultsConst;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalProbe;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalSettings;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Helper\Asserter;

use function is_subclass_of;

abstract class ACoreDefaults implements IDefaults
{
    use DefaultsConst;

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
    protected static iterable $supportedColorModes;
    protected static ?IPattern $mainStylePattern = null;
    protected static ?IPattern $mainCharPattern = null;
    protected static ?IFrame $mainLeadingSpacer = null;
    protected static ?IFrame $mainTrailingSpacer = null;
    protected static ?IFrame $defaultLeadingSpacer = null;
    protected static ?IFrame $defaultTrailingSpacer = null;
    protected static IDefaultsClasses $classes;
    protected static ITerminalSettings $terminalSettings;
    protected static IDriverSettings $driverSettings;
    protected static bool $autoStart;
    protected static bool $attachSignalHandlers;
    /**
     * @var resource
     */
    protected static $outputStream;
    protected static iterable $loopProbes;
    protected static iterable $terminalProbes;
    private static iterable $registeredLoopProbes = [];
    private static iterable $registeredTerminalProbes = [];

    final protected function __construct()
    {
        $this->reset();
    }

    protected function reset(): void
    {
        static::$outputStream = static::defaultOutputStream();
        static::$loopProbes = static::defaultLoopProbes();
        static::$terminalProbes = static::defaultTerminalProbes();
        static::$classes = static::getClassesInstance();
        static::$terminalSettings = static::getTerminalSettingsInstance();
        static::$driverSettings = static::getDriverSettingsInstance();

        static::$shutdownDelay = static::SHUTDOWN_DELAY;
        static::$shutdownMaxDelay = static::SHUTDOWN_MAX_DELAY;
        static::$messageOnFinalize = static::MESSAGE_ON_FINALIZE;
        static::$messageOnExit = static::MESSAGE_ON_EXIT;
        static::$messageOnInterrupt = static::MESSAGE_ON_INTERRUPT;
        static::$hideCursor = static::TERMINAL_HIDE_CURSOR;
        static::$supportedColorModes = static::TERMINAL_COLOR_SUPPORT_MODES;
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
        yield from self::$registeredLoopProbes;
    }

    protected static function defaultTerminalProbes(): iterable
    {
        yield from self::$registeredTerminalProbes;
    }

    abstract protected static function getClassesInstance(): ADefaultsClasses;

    abstract protected static function getTerminalSettingsInstance(): ITerminalSettings;

    abstract protected static function getDriverSettingsInstance(): IDriverSettings;

    /**
     * @throws InvalidArgumentException
     */
    public static function registerProbe(string $class): void
    {
        Asserter::classExists($class, __METHOD__);

        if (is_subclass_of($class, ILoopProbe::class)) {
            static::registerLoopProbeClass($class);
            return;
        }
        if (is_subclass_of($class, ITerminalProbe::class)) {
            static::registerTerminalProbeClass($class);
            return;
        }
        throw new InvalidArgumentException(
            sprintf(
                'Unsupported probe class: %s. Supported: [%s].',
                $class,
                implode(
                    separator: ', ',
                    array: [
                        ILoopProbe::class,
                        ITerminalProbe::class
                    ],
                ),
            )
        );
    }

    /**
     * @throws InvalidArgumentException
     */
    protected static function registerLoopProbeClass(string $class): void
    {
        Asserter::isSubClass($class, ILoopProbe::class, __METHOD__);

        if (!in_array($class, iterator_to_array(self::$registeredLoopProbes), true)) {
            self::$registeredLoopProbes[] = $class;
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    protected static function registerTerminalProbeClass(string $class): void
    {
        Asserter::isSubClass($class, ITerminalProbe::class, __METHOD__);

        if (!in_array($class, iterator_to_array(self::$registeredTerminalProbes), true)) {
            self::$registeredTerminalProbes[] = $class;
        }
    }
}
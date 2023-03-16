<?php

declare(strict_types=1);
// 10.03.23
namespace AlecRabbit\Spinner\Core\Defaults\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaultsClasses;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\ITerminalSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Defaults\Mixin\DefaultsConst;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Core\RunMode;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalProbe;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Helper\Asserter;

use function is_subclass_of;

abstract class ACoreDefaults implements IDefaults
{
    use DefaultsConst;

    protected static bool $attachSignalHandlers;
    protected static bool $autoStartEnabled;
    protected static IDefaultsClasses $classes;
    protected static bool $createInitialized;
    protected static ?IFrame $defaultLeadingSpacer = null;
    protected static ?IFrame $defaultTrailingSpacer = null;
    protected static IDriverSettings $driverSettings;
    protected static bool $hideCursor;
    protected static bool $isModeSynchronous;
    protected static iterable $loopProbes;
    protected static ?IPattern $mainCharPattern = null;
    protected static ?IFrame $mainLeadingSpacer = null;
    protected static ?IPattern $mainStylePattern = null;
    protected static ?IFrame $mainTrailingSpacer = null;
    protected static string $messageOnExit;
    protected static string $messageOnFinalize;
    protected static string $messageOnInterrupt;
    protected static int $millisecondsInterval;
    protected static string $percentNumberFormat;
    protected static RunMode $runMode;
    protected static IWidgetSettings $rootWidgetSettings;
    protected static iterable $supportedColorModes;
    protected static ITerminalSettings $terminalSettings;
    protected static float|int $shutdownDelay;
    protected static float|int $shutdownMaxDelay;
    /**
     * @var resource
     */
    protected static $outputStream;
    protected static iterable $terminalProbes;
    protected static IWidgetSettings $widgetSettings;
    private static iterable $registeredLoopProbes = [];
    private static iterable $registeredTerminalProbes = [];

    final protected function __construct()
    {
        $this->reset();
    }

    protected function reset(): void
    {
        static::$classes = $this->getClassesInstance();
        static::$driverSettings = $this->createDriverSettings();
        static::$loopProbes = $this->defaultLoopProbes();
        static::$outputStream = $this->defaultOutputStream();
        static::$terminalProbes = $this->defaultTerminalProbes();
        static::$terminalSettings = $this->createTerminalSettings();
        static::$rootWidgetSettings = $this->createWidgetSettings();
        static::$widgetSettings = $this->createWidgetSettings();

        static::$attachSignalHandlers = static::ATTACH_SIGNAL_HANDLERS;
        static::$autoStartEnabled = static::AUTO_START;
        static::$createInitialized = static::SPINNER_CREATE_INITIALIZED;
        static::$hideCursor = static::TERMINAL_HIDE_CURSOR;
        static::$isModeSynchronous = static::SPINNER_MODE_IS_SYNCHRONOUS;
        static::$messageOnExit = static::MESSAGE_ON_EXIT;
        static::$messageOnFinalize = static::MESSAGE_ON_FINALIZE;
        static::$messageOnInterrupt = static::MESSAGE_ON_INTERRUPT;
        static::$millisecondsInterval = static::INTERVAL_MS;
        static::$percentNumberFormat = static::PERCENT_NUMBER_FORMAT;
        static::$runMode = static::RUN_MODE;
        static::$shutdownDelay = static::SHUTDOWN_DELAY;
        static::$shutdownMaxDelay = static::SHUTDOWN_MAX_DELAY;
        static::$supportedColorModes = static::TERMINAL_COLOR_SUPPORT_MODES;

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
    protected function defaultOutputStream()
    {
        return STDERR;
    }

    protected function defaultLoopProbes(): iterable
    {
        yield from self::$registeredLoopProbes;
    }

    protected function defaultTerminalProbes(): iterable
    {
        yield from self::$registeredTerminalProbes;
    }

    abstract protected function getClassesInstance(): IDefaultsClasses;

    abstract protected function createTerminalSettings(): ITerminalSettings;

    abstract protected function createDriverSettings(): IDriverSettings;

    abstract protected function createWidgetSettings(): IWidgetSettings;

    /**
     * @throws InvalidArgumentException
     */
    public static function registerProbeClass(string $class): void
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
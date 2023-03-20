<?php

declare(strict_types=1);
// 10.03.23

namespace AlecRabbit\Spinner\Core\Defaults\A;

use AlecRabbit\Spinner\Contract\Initialization;
use AlecRabbit\Spinner\Contract\IProbe;
use AlecRabbit\Spinner\Core\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaultsClasses;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\ITerminalSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Defaults\Mixin\DefaultsConst;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Core\RunMode;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalProbe;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Helper\Asserter;
use Traversable;

use function is_subclass_of;

abstract class ACoreDefaults implements IDefaults
{
    use DefaultsConst;

    protected static IDefaultsClasses $classes;
    protected static IDriverSettings $driverSettings;
    protected static ILoopSettings $loopSettings;
    protected static ITerminalSettings $terminalSettings;
    protected static IWidgetSettings $rootWidgetSettings;
    protected static IWidgetSettings $widgetSettings;

    protected static Initialization $initialization;
    protected static Traversable $loopProbes;
    protected static ?IPattern $charPattern = null;
    protected static ?IPattern $stylePattern = null;
    protected static string $messageOnExit;
    protected static string $messageOnFinalize;
    protected static string $messageOnInterrupt;
    protected static int $millisecondsInterval;
    protected static string $percentNumberFormat;
    protected static RunMode $runMode;
    protected static float|int $shutdownDelay;
    protected static float|int $shutdownMaxDelay;
    /**
     * @var resource
     */
    protected static $outputStream;
    protected static Traversable $terminalProbes;
    private static array $registeredLoopProbes = [];
    private static array $registeredTerminalProbes = [];

    final protected function __construct()
    {
        $this->reset();
    }

    protected function reset(): void
    {
        static::$classes = $this->createDefaultsClasses();
        static::$driverSettings = $this->createDriverSettings();
        static::$loopProbes = $this->defaultLoopProbes();
        static::$loopSettings = $this->createLoopSettings();
        static::$outputStream = $this->defaultOutputStream();
        static::$terminalProbes = $this->defaultTerminalProbes();
        static::$terminalSettings = $this->createTerminalSettings();
        static::$rootWidgetSettings = $this->createWidgetSettings();
        static::$widgetSettings = $this->createWidgetSettings();

        static::$initialization = static::INITIALIZATION_OPTION;
        static::$messageOnExit = static::MESSAGE_ON_EXIT;
        static::$messageOnFinalize = static::MESSAGE_ON_FINALIZE;
        static::$messageOnInterrupt = static::MESSAGE_ON_INTERRUPT;
        static::$millisecondsInterval = static::INTERVAL_MS;
        static::$percentNumberFormat = static::PERCENT_NUMBER_FORMAT;
        static::$runMode = static::RUN_MODE;
        static::$shutdownDelay = static::SHUTDOWN_DELAY;
        static::$shutdownMaxDelay = static::SHUTDOWN_MAX_DELAY;

        static::$stylePattern = null;
        static::$charPattern = null;
    }

    abstract protected function createDefaultsClasses(): IDefaultsClasses;

    abstract protected function createDriverSettings(): IDriverSettings;

    protected function defaultLoopProbes(): Traversable
    {
        yield from self::$registeredLoopProbes;
    }

    abstract protected function createLoopSettings(): ILoopSettings;

    /**
     * @return resource
     */
    protected function defaultOutputStream()
    {
        return STDERR;
    }

    protected function defaultTerminalProbes(): Traversable
    {
        yield from self::$registeredTerminalProbes;
    }

    abstract protected function createTerminalSettings(): ITerminalSettings;

    abstract protected function createWidgetSettings(): IWidgetSettings;

    /** @inheritdoc */
    public static function registerProbeClass(string $class): void
    {
        Asserter::classExists($class, __METHOD__);
        Asserter::isSubClass($class, IProbe::class, __METHOD__);

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
     * @param class-string $class
     * @throws InvalidArgumentException
     */
    protected static function registerLoopProbeClass(string $class): void
    {
        Asserter::isSubClass($class, ILoopProbe::class, __METHOD__);

        if (!in_array($class, self::$registeredLoopProbes, true)) {
            self::$registeredLoopProbes[] = $class;
        }
    }

    /**
     * @param class-string $class
     * @throws InvalidArgumentException
     */
    protected static function registerTerminalProbeClass(string $class): void
    {
        Asserter::isSubClass($class, ITerminalProbe::class, __METHOD__);

        if (!in_array($class, self::$registeredTerminalProbes, true)) {
            self::$registeredTerminalProbes[] = $class;
        }
    }
}

<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Config\Defaults\A;

use AlecRabbit\Spinner\Config\Defaults\Contract\IClasses;
use AlecRabbit\Spinner\Config\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Config\Defaults\Contract\ITerminal;
use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Loop\ReactLoopProbe;
use AlecRabbit\Spinner\Core\Loop\RevoltLoopProbe;
use AlecRabbit\Spinner\Core\Pattern\Char\Snake;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Core\Pattern\Style\Rainbow;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalProbe;
use AlecRabbit\Spinner\Core\Terminal\SymfonyTerminalProbe;
use AlecRabbit\Spinner\Factory\FrameFactory;
use AlecRabbit\Spinner\Helper\Asserter;

abstract class ADefaults extends ASettableDefaults implements IDefaults
{
    private static ?IDefaults $instance = null; // private, singleton

    private function __construct()
    {
        $this->reset();
    }

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

    final public static function getInstance(): self
    {
        if (null === self::$instance) {
            self::$instance =
                new class() extends ADefaults {
                };
        }
        return self::$instance;
    }

    protected static function getTerminalInstance(): ITerminal
    {
        return ATerminal::getInstance(self::$terminalProbes);
    }

    public function getClasses(): IClasses
    {
        return self::$classes;
    }

    /** @inheritdoc */
    public function getOutputStream()
    {
        return self::$outputStream;
    }

    public function getIntervalMilliseconds(): int
    {
        return self::$millisecondsInterval;
    }

    public function getShutdownDelay(): float|int
    {
        return self::$shutdownDelay;
    }

    public function isModeSynchronous(): bool
    {
        return self::$isModeSynchronous;
    }

    public function isHideCursor(): bool
    {
        return self::$hideCursor;
    }

    public function getFinalMessage(): string
    {
        return self::$messageOnFinalize;
    }


    public function getMessageOnExit(): string
    {
        return self::$messageOnExit;
    }

    public function getInterruptMessage(): string
    {
        return self::$messageOnInterrupt;
    }

    public function getMaxShutdownDelay(): float|int
    {
        return self::$shutdownMaxDelay;
    }

    public function setMaxShutdownDelay(float|int $maxShutdownDelay): static
    {
        self::$shutdownMaxDelay = $maxShutdownDelay;
        return $this;
    }

    public function getColorSupportLevels(): array
    {
        return self::$colorSupportLevels;
    }

    public function getPercentNumberFormat(): string
    {
        return self::$percentNumberFormat;
    }

    public function getSpinnerStylePattern(): IPattern
    {
        if (null === self::$mainStylePattern) {
            self::$mainStylePattern = new Rainbow();
        }
        return self::$mainStylePattern;
    }

    public function getSpinnerCharPattern(): IPattern
    {
        if (null === self::$mainCharPattern) {
            self::$mainCharPattern = new Snake();
        }
        return self::$mainCharPattern;
    }

    public function getMainLeadingSpacer(): IFrame
    {
        return
            self::$mainLeadingSpacer ?? self::$defaultLeadingSpacer;
    }

    public function getMainTrailingSpacer(): IFrame
    {
        return
            self::$mainTrailingSpacer ?? self::$defaultTrailingSpacer;
    }

    public function isCreateInitialized(): bool
    {
        return self::$createInitialized;
    }

    public function getDefaultLeadingSpacer(): IFrame
    {
        return self::$defaultLeadingSpacer;
    }

    public function getDefaultTrailingSpacer(): IFrame
    {
        return self::$defaultTrailingSpacer;
    }

    public function isAutoStartEnabled(): bool
    {
        return self::$autoStart;
    }

    public function areSignalHandlersEnabled(): bool
    {
        return self::$attachSignalHandlers;
    }

    public function getLoopProbeClasses(): iterable
    {
        return self::$loopProbes;
    }

    public function getTerminalProbeClasses(): iterable
    {
        return self::$terminalProbes;
    }

    public function getTerminal(): ITerminal
    {
        return self::$terminal;
    }
}

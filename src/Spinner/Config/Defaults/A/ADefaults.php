<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Config\Defaults\A;

use AlecRabbit\Spinner\Config\Defaults\Contract\IClasses;
use AlecRabbit\Spinner\Config\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Config\Defaults\Contract\ITerminal;
use AlecRabbit\Spinner\Config\Defaults\Mixin\DefaultConst;
use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Loop\ReactLoopProbe;
use AlecRabbit\Spinner\Core\Loop\RevoltLoopProbe;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalProbe;
use AlecRabbit\Spinner\Core\Terminal\SymfonyTerminalProbe;
use AlecRabbit\Spinner\Helper\Asserter;

use const AlecRabbit\Spinner\CSI;
use const AlecRabbit\Spinner\RESET;

abstract class ADefaults implements IDefaults
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
    protected static ?array $defaultStylePattern = null;
    protected static ?array $defaultCharPattern = null;
    protected static ?array $mainStylePattern = null;
    protected static ?array $mainCharPattern = null;
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

        self::$defaultStylePattern = [];
        self::$defaultCharPattern = [];
        self::$defaultLeadingSpacer = Frame::createEmpty();
        self::$defaultTrailingSpacer = Frame::createSpace();
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

    /** @inheritdoc */
    public function setOutputStream($stream): static
    {
        Asserter::assertStream($stream);
        self::$outputStream = $stream;
        return $this;
    }

    public function getIntervalMilliseconds(): int
    {
        return self::$millisecondsInterval;
    }

    public function setIntervalMilliseconds(int $defaultInterval): static
    {
        self::$millisecondsInterval = $defaultInterval;
        return $this;
    }

    public function getShutdownDelay(): float|int
    {
        return self::$shutdownDelay;
    }

    public function setShutdownDelay(float|int $shutdownDelay): static
    {
        self::$shutdownDelay = $shutdownDelay;
        return $this;
    }

    public function isModeSynchronous(): bool
    {
        return self::$isModeSynchronous;
    }

    public function setModeAsSynchronous(bool $isModeSynchronous): static
    {
        self::$isModeSynchronous = $isModeSynchronous;
        return $this;
    }

    public function isHideCursor(): bool
    {
        return self::$hideCursor;
    }

    public function setHideCursor(bool $hideCursor): static
    {
        self::$hideCursor = $hideCursor;
        return $this;
    }

    public function getDefaultCharPattern(): array
    {
        return self::$defaultCharPattern;
    }

    public function setDefaultCharPattern(array $char): static
    {
        self::$defaultCharPattern = $char;
        return $this;
    }

    public function getDefaultStylePattern(): array
    {
        return self::$defaultStylePattern;
    }

    public function setDefaultStylePattern(array $style): static
    {
        self::$defaultStylePattern = $style;
        return $this;
    }

    public function getFinalMessage(): string
    {
        return self::$messageOnFinalize;
    }

    public function setFinalMessage(string $finalMessage): static
    {
        self::$messageOnFinalize = $finalMessage;
        return $this;
    }

    public function getMessageOnExit(): string
    {
        return self::$messageOnExit;
    }

    public function setMessageOnExit(string $messageOnExit): static
    {
        self::$messageOnExit = $messageOnExit;
        return $this;
    }

    public function getInterruptMessage(): string
    {
        return self::$messageOnInterrupt;
    }

    public function setInterruptMessage(string $interruptMessage): static
    {
        self::$messageOnInterrupt = $interruptMessage;
        return $this;
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

    /** @inheritdoc */
    public function setColorSupportLevels(array $colorSupportLevels): static
    {
        Asserter::assertColorSupportLevels($colorSupportLevels);
        self::$colorSupportLevels = $colorSupportLevels;
        return $this;
    }


    public function getPercentNumberFormat(): string
    {
        return self::$percentNumberFormat;
    }

    public function setPercentNumberFormat(string $percentNumberFormat): static
    {
        self::$percentNumberFormat = $percentNumberFormat;
        return $this;
    }

    public function getSpinnerStylePattern(): array
    {
        // TODO (2022-10-14 16:03) [Alec Rabbit]: change return type to ? [e68824d4-3908-49e4-9daf-73777963d37b]
        if (null === self::$mainStylePattern) {
            self::$mainStylePattern = [
                CSI . '38;5;196m%s' . RESET,
                CSI . '38;5;202m%s' . RESET,
                CSI . '38;5;208m%s' . RESET,
                CSI . '38;5;214m%s' . RESET,
                CSI . '38;5;220m%s' . RESET,
                CSI . '38;5;226m%s' . RESET,
                CSI . '38;5;190m%s' . RESET,
                CSI . '38;5;154m%s' . RESET,
                CSI . '38;5;118m%s' . RESET,
                CSI . '38;5;82m%s' . RESET,
                CSI . '38;5;46m%s' . RESET,
                CSI . '38;5;47m%s' . RESET,
                CSI . '38;5;48m%s' . RESET,
                CSI . '38;5;49m%s' . RESET,
                CSI . '38;5;50m%s' . RESET,
                CSI . '38;5;51m%s' . RESET,
                CSI . '38;5;45m%s' . RESET,
                CSI . '38;5;39m%s' . RESET,
                CSI . '38;5;33m%s' . RESET,
                CSI . '38;5;27m%s' . RESET,
                CSI . '38;5;56m%s' . RESET,
                CSI . '38;5;57m%s' . RESET,
                CSI . '38;5;93m%s' . RESET,
                CSI . '38;5;129m%s' . RESET,
                CSI . '38;5;165m%s' . RESET,
                CSI . '38;5;201m%s' . RESET,
                CSI . '38;5;200m%s' . RESET,
                CSI . '38;5;199m%s' . RESET,
                CSI . '38;5;198m%s' . RESET,
                CSI . '38;5;197m%s' . RESET,
            ];
        }
        return self::$mainStylePattern;
    }

    public function setSpinnerStylePattern(array $spinnerStylePattern): static
    {
        self::$mainStylePattern = $spinnerStylePattern;
        return $this;
    }

    public function getSpinnerCharPattern(): array
    {
        // TODO (2022-10-14 16:03) [Alec Rabbit]: change return type to ? [f96f5d87-f9f9-46dc-a45b-8eecc2aba711]
        if (null === self::$mainCharPattern) {
            self::$mainCharPattern = ['⠏', '⠛', '⠹', '⢸', '⣰', '⣤', '⣆', '⡇'];
        }
        return self::$mainCharPattern;
    }

    public function setSpinnerCharPattern(array $spinnerCharPattern): static
    {
        self::$mainCharPattern = $spinnerCharPattern;
        return $this;
    }

    public function getMainLeadingSpacer(): IFrame
    {
        return
            self::$mainLeadingSpacer ?? self::$defaultLeadingSpacer;
    }

    public function setMainLeadingSpacer(IFrame $mainLeadingSpacer): static
    {
        self::$mainLeadingSpacer = $mainLeadingSpacer;
        return $this;
    }

    public function getMainTrailingSpacer(): IFrame
    {
        return
            self::$mainTrailingSpacer ?? self::$defaultTrailingSpacer;
    }

    public function setMainTrailingSpacer(IFrame $mainTrailingSpacer): static
    {
        self::$mainTrailingSpacer = $mainTrailingSpacer;
        return $this;
    }

    public function isCreateInitialized(): bool
    {
        return self::$createInitialized;
    }

    public function setCreateInitialized(bool $createInitialized): static
    {
        self::$createInitialized = $createInitialized;
        return $this;
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

    public function setAutoStart(bool $autoStart): static
    {
        self::$autoStart = $autoStart;
        return $this;
    }

    public function areSignalHandlersEnabled(): bool
    {
        return self::$attachSignalHandlers;
    }

    public function setAttachSignalHandlers(bool $attachSignalHandlers): static
    {
        self::$attachSignalHandlers = $attachSignalHandlers;
        return $this;
    }

    public function getLoopProbeClasses(): iterable
    {
        return self::$loopProbes;
    }

    public function getTerminalProbeClasses(): iterable
    {
        return self::$terminalProbes;
    }

    /** @inheritdoc */
    public function setTerminalProbeClasses(iterable $terminalProbes): static
    {
        foreach ($terminalProbes as $probe) {
            Asserter::isSubClass($probe, ITerminalProbe::class, __METHOD__);
        }
        self::$terminalProbes = $terminalProbes;
        return $this;
    }

    /** @inheritdoc */
    public function setLoopProbeClasses(iterable $loopProbes): static
    {
        foreach ($loopProbes as $probe) {
            Asserter::isSubClass($probe, ILoopProbe::class, __METHOD__);
        }
        self::$loopProbes = $loopProbes;
        return $this;
    }
}

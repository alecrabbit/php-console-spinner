<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Defaults\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaultsClasses;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\ITerminalSettings;
use AlecRabbit\Spinner\Core\Pattern\Char\Ascii;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Core\Pattern\Style\Rainbow;
use AlecRabbit\Spinner\Core\RunMode;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalProbe;
use AlecRabbit\Spinner\Core\Terminal\NativeTerminalProbe;

abstract class ADefaults extends ASettableDefaults
{
    private static ?IDefaults $instance = null; // private, singleton

    protected function getClassesInstance(): IDefaultsClasses
    {
        return ADefaultsClasses::getInstance($this);
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

    protected function createTerminalSettings(): ITerminalSettings
    {
        $colorMode = NativeTerminalProbe::getColorMode();
        $width = NativeTerminalProbe::getWidth();
        $hideCursor = NativeTerminalProbe::isHideCursor();

        /** @var ITerminalProbe $terminalProbe */
        foreach (static::$terminalProbes as $terminalProbe) {
            if ($terminalProbe::isSupported()) {
                $colorMode = $terminalProbe::getColorMode();
                $width = $terminalProbe::getWidth();
            }
        }
        return ATerminalSettings::getInstance($this, $colorMode, $width, $hideCursor);
    }

    protected function createDriverSettings(): IDriverSettings
    {
        return ADriverSettings::getInstance($this);
    }

    protected function createWidgetSettings(): IWidgetSettings
    {
        return AWidgetSettings::getInstance($this);
    }

    public function getRootWidgetSettings(): IWidgetSettings
    {
        return static::$rootWidgetSettings;
    }

    public function getWidgetSettings(): IWidgetSettings
    {
        return static::$widgetSettings;
    }

    public function getClasses(): IDefaultsClasses
    {
        return static::$classes;
    }

    /** @inheritdoc */
    public function getOutputStream()
    {
        return static::$outputStream;
    }

    public function getIntervalMilliseconds(): int
    {
        return static::$millisecondsInterval;
    }

    public function getShutdownDelay(): float|int
    {
        return static::$shutdownDelay;
    }

    public function isModeSynchronous(): bool
    {
        return static::$isModeSynchronous;
    }

    public function getRunMode(): RunMode
    {
        return static::$runMode;
    }

    public function getMaxShutdownDelay(): float|int
    {
        return static::$shutdownMaxDelay;
    }

    public function getSupportedColorModes(): iterable
    {
        return static::$supportedColorModes;
    }

    public function getPercentNumberFormat(): string
    {
        return static::$percentNumberFormat;
    }

    public function getStylePattern(): IPattern
    {
        if (null === static::$mainStylePattern) {
            static::$mainStylePattern = new Rainbow();
        }
        return static::$mainStylePattern;
    }

    public function getCharPattern(): IPattern
    {
        if (null === static::$mainCharPattern) {
            static::$mainCharPattern = new Ascii();
        }
        return static::$mainCharPattern;
    }

//    public function getMainLeadingSpacer(): IFrame
//    {
//        return
//            static::$mainLeadingSpacer ?? static::$defaultLeadingSpacer;
//    }
//
//    public function getMainTrailingSpacer(): IFrame
//    {
//        return
//            static::$mainTrailingSpacer ?? static::$defaultTrailingSpacer;
//    }

    public function isCreateInitialized(): bool
    {
        return static::$createInitialized;
    }

//    public function getDefaultLeadingSpacer(): IFrame
//    {
//        return static::$defaultLeadingSpacer;
//    }
//
//    public function getDefaultTrailingSpacer(): IFrame
//    {
//        return static::$defaultTrailingSpacer;
//    }

    public function isAutoStartEnabled(): bool
    {
        return static::$autoStartEnabled;
    }

    public function areSignalHandlersEnabled(): bool
    {
        return static::$attachSignalHandlers;
    }

    public function getProbeClasses(): iterable
    {
        return static::$loopProbes;
    }

    public function getTerminalSettings(): ITerminalSettings
    {
        return static::$terminalSettings;
    }

    public function getDriverSettings(): IDriverSettings
    {
        return static::$driverSettings;
    }
}

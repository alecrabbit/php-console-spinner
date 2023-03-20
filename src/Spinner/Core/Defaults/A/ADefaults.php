<?php

declare(strict_types=1);
// 20.06.22

namespace AlecRabbit\Spinner\Core\Defaults\A;

use AlecRabbit\Spinner\Contract\RunMode;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaultsClasses;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\ISpinnerSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\ITerminalSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Factory\Contract\IRevolverFactory;
use AlecRabbit\Spinner\Core\Pattern\Char\Ascii;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Core\Pattern\Style\Rainbow;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalProbe;
use AlecRabbit\Spinner\Core\Terminal\NativeTerminalProbe;
use Traversable;

abstract class ADefaults extends ASettableDefaults
{
    private static ?IDefaults $objInstance = null; // private, singleton


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

    public function getShutdownDelay(): float|int
    {
        return static::$shutdownDelay;
    }

    public function isModeSynchronous(): bool
    {
        return static::$runMode === RunMode::SYNCHRONOUS;
    }

    public function getRunMode(): RunMode
    {
        return static::$runMode;
    }

    public function getMaxShutdownDelay(): float|int
    {
        return static::$shutdownMaxDelay;
    }

    public function getPercentNumberFormat(): string
    {
        return static::$percentNumberFormat;
    }

    public function getStylePattern(): IPattern
    {
        if (null === static::$stylePattern) {
            static::$stylePattern = new Rainbow();
        }
        return static::$stylePattern;
    }

    public function getCharPattern(): IPattern
    {
        if (null === static::$charPattern) {
            static::$charPattern = new Ascii();
        }
        return static::$charPattern;
    }

    public function getProbeClasses(): Traversable
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

    public function getLoopSettings(): ILoopSettings
    {
        return static::$loopSettings;
    }

    public function getSpinnerSettings(): ISpinnerSettings
    {
        return static::$spinnerSettings;
    }

    protected function createDefaultsClasses(): IDefaultsClasses
    {
        return ADefaultsClasses::getInstance($this);
    }

    final public static function getInstance(): IDefaults
    {
        if (null === self::$objInstance) {
            self::$objInstance =
                new class () extends ADefaults {
                };
        }
        return self::$objInstance;
    }

    protected function createTerminalSettings(): ITerminalSettings
    {
        $colorMode = NativeTerminalProbe::getColorMode();
        $width = NativeTerminalProbe::getWidth();
        $cursor = NativeTerminalProbe::getCursorMode();

        /** @var ITerminalProbe $terminalProbe */
        foreach (static::$terminalProbes as $terminalProbe) {
            if ($terminalProbe::isSupported()) {
                $colorMode = $terminalProbe::getColorMode();
                $width = $terminalProbe::getWidth();
            }
        }
        return ATerminalSettings::getInstance($this, $colorMode, $width, $cursor);
    }

    protected function createDriverSettings(): IDriverSettings
    {
        return ADriverSettings::getInstance($this);
    }

    protected function createWidgetSettings(): IWidgetSettings
    {
        return AWidgetSettings::getInstance($this);
    }

    protected function createLoopSettings(): ILoopSettings
    {
        return ALoopSettings::getInstance($this);
    }

    protected function createSpinnerSettings(): ISpinnerSettings
    {
        return ASpinnerSettings::getInstance($this);
    }

    public function getRevolverFactory(): IRevolverFactory
    {
        return static::$revolverFactory;
    }
}

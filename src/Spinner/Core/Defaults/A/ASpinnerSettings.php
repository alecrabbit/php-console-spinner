<?php

declare(strict_types=1);
// 20.03.23
namespace AlecRabbit\Spinner\Core\Defaults\A;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\OptionInitialization;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Defaults\Contract\ISpinnerSettings;
use AlecRabbit\Spinner\Core\Defaults\Mixin\DefaultsConst;
use AlecRabbit\Spinner\Core\Interval;

abstract class ASpinnerSettings extends ADefaultsChild implements ISpinnerSettings
{
    use DefaultsConst;

    protected static OptionInitialization $initializationOption;
    protected static IInterval $intervalObject;

    private static ?ISpinnerSettings $objInstance = null; // private, singleton

    final protected function __construct(IDefaults $parent)
    {
        parent::__construct($parent);
        $this->reset();
    }

    protected function reset(): void
    {
        static::$initializationOption = static::INITIALIZATION_OPTION;
        static::$intervalObject = $this->createIntervalObject();
    }

    protected function createIntervalObject(): IInterval
    {
        // **Note**: dependency from a concrete class
        return new Interval(static::INTERVAL_MS);
    }

    final public static function getInstance(IDefaults $parent): ISpinnerSettings
    {
        if (null === self::$objInstance) {
            self::$objInstance =
                new class ($parent) extends ASpinnerSettings {
                };
        }
        return self::$objInstance;
    }

    public function getInterval(): IInterval
    {
        return static::$intervalObject;
    }

    public function getInitializationOption(): OptionInitialization
    {
        return static::$initializationOption;
    }

    public function overrideInitializationOption(OptionInitialization $initialization): static
    {
        static::$initializationOption = $initialization;
        return $this;
    }

    public function overrideInterval(IInterval $interval): static
    {
        static::$intervalObject = $interval;
        return $this;
    }
}
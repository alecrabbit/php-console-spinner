<?php

declare(strict_types=1);
// 20.03.23
namespace AlecRabbit\Spinner\Core\Defaults\A;

use AlecRabbit\Spinner\Contract\OptionAutoStart;
use AlecRabbit\Spinner\Contract\OptionSignalHandlers;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Defaults\Mixin\DefaultsConst;

abstract class ALoopSettings extends ADefaultsChild implements ILoopSettings
{
    use DefaultsConst;

    protected static OptionAutoStart $autoStartOption;
    protected static OptionSignalHandlers $signalHandlersOption;

    private static ?ILoopSettings $objInstance = null;

    final protected function __construct(IDefaults $parent)
    {
        parent::__construct($parent);
        $this->reset();
    }

    protected function reset(): void
    {
        static::$autoStartOption = static::AUTO_START_OPTION;
        static::$signalHandlersOption = static::SIGNAL_HANDLERS_OPTION;
    }

    final public static function getInstance(IDefaults $parent): ILoopSettings
    {
        if (null === self::$objInstance) {
            self::$objInstance =
                new class ($parent) extends ALoopSettings {
                };
        }
        return self::$objInstance;
    }

    public function getAutoStartOption(): OptionAutoStart
    {
        return static::$autoStartOption;
    }

    public function getSignalHandlersOption(): OptionSignalHandlers
    {
        return static::$signalHandlersOption;
    }

    public function overrideAutoStartOption(OptionAutoStart $autoStartOption): ILoopSettings
    {
        static::$autoStartOption = $autoStartOption;
        return $this;
    }

    public function overrideSignalHandlersOption(OptionSignalHandlers $signalHandlersOption): ILoopSettings
    {
        static::$signalHandlersOption = $signalHandlersOption;
        return $this;
    }
}
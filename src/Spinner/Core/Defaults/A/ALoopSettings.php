<?php

declare(strict_types=1);
// 20.03.23
namespace AlecRabbit\Spinner\Core\Defaults\A;

use AlecRabbit\Spinner\Contract\AutoStart;
use AlecRabbit\Spinner\Contract\SignalHandlers;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Defaults\Mixin\DefaultsConst;

abstract class ALoopSettings extends ADefaultsChild implements ILoopSettings
{
    use DefaultsConst;

    private static ?ILoopSettings $instance = null;
    private static SignalHandlers $signalHandlersOption;
    private static AutoStart $autoStartOption;

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
        if (null === self::$instance) {
            self::$instance =
                new class ($parent) extends ALoopSettings {
                };
        }
        return self::$instance;
    }

    public function getAutoStartOption(): AutoStart
    {
        return static::$autoStartOption;
    }

    public function getSignalHandlersOption(): SignalHandlers
    {
        return static::$signalHandlersOption;
    }

    public function overrideAutoStartOption(AutoStart $autoStartOption): ILoopSettings
    {
        static::$autoStartOption = $autoStartOption;
        return $this;
    }

    public function overrideSignalHandlersOption(SignalHandlers $signalHandlersOption): ILoopSettings
    {
        static::$signalHandlersOption = $signalHandlersOption;
        return $this;
    }
}
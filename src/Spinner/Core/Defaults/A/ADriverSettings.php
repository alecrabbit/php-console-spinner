<?php

declare(strict_types=1);
// 15.03.23

namespace AlecRabbit\Spinner\Core\Defaults\A;

use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Defaults\Mixin\DefaultsConst;

abstract class ADriverSettings extends ADefaultsChild implements IDriverSettings
{
    use DefaultsConst;

    protected static string $messageOnFinalize;
    protected static string $messageOnExit;
    protected static string $messageOnInterrupt;

    private static ?IDriverSettings $objInstance = null;

    final protected function __construct(IDefaults $parent)
    {
        parent::__construct($parent);
        $this->reset();
    }

    protected function reset(): void
    {
        static::$messageOnFinalize = static::MESSAGE_ON_FINALIZE;
        static::$messageOnExit = static::MESSAGE_ON_EXIT;
        static::$messageOnInterrupt = static::MESSAGE_ON_INTERRUPT;
    }

    final public static function getInstance(IDefaults $parent): IDriverSettings
    {
        if (null === self::$objInstance) {
            self::$objInstance =
                new class ($parent) extends ADriverSettings {
                };
        }
        return self::$objInstance;
    }

    public function getInterruptMessage(): string
    {
        return static::$messageOnInterrupt;
    }

    public function getFinalMessage(): string
    {
        return static::$messageOnFinalize;
    }

    public function setFinalMessage(string $finalMessage): static
    {
        static::$messageOnFinalize = $finalMessage;
        return $this;
    }

    public function setInterruptMessage(string $interruptMessage): static
    {
        static::$messageOnInterrupt = $interruptMessage;
        return $this;
    }
}

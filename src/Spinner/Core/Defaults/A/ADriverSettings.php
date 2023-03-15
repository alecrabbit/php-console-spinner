<?php

declare(strict_types=1);
// 15.03.23
namespace AlecRabbit\Spinner\Core\Defaults\A;

use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Defaults\Mixin\DefaultsConst;

abstract class ADriverSettings implements IDriverSettings
{
    use DefaultsConst;

    protected static string $messageOnFinalize;
    protected static string $messageOnExit;
    protected static string $messageOnInterrupt;

    private static ?IDriverSettings $instance = null;

    final public static function getInstance(): static
    {
        if (null === self::$instance) {
            self::$instance =
                new class() extends ADriverSettings {
                };
        }
        return self::$instance;
    }

    public function getInterruptMessage(): string
    {
        return static::$messageOnInterrupt;
    }

    public function getFinalMessage(): string
    {
        return static::$messageOnFinalize;
    }

    protected function reset(): void
    {
        static::$messageOnFinalize = static::MESSAGE_ON_FINALIZE;
        static::$messageOnExit = static::MESSAGE_ON_EXIT;
        static::$messageOnInterrupt = static::MESSAGE_ON_INTERRUPT;
    }
}
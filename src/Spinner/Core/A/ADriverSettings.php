<?php
declare(strict_types=1);
// 15.03.23
namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Core\Contract\IDriverSettings;

abstract class ADriverSettings implements IDriverSettings
{

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
        // TODO: Implement getInterruptMessage() method.
    }

    public function getFinalMessage(): string
    {
        // TODO: Implement getFinalMessage() method.
    }
}
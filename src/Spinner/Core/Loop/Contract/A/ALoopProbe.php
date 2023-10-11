<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Loop\Contract\A;

use AlecRabbit\Spinner\Core\Loop\Contract\ILoopCreator;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbe;

abstract class ALoopProbe implements ILoopProbe
{
    abstract public static function isSupported(): bool;

    /**
     * @return class-string<ILoopCreator>
     */
    abstract public static function getCreatorClass(): string;
}

<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract\Loop\A;

use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoopCreator;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoopProbe;

abstract class ALoopProbe implements ILoopProbe
{
    abstract public static function isSupported(): bool;

    /**
     * @return class-string<ILoopCreator>
     */
    abstract public static function getCreatorClass(): string;
}

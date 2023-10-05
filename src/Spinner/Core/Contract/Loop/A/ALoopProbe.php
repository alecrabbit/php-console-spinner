<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract\Loop\A;

use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\Probe\ILoopProbe;
use RuntimeException;

abstract class ALoopProbe implements ILoopProbe
{
    abstract public static function isSupported(): bool;

    public static function getCreatorClass(): string
    {
        // TODO: Implement getLoopCreator() method.
        throw new RuntimeException('Not implemented.');
    }

    /**
     * @deprecated
     */
    abstract public function createLoop(): ILoop;
}

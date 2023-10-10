<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Asynchronous\Stub;

use AlecRabbit\Spinner\Asynchronous\Revolt\RevoltLoopCreator;
use AlecRabbit\Spinner\Core\Contract\Loop\A\ALoopProbe;

final class LoopProbeStub extends ALoopProbe
{
    public static function isSupported(): bool
    {
        return true;
    }

    public static function getCreatorClass(): string
    {
        return RevoltLoopCreator::class;
    }
}

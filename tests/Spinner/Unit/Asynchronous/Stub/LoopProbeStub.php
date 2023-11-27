<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Asynchronous\Stub;

use AlecRabbit\Spinner\Asynchronous\Revolt\RevoltLoopCreator;
use AlecRabbit\Spinner\Core\Loop\Contract\A\ALoopProbe;

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

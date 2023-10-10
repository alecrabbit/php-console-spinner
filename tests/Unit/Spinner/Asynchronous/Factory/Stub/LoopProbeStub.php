<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Asynchronous\Factory\Stub;

use AlecRabbit\Spinner\Asynchronous\Factory\RevoltLoopCreator;
use AlecRabbit\Spinner\Core\Contract\Loop\A\ALoopProbe;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;
use AlecRabbit\Tests\Unit\Spinner\Asynchronous\Override\ALoopAdapterOverride;
use RuntimeException;

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

    /**
     * @deprecated
     */
    public function createLoop(): ILoop
    {
        return new ALoopAdapterOverride();
    }
}

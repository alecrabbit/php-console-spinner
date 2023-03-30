<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Asynchronous\Factory\Stub;

use AlecRabbit\Spinner\Core\Contract\ILoopAdapter;
use AlecRabbit\Spinner\Core\Loop\A\ALoopProbe;
use AlecRabbit\Tests\Spinner\Unit\Spinner\Asynchronous\Override\ALoopAdapterOverride;

final class LoopProbeStub extends ALoopProbe
{
    public static function isSupported(): bool
    {
        return true;
    }

    public function createLoop(): ILoopAdapter
    {
        return new ALoopAdapterOverride();
    }
}

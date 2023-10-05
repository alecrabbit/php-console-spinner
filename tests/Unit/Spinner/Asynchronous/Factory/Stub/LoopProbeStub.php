<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Asynchronous\Factory\Stub;

use AlecRabbit\Spinner\Core\Contract\Loop\A\ALoopProbe;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Tests\Unit\Spinner\Asynchronous\Override\ALoopAdapterOverride;

final class LoopProbeStub extends ALoopProbe
{
    public static function isSupported(): bool
    {
        return true;
    }

    /**
     * @deprecated
     */
    public function createLoop(): ILoop
    {
        return new ALoopAdapterOverride();
    }
}

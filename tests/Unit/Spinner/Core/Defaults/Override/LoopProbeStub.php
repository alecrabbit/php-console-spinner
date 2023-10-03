<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults\Override;

use AlecRabbit\Spinner\Contract\Probe\ILoopProbe;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use RuntimeException;

final class LoopProbeStub implements ILoopProbe
{
    public static function isSupported(): bool
    {
        return true;
    }

    public function createLoop(): ILoop
    {
        throw new RuntimeException('Should not be called.');
    }
}

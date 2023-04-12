<?php

declare(strict_types=1);
// 12.04.23
namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults\Override;

use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbe;
use RuntimeException;

final class LoopProbeStub implements ILoopProbe
{
    public static function isAvailable(): bool
    {
        return true;
    }

    public function createLoop(): ILoop
    {
        throw new RuntimeException('Should not be called.');
    }
}

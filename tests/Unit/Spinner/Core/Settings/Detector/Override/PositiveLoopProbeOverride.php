<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector\Override;

use AlecRabbit\Spinner\Contract\Probe\ILoopProbe;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use RuntimeException;

class PositiveLoopProbeOverride implements ILoopProbe
{
    public static function isSupported(): bool
    {
        return true;
    }

    public function createLoop(): ILoop
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }
}

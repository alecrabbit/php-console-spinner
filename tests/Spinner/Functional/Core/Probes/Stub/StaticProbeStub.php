<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Core\Probes\Stub;

use AlecRabbit\Spinner\Contract\Probe\IStaticProbe;
use RuntimeException;

class StaticProbeStub implements IStaticProbe
{
    public static function isSupported(): bool
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }

    public static function getCreatorClass(): string
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }
}

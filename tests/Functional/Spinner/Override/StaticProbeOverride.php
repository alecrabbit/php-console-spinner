<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Override;

use AlecRabbit\Spinner\Contract\Probe\IStaticProbe;
use RuntimeException;

class StaticProbeOverride implements IStaticProbe
{
    public static function isSupported(): bool
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }
    public static function getCreatorClass(): string
    {
        // TODO: Implement getCreatorClass() method.
        throw new \RuntimeException('Not implemented.');
    }
}

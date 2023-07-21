<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Override;

use AlecRabbit\Spinner\Contract\IStaticProbe;
use RuntimeException;

class StaticProbeOverride implements IStaticProbe
{
    public static function isSupported(): bool
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }
}

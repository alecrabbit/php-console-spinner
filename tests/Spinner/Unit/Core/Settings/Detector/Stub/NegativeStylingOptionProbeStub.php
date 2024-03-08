<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Settings\Detector\Stub;

use AlecRabbit\Spinner\Contract\Probe\IStylingOptionProbe;
use RuntimeException;

class NegativeStylingOptionProbeStub implements IStylingOptionProbe
{
    public static function isSupported(): bool
    {
        return false;
    }

    public static function getCreatorClass(): string
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }
}

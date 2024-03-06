<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Settings\Detector\Stub;

use AlecRabbit\Spinner\Contract\Probe\IStylingMethodProbe;
use RuntimeException;

class NegativeStylingMethodProbeStub implements IStylingMethodProbe
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

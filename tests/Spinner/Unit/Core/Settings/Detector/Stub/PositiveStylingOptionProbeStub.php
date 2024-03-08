<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Settings\Detector\Stub;

use AlecRabbit\Spinner\Contract\Probe\IStylingOptionProbe;

class PositiveStylingOptionProbeStub implements IStylingOptionProbe
{
    public static function isSupported(): bool
    {
        return true;
    }

    public static function getCreatorClass(): string
    {
        return StylingOptionCreatorStub::class;
    }
}

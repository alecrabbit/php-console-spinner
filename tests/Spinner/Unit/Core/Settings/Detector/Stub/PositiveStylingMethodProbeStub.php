<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Settings\Detector\Stub;

use AlecRabbit\Spinner\Contract\Probe\IStylingMethodProbe;

class PositiveStylingMethodProbeStub implements IStylingMethodProbe
{
    public static function isSupported(): bool
    {
        return true;
    }

    public static function getCreatorClass(): string
    {
        return StylingMethodOptionCreatorStub::class;
    }
}

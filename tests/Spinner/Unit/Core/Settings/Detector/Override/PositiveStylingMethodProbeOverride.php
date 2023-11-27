<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Settings\Detector\Override;

use AlecRabbit\Spinner\Contract\Probe\IStylingMethodProbe;

class PositiveStylingMethodProbeOverride implements IStylingMethodProbe
{
    public static function isSupported(): bool
    {
        return true;
    }

    public static function getCreatorClass(): string
    {
        return StylingMethodOptionCreatorOverride::class;
    }
}

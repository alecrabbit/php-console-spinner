<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector\Override;

use AlecRabbit\Spinner\Contract\Probe\IColorSupportProbe;

class PositiveColorSupportProbeOverride implements IColorSupportProbe
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

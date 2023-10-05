<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector\Override;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Contract\Probe\IColorSupportProbe;
use RuntimeException;

class PositiveColorSupportProbeOverride implements IColorSupportProbe
{
    public static function isSupported(): bool
    {
        return true;
    }

    public static function getStylingMethodOption(): StylingMethodOption
    {
        return StylingMethodOption::ANSI24;
    }
}

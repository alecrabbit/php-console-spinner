<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Probe;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Contract\Probe\IColorSupportProbe;

class ColorSupportProbe implements IColorSupportProbe
{
    public static function getStylingMethodOption(): StylingMethodOption
    {
        return StylingMethodOption::AUTO;
    }

    public static function isSupported(): bool
    {
        return true;
    }
}

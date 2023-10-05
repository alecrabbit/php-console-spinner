<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Probe;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Contract\Probe\IColorSupportProbe;
use RuntimeException;

final class ColorSupportProbe implements IColorSupportProbe
{
    public static function getStylingMethodOption(): StylingMethodOption
    {
        return StylingMethodOption::AUTO;
    }

    public static function isSupported(): bool
    {
        return true;
    }

    public static function getCreatorClass(): string
    {
        // TODO: Implement getCreatorClass() method.
        throw new RuntimeException('Not implemented.');
    }
}

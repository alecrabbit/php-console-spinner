<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Probe;

use AlecRabbit\Spinner\Contract\Probe\IColorSupportProbe;

final class ColorSupportProbe implements IColorSupportProbe
{
    public static function isSupported(): bool
    {
        return true;
    }

    public static function getCreatorClass(): string
    {
        return StylingMethodOptionCreator::class;
    }
}

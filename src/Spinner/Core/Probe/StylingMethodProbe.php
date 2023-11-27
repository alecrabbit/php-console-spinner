<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Probe;

use AlecRabbit\Spinner\Contract\Probe\IStylingMethodOptionCreator;
use AlecRabbit\Spinner\Contract\Probe\IStylingMethodProbe;

final class StylingMethodProbe implements IStylingMethodProbe
{
    public static function isSupported(): bool
    {
        return true;
    }

    /**
     * @return class-string<IStylingMethodOptionCreator>
     */
    public static function getCreatorClass(): string
    {
        return StylingMethodOptionCreator::class;
    }
}

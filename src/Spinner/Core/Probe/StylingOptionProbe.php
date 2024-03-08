<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Probe;

use AlecRabbit\Spinner\Contract\Probe\IStylingOptionCreator;
use AlecRabbit\Spinner\Contract\Probe\IStylingOptionProbe;

final class StylingOptionProbe implements IStylingOptionProbe
{
    public static function isSupported(): bool
    {
        return true;
    }

    /**
     * @return class-string<IStylingOptionCreator>
     */
    public static function getCreatorClass(): string
    {
        return StylingOptionCreator::class;
    }
}

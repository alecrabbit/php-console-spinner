<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector\Override;

use AlecRabbit\Spinner\Contract\Probe\IStylingMethodProbe;
use RuntimeException;

class NegativeStylingMethodProbeOverride implements IStylingMethodProbe
{
    public static function isSupported(): bool
    {
        return false;
    }

    public static function getCreatorClass(): string
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }
}

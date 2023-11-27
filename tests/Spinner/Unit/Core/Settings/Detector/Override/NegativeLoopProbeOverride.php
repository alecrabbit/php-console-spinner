<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Settings\Detector\Override;

use AlecRabbit\Spinner\Core\Loop\Contract\A\ALoopProbe;
use RuntimeException;

class NegativeLoopProbeOverride extends ALoopProbe
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

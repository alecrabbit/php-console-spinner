<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector\Override;

use AlecRabbit\Spinner\Contract\Probe\IColorSupportProbe;
use RuntimeException;

class NegativeColorSupportProbeOverride implements IColorSupportProbe
{
    public static function isSupported(): bool
    {
        return false;
    }

    public function createLoop(): mixed
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }
}

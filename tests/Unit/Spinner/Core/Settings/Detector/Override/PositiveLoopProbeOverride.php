<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector\Override;

use AlecRabbit\Spinner\Core\Loop\Contract\A\ALoopProbe;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use RuntimeException;

class PositiveLoopProbeOverride extends ALoopProbe
{
    public static function isSupported(): bool
    {
        return true;
    }

    public static function getCreatorClass(): string
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }

    /**
     * @deprecated
     */
    public function createLoop(): ILoop
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }
}

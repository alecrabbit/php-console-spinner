<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector\Override;

use AlecRabbit\Spinner\Core\Contract\Loop\A\ALoopProbe;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;
use RuntimeException;

class NegativeLoopProbeOverride  extends ALoopProbe
{
    public static function isSupported(): bool
    {
        return false;
    }

    /**
     * @deprecated
     */
    public function createLoop(): ILoop
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }
}

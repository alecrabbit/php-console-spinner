<?php

declare(strict_types=1);
// 12.04.23
namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults\Override;

use AlecRabbit\Spinner\Core\Contract\IPcntlExtensionProbe;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbe;

final class PcntlExtensionProbeStub implements IPcntlExtensionProbe
{
    public static function isAvailable(): bool
    {
        return true;
    }
}

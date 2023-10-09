<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector\Override;

use AlecRabbit\Spinner\Core\Contract\Loop\A\ALoopProbe;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoopCreator;
use RuntimeException;

class LoopCreatorOverride implements ILoopCreator
{
    public static function create(): ILoop
    {
        throw new \RuntimeException('INTENTIONALLY Not implemented.');
    }
}

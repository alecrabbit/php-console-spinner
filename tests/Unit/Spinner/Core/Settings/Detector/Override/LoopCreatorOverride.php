<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector\Override;

use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopCreator;
use RuntimeException;

class LoopCreatorOverride implements ILoopCreator
{
    public static function create(): ILoop
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }
}

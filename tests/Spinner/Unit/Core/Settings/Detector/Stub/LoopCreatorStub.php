<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Settings\Detector\Stub;

use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopCreator;
use RuntimeException;

class LoopCreatorStub implements ILoopCreator
{
    public function create(): ILoop
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }
}

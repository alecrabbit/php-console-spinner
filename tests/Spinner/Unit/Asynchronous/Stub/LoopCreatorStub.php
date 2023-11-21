<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Asynchronous\Stub;

use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopCreator;
use AlecRabbit\Tests\Spinner\Unit\Asynchronous\Override\ALoopAdapterOverride;

final class LoopCreatorStub implements ILoopCreator
{
    public function create(): ILoop
    {
        return new ALoopAdapterOverride();
    }
}

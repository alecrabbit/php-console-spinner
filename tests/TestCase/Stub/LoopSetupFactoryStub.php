<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\TestCase\Stub;

use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Contract\Output\IWritableStream;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopSetup;

class LoopSetupFactoryStub implements IInvokable
{
    public function __invoke(): ILoopSetup
    {
        return new class() implements ILoopSetup {
            public function setup(ILoop $loop): void
            {
                // do nothing
            }
        };
    }

}

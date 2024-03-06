<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\TestCase\Stub;

use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Contract\Output\IWritableStream;

class WritableStreamFactoryStub implements IInvokable
{
    public function __invoke(): IWritableStream
    {
        return new class() implements IWritableStream {
            public function write(\Traversable $data): void
            {
                // do nothing
            }
        };
    }

}

<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Factory;

use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Contract\Output\IWritableStream;
use AlecRabbit\Spinner\Core\Output\Contract\Factory\IWritableStreamFactory;

final class WritableStreamFactory implements IWritableStreamFactory, IInvokable
{
    public function __invoke(): mixed
    {
        return $this->create();
    }

    public function create(): IWritableStream
    {
        return new class() implements IWritableStream {
            public function write(\Traversable $data): void
            {
                // unwrap $data
                iterator_to_array($data);
            }
        };
    }
}

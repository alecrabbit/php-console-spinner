<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract\Output;

interface IBufferedOutput
{
    /**
     * Flushes the output buffer.
     */
    public function flush(): void;

    /**
     * Appends message to buffer.
     *
     * @psalm-param iterable<string>|string $messages
     */
    public function append(iterable|string $messages): IBufferedOutput;
}

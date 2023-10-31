<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract\Output;

interface IBufferedOutput
{
    /**
     * Flushes the output buffer.
     */
    public function flush(): void;

    public function append(iterable|string $messages, bool $newline = false): IBufferedOutput;
}

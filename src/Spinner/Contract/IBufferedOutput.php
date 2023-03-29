<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface IBufferedOutput extends IOutput
{
    /**
     * Flushes the output buffer.
     */
    public function flush(): void;

    public function bufferedWrite(iterable|string $messages, bool $newline = false): IBufferedOutput;
}

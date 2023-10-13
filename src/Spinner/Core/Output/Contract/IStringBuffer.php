<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output\Contract;

use Generator;

interface IStringBuffer
{
    /**
     * Writes message to buffer.
     */
    public function write(iterable|string $message): IStringBuffer;

    /**
     * Returns buffer content and flushes it.
     */
    public function flush(): Generator;
}

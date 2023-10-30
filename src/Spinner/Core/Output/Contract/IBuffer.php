<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output\Contract;

use Generator;

interface IBuffer
{
    /**
     * Appends message to buffer.
     */
    public function append(iterable|string $message): IBuffer;

    /**
     * Yields buffer content and clears buffer.
     */
    public function flush(): Generator;
}

<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output\Contract;

use Generator;

interface IStringBuffer
{
    /**
     * Appends message to buffer.
     */
    public function append(iterable|string $message): IStringBuffer;

    /**
     * Yields buffer content and clears buffer.
     */
    public function flush(): Generator;
}

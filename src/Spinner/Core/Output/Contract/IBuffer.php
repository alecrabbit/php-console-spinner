<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output\Contract;

use Traversable;

interface IBuffer
{
    /**
     * Appends message to buffer.
     *
     * @psalm-param iterable<string>|string $message
     */
    public function append(iterable|string $message): IBuffer;

    /**
     * Yields buffer content and clears buffer.
     *
     * @return Traversable<string>
     */
    public function flush(): Traversable;
}

<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output;

use AlecRabbit\Spinner\Core\Output\Contract\IBuffer;
use Generator;

use function is_iterable;

final class StringBuffer implements IBuffer
{
    public function __construct(
        protected string $buffer = '',
    ) {
    }

    public function flush(): Generator
    {
        yield $this->buffer;
        $this->buffer = '';
    }

    public function append(iterable|string $message): IBuffer
    {
        if (!is_iterable($message)) {
            $message = [$message];
        }
        /** @var string $item */
        foreach ($message as $item) {
            $this->buffer .= $item;
        }
        return $this;
    }
}

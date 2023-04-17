<?php

declare(strict_types=1);

// 28.03.23
namespace AlecRabbit\Spinner\Core\Output;

use AlecRabbit\Spinner\Core\Output\Contract\IStringBuffer;
use Generator;

use function is_iterable;

final class StringBuffer implements IStringBuffer
{
    public function __construct(protected string $buffer = '')
    {
    }

    public function flush(): Generator
    {
        yield $this->buffer;
        $this->buffer = '';
    }

    public function write(iterable|string $message): IStringBuffer
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

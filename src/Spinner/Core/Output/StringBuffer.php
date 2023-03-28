<?php

declare(strict_types=1);
// 28.03.23
namespace AlecRabbit\Spinner\Core\Output;

use AlecRabbit\Spinner\Core\Output\Contract\IStringBuffer;
use Generator;

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

    public function write(string $message): IStringBuffer
    {
        $this->buffer .= $message;
        return $this;
    }
}
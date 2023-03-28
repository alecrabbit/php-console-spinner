<?php

declare(strict_types=1);
// 28.03.23
namespace AlecRabbit\Spinner\Core\Output;

use AlecRabbit\Spinner\Core\Output\Contract\IOutputBuffer;

final class OutputBuffer implements IOutputBuffer
{
    public function __construct(
        protected string $buffer = '',
        protected bool $closed = false,
    ) {
    }

    public function flush(): string
    {
        if ($this->isClosed()) {
            return '';
        }
        $buffer = $this->buffer;
        $this->close();
        return $buffer;
    }

    protected function isClosed(): bool
    {
        return $this->closed;
    }

    protected function close(): void
    {
        $this->closed = true;
        $this->buffer = '';
    }

    public function write(string $message): IOutputBuffer
    {
        $this->buffer .= $message;
        return $this;
    }
}
<?php

declare(strict_types=1);
// 28.03.23
namespace AlecRabbit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\IOutput;
use AlecRabbit\Spinner\Core\Output\Contract\IOutputBuffer;

final class OutputBuffer implements IOutputBuffer
{
    protected string $buffer = '';
    protected bool $closed = false;

    public function __construct(
        protected readonly IOutput $output
    ) {
    }

    public function flush(): void
    {
        if ($this->isClosed()) {
            return;
        }
        $this->output->write($this->buffer);
        $this->close();
    }

    protected function isClosed(): bool
    {
        return $this->closed;
    }

    public function write(string $message): IOutputBuffer
    {
        $this->buffer .= $message;
        return $this;
    }

    protected function close(): void
    {
        $this->closed = true;
        $this->buffer = '';
    }
}
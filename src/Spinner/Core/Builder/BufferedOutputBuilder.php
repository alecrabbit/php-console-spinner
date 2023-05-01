<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Builder;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use AlecRabbit\Spinner\Core\Contract\IBufferedOutputBuilder;
use AlecRabbit\Spinner\Core\Output\StreamBufferedOutput;
use AlecRabbit\Spinner\Exception\LogicException;

final class BufferedOutputBuilder implements IBufferedOutputBuilder
{
    private ?IResourceStream $stream = null;

    public function build(): IBufferedOutput
    {
        $this->validate();

        return new StreamBufferedOutput($this->stream);
    }

    private function validate(): void
    {
        if ($this->stream === null) {
            throw new LogicException('Stream is not set.');
        }
    }

    public function withStream(IResourceStream $stream): IBufferedOutputBuilder
    {
        $clone = clone $this;
        $clone->stream = $stream;
        return $clone;
    }
}

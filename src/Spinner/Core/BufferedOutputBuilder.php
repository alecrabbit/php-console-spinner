<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use AlecRabbit\Spinner\Core\Contract\IBufferedOutputBuilder;
use AlecRabbit\Spinner\Core\Output\ResourceStream;
use AlecRabbit\Spinner\Core\Output\StreamBufferedOutput;
use AlecRabbit\Spinner\Exception\LogicException;

final class BufferedOutputBuilder implements IBufferedOutputBuilder
{
    protected ?IResourceStream $stream = null;

    public function build(): IBufferedOutput
    {
        $this->validate();

        return
            new StreamBufferedOutput($this->stream);
    }

    protected function validate(): void
    {
        if (null === $this->stream) {
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

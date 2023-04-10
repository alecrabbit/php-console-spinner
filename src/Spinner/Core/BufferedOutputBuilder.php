<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use AlecRabbit\Spinner\Core\Contract\IBufferedOutputBuilder;
use AlecRabbit\Spinner\Core\Output\ResourceStream;
use AlecRabbit\Spinner\Core\Output\StreamBufferedOutput;
use AlecRabbit\Spinner\Exception\LogicException;

final class BufferedOutputBuilder implements IBufferedOutputBuilder
{
    /** @var null|resource */
    protected $streamHandler = null; // remove [d68322c7-932f-4d63-afa9-7c5cc0dacba6]

    protected ?IResourceStream $stream = null;

    public function build(): IBufferedOutput
    {
        {
            // FIXME (2023-04-10 14:19) [Alec Rabbit]: remove this block [d68322c7-932f-4d63-afa9-7c5cc0dacba6]
            if (null === $this->stream) {
                if (null === $this->streamHandler) {
                    throw new LogicException('Stream is not set.');
                }
                $this->stream = new ResourceStream($this->streamHandler);
            }
        }

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

    /**
     * @codeCoverageIgnore
     */
    public function withStreamHandler($stream): IBufferedOutputBuilder
    {
        // FIXME (2023-04-10 14:18) [Alec Rabbit]: remove this method [d68322c7-932f-4d63-afa9-7c5cc0dacba6]
        $clone = clone $this;
        $clone->streamHandler = $stream;
        return $clone;
    }

    public function withStream(IResourceStream $stream): IBufferedOutputBuilder
    {
        $clone = clone $this;
        $clone->stream = $stream;
        return $clone;
    }
}

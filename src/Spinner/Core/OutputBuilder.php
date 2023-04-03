<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IOutput;
use AlecRabbit\Spinner\Core\Contract\IOutputBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\IOutputFactory;
use AlecRabbit\Spinner\Core\Output\ResourceStream;
use AlecRabbit\Spinner\Core\Output\StreamBufferedOutput;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Spinner\Helper\Asserter;

final class OutputBuilder implements IOutputBuilder
{
    /** @var null|resource */
    protected $stream = null;

    public function build(): IOutput
    {
        $this->assert();

        return
            new StreamBufferedOutput(
                new ResourceStream($this->stream)
            );
    }

    protected function assert(): void
    {
        if (null === $this->stream) {
            throw new LogicException('Stream is not set.');
        }
    }

    public function withStream($stream): IOutputBuilder
    {
        Asserter::assertStream($stream);
        $clone = clone $this;
        $clone->stream = $stream;
        return $clone;
    }
}
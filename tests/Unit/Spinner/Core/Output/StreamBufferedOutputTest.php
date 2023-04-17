<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use AlecRabbit\Spinner\Core\Output\StreamBufferedOutput;
use AlecRabbit\Spinner\Core\Output\StringBuffer;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class StreamBufferedOutputTest extends TestCase
{
    #[Test]
    public function canBeCreated(): void
    {
        $streamBufferedOutput = $this->getTesteeInstance(stream: null);

        self::assertInstanceOf(StreamBufferedOutput::class, $streamBufferedOutput);
    }

    public function getTesteeInstance(
        (MockObject & IResourceStream)|null $stream,
        ?StringBuffer $buffer = null,
    ): IBufferedOutput {
        if ($buffer === null) {
            return new StreamBufferedOutput(
                stream: $stream ?? $this->getStreamMock(),
            );
        }
        return new StreamBufferedOutput(
            stream: $stream ?? $this->getStreamMock(),
            buffer: $buffer
        );
    }

    #[Test]
    public function callingWriteInvokesStreamWrite(): void
    {
        $stream = $this->getStreamMock();
        $stream
            ->expects(self::once())
            ->method('write')
        ;

        $streamBufferedOutput = $this->getTesteeInstance(stream: $stream);

        $streamBufferedOutput->write('test');
    }

    #[Test]
    public function callingWritelnInvokesStreamWrite(): void
    {
        $stream = $this->getStreamMock();
        $stream
            ->expects(self::once())
            ->method('write')
        ;

        $streamBufferedOutput = $this->getTesteeInstance(stream: $stream);

        $streamBufferedOutput->writeln('test');
    }

    #[Test]
    public function canWriteTraversable(): void
    {
        $stream = $this->getStreamMock();
        $stream
            ->expects(self::once())
            ->method('write')
        ;

        $streamBufferedOutput = $this->getTesteeInstance(stream: $stream);

        $streamBufferedOutput->writeln(['test', 'test2']);
    }

    #[Test]
    public function canDoIterableBufferedWrite(): void
    {
        $stream = $this->getStreamMock();
        $stream
            ->expects(self::once())
            ->method('write')
        ;

        $streamBufferedOutput = $this->getTesteeInstance(stream: $stream);

        $streamBufferedOutput->bufferedWrite(['test', 'test2'])->flush();
    }

    private function getStreamMock(): MockObject&IResourceStream
    {
        return $this->createMock(IResourceStream::class);
    }
}

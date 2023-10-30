<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use AlecRabbit\Spinner\Core\Output\Contract\IBuffer;
use AlecRabbit\Spinner\Core\Output\BufferedOutput;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class BufferedOutputTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $streamBufferedOutput = $this->getTesteeInstance(stream: null);

        self::assertInstanceOf(BufferedOutput::class, $streamBufferedOutput);
    }

    public function getTesteeInstance(
        ?IResourceStream $stream = null,
        ?IBuffer $buffer = null,
    ): IBufferedOutput {
        return
            new BufferedOutput(
            stream: $stream ?? $this->getStreamMock(),
            buffer: $buffer ?? $this->getBufferMock(),
        );
    }

    private function getStreamMock(): MockObject&IResourceStream
    {
        return $this->createMock(IResourceStream::class);
    }

    private function getBufferMock(): MockObject&IBuffer
    {
        return $this->createMock(IBuffer::class);
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

        $streamBufferedOutput->append(['test', 'test2'])->flush();
    }
}

<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Output;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Core\Output\BufferedOutput;
use AlecRabbit\Spinner\Core\Output\Contract\IBuffer;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Traversable;

final class BufferedOutputTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $outputBufferedOutput = $this->getTesteeInstance();

        self::assertInstanceOf(BufferedOutput::class, $outputBufferedOutput);
    }

    public function getTesteeInstance(
        ?IOutput $output = null,
        ?IBuffer $buffer = null,
    ): IBufferedOutput {
        return
            new BufferedOutput(
                output: $output ?? $this->getOutputMock(),
                buffer: $buffer ?? $this->getBufferMock(),
            );
    }

    private function getOutputMock(): MockObject&IOutput
    {
        return $this->createMock(IOutput::class);
    }

    private function getBufferMock(): MockObject&IBuffer
    {
        return $this->createMock(IBuffer::class);
    }

    #[Test]
    public function canAppend(): void
    {
        $msg = 'test';
        $buffer = $this->getBufferMock();
        $buffer
            ->expects(self::once())
            ->method('append')
            ->with($msg)
        ;

        $bufferedOutput = $this->getTesteeInstance(buffer: $buffer);

        self::assertSame($bufferedOutput, $bufferedOutput->append($msg));
    }

    #[Test]
    public function canWrite(): void
    {
        $traversable = $this->getTraversableMock();
        $buffer = $this->getBufferMock();
        $buffer
            ->expects(self::once())
            ->method('flush')
            ->willReturn($traversable)
        ;
        $output = $this->getOutputMock();
        $output
            ->expects(self::once())
            ->method('write')
            ->with($traversable)
        ;

        $bufferedOutput =
            $this->getTesteeInstance(
                output: $output,
                buffer: $buffer,
            );

        $bufferedOutput->flush();
    }

    private function getTraversableMock(): MockObject&Traversable
    {
        return $this->createMock(Traversable::class);
    }
}

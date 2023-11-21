<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Factory;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateWriterBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\IConsoleCursorFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISequenceStateWriterFactory;
use AlecRabbit\Spinner\Core\Factory\SequenceStateWriterFactory;
use AlecRabbit\Spinner\Core\Output\Contract\ISequenceStateWriter;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;

final class SequenceStateWriterFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $sequenceStateWriterFactory = $this->getTesteeInstance();

        self::assertInstanceOf(SequenceStateWriterFactory::class, $sequenceStateWriterFactory);
    }

    public function getTesteeInstance(
        ?ISequenceStateWriterBuilder $sequenceStateWriterBuilder = null,
        ?IBufferedOutput $bufferedOutput = null,
        ?IConsoleCursorFactory $cursorFactory = null,
    ): ISequenceStateWriterFactory {
        return
            new SequenceStateWriterFactory(
                sequenceStateWriterBuilder: $sequenceStateWriterBuilder ?? $this->getSequenceStateWriterBuilderMock(),
                bufferedOutput: $bufferedOutput ?? $this->getBufferedOutputMock(),
                cursorFactory: $cursorFactory ?? $this->getCursorFactoryMock(),
            );
    }

    protected function getSequenceStateWriterBuilderMock(): MockObject&ISequenceStateWriterBuilder
    {
        return $this->createMock(ISequenceStateWriterBuilder::class);
    }

    protected function getBufferedOutputMock(): MockObject&IBufferedOutput
    {
        return $this->createMock(IBufferedOutput::class);
    }

    protected function getCursorFactoryMock(): MockObject&IConsoleCursorFactory
    {
        return $this->createMock(IConsoleCursorFactory::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $sequenceStateWriterBuilder = $this->getSequenceStateWriterBuilderMock();
        $sequenceStateWriterBuilder
            ->expects(self::once())
            ->method('withOutput')
            ->willReturnSelf()
        ;
        $sequenceStateWriterBuilder
            ->expects(self::once())
            ->method('withCursor')
            ->willReturnSelf()
        ;
        $sequenceStateWriterStub = $this->getSequenceStateWriterStub();
        $sequenceStateWriterBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($sequenceStateWriterStub)
        ;

        $cursorFactory = $this->getCursorFactoryMock();

        $cursorFactory
            ->expects(self::once())
            ->method('create')
        ;

        $sequenceStateWriterFactory = $this->getTesteeInstance(
            sequenceStateWriterBuilder: $sequenceStateWriterBuilder,
            cursorFactory: $cursorFactory,
        );

        self::assertSame($sequenceStateWriterStub, $sequenceStateWriterFactory->create());
    }

    protected function getSequenceStateWriterStub(): Stub&ISequenceStateWriter
    {
        return $this->createStub(ISequenceStateWriter::class);
    }
}

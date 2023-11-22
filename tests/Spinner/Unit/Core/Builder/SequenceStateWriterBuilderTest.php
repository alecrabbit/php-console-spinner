<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Builder;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateWriterBuilder;
use AlecRabbit\Spinner\Core\Builder\SequenceStateWriterBuilder;
use AlecRabbit\Spinner\Core\Output\Contract\IConsoleCursor;
use AlecRabbit\Spinner\Core\Output\SequenceStateWriter;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class SequenceStateWriterBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $outputBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(SequenceStateWriterBuilder::class, $outputBuilder);
    }

    public function getTesteeInstance(): ISequenceStateWriterBuilder
    {
        return new SequenceStateWriterBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $outputBuilder = $this->getTesteeInstance();

        $output =
            $outputBuilder
                ->withOutput($this->getBufferedOutputMock())
                ->withCursor($this->getCursorMock())
                ->build()
        ;

        self::assertInstanceOf(SequenceStateWriter::class, $output);
    }

    protected function getBufferedOutputMock(): MockObject&IBufferedOutput
    {
        return $this->createMock(IBufferedOutput::class);
    }

    protected function getCursorMock(): MockObject&IConsoleCursor
    {
        return $this->createMock(IConsoleCursor::class);
    }

    #[Test]
    public function throwsIfCursorIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Cursor is not set.';

        $test = function (): void {
            $outputBuilder = $this->getTesteeInstance();

            $outputBuilder
                ->withOutput($this->getBufferedOutputMock())
                ->build()
            ;
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfOutputIsNotSet(): void
    {
        $test = function (): void {
            $outputBuilder = $this->getTesteeInstance();

            $outputBuilder
                ->withCursor($this->getCursorMock())
                ->build()
            ;
        };

        $this->wrapExceptionTest(
            $test,
            LogicException::class,
            'Output is not set.',
        );
    }
}

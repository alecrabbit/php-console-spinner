<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Contract\Output\IWritableStream;
use AlecRabbit\Spinner\Core\Output\Output;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Traversable;

final class OutputTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $output = $this->getTesteeInstance();

        self::assertInstanceOf(Output::class, $output);
    }

    public function getTesteeInstance(
        ?IWritableStream $stream = null,
    ): IOutput {
        return
            new Output(
                stream: $stream ?? $this->getStreamMock(),
            );
    }

    private function getStreamMock(): MockObject&IWritableStream
    {
        return $this->createMock(IWritableStream::class);
    }

    #[Test]
    public function canWrite(): void
    {
        $stream = $this->getStreamMock();
        $stream
            ->expects(self::once())
            ->method('write')
            ->with(self::isInstanceOf(Traversable::class))
        ;

        $output = $this->getTesteeInstance(
            stream: $stream
        );

        $output->write('test');
    }

    #[Test]
    public function canWriteln(): void
    {
        $stream = $this->getStreamMock();
        $stream
            ->expects(self::once())
            ->method('write')
            ->with(self::isInstanceOf(Traversable::class))
        ;

        $output = $this->getTesteeInstance(
            stream: $stream
        );

        $output->writeln('test');
    }
}

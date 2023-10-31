<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use AlecRabbit\Spinner\Core\Output\Contract\IConsoleCursor;
use AlecRabbit\Spinner\Core\Output\Output;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class OutputTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $output = $this->getTesteeInstance();

        self::assertInstanceOf(Output::class, $output);
    }

    public function getTesteeInstance(
        ?IResourceStream $stream = null,
    ): IOutput {
        return
            new Output(
                stream: $stream ?? $this->getStreamMock(),
            );
    }

    private function getStreamMock(): MockObject&IResourceStream
    {
        return $this->createMock(IResourceStream::class);
    }

    #[Test]
    public function canWrite(): void
    {
        $stream = $this->getStreamMock();
        $stream
            ->expects(self::once())
            ->method('write')
            ->with(self::isInstanceOf(\Traversable::class))
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
            ->with(self::isInstanceOf(\Traversable::class))
        ;

        $output = $this->getTesteeInstance(
            stream: $stream
        );

        $output->writeln('test');
    }
}
